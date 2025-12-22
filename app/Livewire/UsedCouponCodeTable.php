<?php

namespace App\Livewire;

use App\Models\Plan;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Models\Subscription;

class UsedCouponCodeTable extends LivewireTableComponent
{
    protected $model = Subscription::class;

    public function configure(): void
    {
        $this->setPrimaryKey('subscription_id');
        $this->setPageName('used-coupon-code-table');
        $this->setDefaultSort('id', 'desc');
        $this->setColumnSelectStatus(false);
        $this->setQueryStringStatus(false);
        $this->resetPage('used-coupon-code-table');

        $this->setTdAttributes(function (Column $column) {
            if ($column->isField('id')) {
                return [
                    'class' => 'justify-content-center d-flex',
                ];
            }
            return [];
        });

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('id')) {
                return [
                    'class' => 'justify-content-center d-flex',
                ];
            }
            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.vcard.user_name'), 'tenant.user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(
                        User::select('first_name')->whereColumn('subscriptions.tenant_id', 'users.tenant_id'),
                        $direction
                    );
                })->searchable(
                    function (Builder $query, $direction) {
                        return $query->whereHas('tenant.user', function (Builder $q) use ($direction) {
                            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                        });
                    }
                )->view('sadmin.used_coupon_code.columns.user_name'),
            Column::make(__('messages.coupon_code.used_at'), 'starts_at')
                ->sortable()->view('sadmin.used_coupon_code.columns.used_at'),
            Column::make(__('messages.subscription.plan_name'), 'plan.name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(
                        Plan::select('name')->whereColumn('id', 'plan_id'),
                        $direction
                    );
                })->searchable()->view('sadmin.used_coupon_code.columns.plan_name'),

            Column::make(__('messages.common.total_amount'), 'discount')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.coupon_code.coupon_name'), 'coupon_code_meta')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderByRaw("JSON_EXTRACT(coupon_code_meta, '$.couponCode') $direction");
                })->searchable()->view('sadmin.used_coupon_code.columns.coupon_code'),
            Column::make(__('messages.common.action'), 'id')->hideIf(1),
            Column::make('plan_id', 'plan_id')->hideIf(1),
            Column::make('tenant_id', 'tenant_id')->hideIf(1)
        ];
    }

    public function builder(): Builder
    {
        return Subscription::with(['tenant.user', 'plan.currency'])
            ->whereNotNull('coupon_code_meta');
    }
    public function placeholder()
    {
        return view('lazy_loading.without-listing-skelecton');
    }
}
