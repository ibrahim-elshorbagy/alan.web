<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Vcard;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\NfcOrders;
use App\Models\VcardBlog;
use App\Models\Withdrawal;
use App\Models\MultiTenant;
use App\Models\Testimonial;
use App\Models\VcardService;
use App\Models\AffiliateUser;
use Illuminate\Support\Facades\DB;
use App\Models\NfcOrderTransaction;
use Illuminate\Support\Facades\Log;
use App\Models\WithdrawalTransaction;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UserTable extends LivewireTableComponent
{
protected $model = User::class;
    public bool $showButtonOnHeader = true;
    public string $buttonComponent = 'users.add-button';

    protected $listeners = ['statusFilter', 'resetPageTable', 'deleteUser'];
    public $status;
    public $selectedRecordId;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('user-table');
        $this->setDefaultSort('created_at', 'desc');
        $this->setSortingPillsStatus(false);
        $this->setQueryStringStatus(false);
        $this->resetPage('user-table');

        $this->setThAttributes(function (Column $column) {

            if ($column->isField('first_name')) {
                return [
                    'class' => 'bg-red',
                ];
            }

            // if ($column->getTitle() == __('messages.subscription.current_plan')) {
            //     return [
            //         'class' => 'text-start',
            //     ];
            // }

            if ($column->isField('email_verified_at')  || $column->isField('is_active') || $column->isField('created_at')) {
                return [
                    'class' => 'text-center',
                ];
            }
            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.user.full_name'), 'first_name')
                ->searchable(function (Builder $query, $direction) {
                    $query->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                })->sortable()->view('users.columns.full_name'),
            Column::make(__('messages.user.full_name'), 'last_name')->sortable()->searchable()->hideIf(1),
            Column::make(
                __('messages.subscription.current_plan'),
                'id'
            )->searchable()->view('users.columns.current_plan'),
            Column::make('email','email')->hideIf(1)->searchable(),
            Column::make(__('messages.user.tenant_id'), 'tenant_id')->hideIf(1),
            Column::make(__('messages.user.email_verified'), 'email_verified_at')->view('users.columns.email_verified'),
            Column::make(__('messages.user.impersonate'), 'id')->view('users.columns.impersonate'),
            Column::make(__('messages.common.is_active'), 'is_active')->view('users.columns.is_active'),
            Column::make(__('messages.common.action'), 'created_at')->view('users.columns.action'),

        ];
    }

    public function statusFilter($status)
    {
        $this->status = $status;
        $this->setBuilder($this->builder());
    }

    public function builder(): Builder
    {
        $status = $this->status;
        $query =  User::role('admin')->with(['media', 'subscriptions.plan'])->where('users.id', '!=', getLogInUserId());

        $query->when($status != "", function ($q) use ($status) {
            if ($status == User::IS_ACTIVE) {
                $q->where('is_active', User::IS_ACTIVE);
            }
            if ($status == User::DEACTIVATE) {
                $q->where('is_active', User::DEACTIVATE);
            }
        });

        return $query->select('users.*');
    }

    public array $bulkActions = [
        'bulkDelete' => 'Delete',
    ];
    public function setSelectedRecord($recordId)
    {
        $this->selectedRecordId = $recordId;
    }

    public function bulkDelete()
    {
        if (count($this->getSelected()) > 0) {
            $userIds = $this->getSelected();
            $this->dispatch('bulk-delete-user', $userIds);
        } else {
            $this->dispatch('bulk-delete-error');
        }
    }
    public function deleteUser($userIds)
    {
        try {
            foreach ($userIds as $userId) {
                $user = User::find($userId);
                if ($user) {
                    $this->userDataDelete($user);
                }
            }

            $this->setBuilder($this->builder());
            $this->dispatch('delete-user-success');
            $this->clearSelected();
        } catch (\Exception $e) {
            Log::error('Bulk user deletion failed: ' . $e->getMessage());
        }
    }


    private function userDataDelete(User $user)
    {
        if ($user->getRoleNames()[0] == 'admin') {
            DB::transaction(function () use ($user) {
                $withdrawals = Withdrawal::whereUserId($user->id)->get();
                foreach ($withdrawals as $withdrawal) {
                    $withdrawalTransactions = WithdrawalTransaction::where('withdrawal_id', $withdrawal->id)->get();
                    foreach ($withdrawalTransactions as $transaction) {
                        $transaction->delete();
                    }
                    $withdrawal->delete();
                }

                $affiliateUsers = AffiliateUser::whereUserId($user->id)->orWhere('affiliated_by', $user->id)->get();
                foreach ($affiliateUsers as $affiliateUser) {
                    $affiliateUser->delete();
                }

                NfcOrderTransaction::where('user_id', $user->id)->delete();

                $user = User::find($user->id);
                //product delete
                $products = Product::whereHas('vcard', function ($query) use ($user) {
                    $query->where('tenant_id', $user->tenant_id);
                })->get();

                foreach ($products as $product) {

                    $mediaFiles = $product->getMedia('image');

                    foreach ($mediaFiles as $mediaFile) {
                        $mediaFile->delete();
                    }

                    $product->delete();
                }

                //testimonial delete
                $user = User::find($user->id);

                $testimonials = Testimonial::whereHas('vcard', function ($query) use ($user) {
                    $query->where('tenant_id', $user->tenant_id);
                })->get();

                foreach ($testimonials as $testimonial) {

                    $mediaFiles = $testimonial->getMedia('image');

                    foreach ($mediaFiles as $mediaFile) {
                        $mediaFile->delete();
                    }

                    $testimonial->delete();
                }

                // blog delete
                $user = User::find($user->id);

                $blogs = VcardBlog::whereHas('vcard', function ($query) use ($user) {
                    $query->where('tenant_id', $user->tenant_id);
                })->get();

                foreach ($blogs as $blog) {

                    $mediaFiles = $blog->getMedia('image');

                    foreach ($mediaFiles as $mediaFile) {
                        $mediaFile->delete();
                    }

                    $blog->delete();
                }

                // service delete
                $user = User::find($user->id);

                $services = VcardService::whereHas('vcard', function ($query) use ($user) {
                    $query->where('tenant_id', $user->tenant_id);
                })->get();

                foreach ($services as $service) {

                    $mediaFiles = $service->getMedia('service_icon');

                    foreach ($mediaFiles as $mediaFile) {
                        $mediaFile->delete();
                    }

                    $service->delete();
                }

                // gallery delete
                $user = User::find($user->id);

                $gallaries = Gallery::whereHas('vcard', function ($query) use ($user) {
                    $query->where('tenant_id', $user->tenant_id);
                })->get();

                foreach ($gallaries as $gallery) {

                    $mediaFiles = $gallery->getMedia('image');

                    foreach ($mediaFiles as $mediaFile) {
                        $mediaFile->delete();
                    }

                    $gallery->delete();
                }

                //nfcOrder delete
                $nfcOrders = NfcOrders::where('user_id', $user->id)->get();

                foreach ($nfcOrders as $nfcOrder) {
                    $mediaFiles = $nfcOrder->getMedia('logo');
                    foreach ($mediaFiles as $mediaFile) {
                        $mediaFile->delete();
                    }
                    $nfcOrder->delete();
                }

                $vcards = Vcard::where('tenant_id', $user->tenant_id)->get();
                foreach ($vcards as $vcard) {
                    $mediaFiles = $vcard->getMedia('profile ');
                    foreach ($mediaFiles as $mediaFile) {
                        $mediaFile->delete();
                    }
                    $vcard->delete();
                }

                MultiTenant::where('id', $user->tenant_id)->delete();

                $user->delete();
            });
        }
    }
    public function resetPageTable($pageName = 'user-table')
    {
        $rowsPropertyData = $this->getRows()->toArray();
        $prevPageNum = $rowsPropertyData['current_page'] - 1;
        $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
        $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;

        $this->setPage($pageNum, $pageName);
    }
    public function placeholder()
    {
        return view('lazy_loading.listing-skelecton');
    }
}
