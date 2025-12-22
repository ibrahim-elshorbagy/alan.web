<?php

namespace App\Livewire;

use App\Models\WpOrder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class WpProductTransactionsTable extends LivewireTableComponent
{

    protected $model = WpOrder::class;
    public $storeId = null;
    protected $listeners = ['refresh' => '$refresh', 'changeFilterStore'];
    public bool $showButtonOnHeader = true;
    public string $buttonComponent = 'wp_product_transactions.filter';

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('wp-product-transactions-table');
        $this->setDefaultSort('created_at', 'desc');
        $this->setQueryStringStatus(false);
        $this->setColumnSelectStatus(false);
        $this->resetPage('wp-product-transactions-table');
        $this->setThAttributes(function (Column $column) {
            if ($column->isField('id')) {
                return [
                    'class' => 'd-flex justify-content-center',
                ];
            }

            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__("messages.whatsapp_stores.store_name"), "wp_store_id")
                ->view('wp_product_transactions.column.wp_store_id')
                ->searchable()
                ->sortable(),

            Column::make(__("messages.whatsapp_stores.order_id"), "order_id")
                ->view('wp_product_transactions.column.order_id')
                ->searchable()
                ->sortable(),

            Column::make(__("messages.common.name"), "name")
                ->searchable()
                ->sortable(),

            Column::make(__("messages.common.phone"), "phone")
                ->view('wp_product_transactions.column.phone')
                ->searchable(),

            Column::make(__('messages.common.status'), "status")
                ->view('wp_product_transactions.column.status'),

            Column::make("Region code", "region_code")->hideIf(1),

            Column::make(__('messages.whatsapp_stores.order_date'), "created_at")
                ->view('wp_product_transactions.column.created_at')
                ->sortable(),

            Column::make(__('messages.whatsapp_stores.amount'), "grand_total")
                ->sortable(),

            Column::make(__('messages.common.action'), "id")
                ->view('wp_product_transactions.column.action'),
        ];
    }


    public function builder(): Builder
    {
        return WpOrder::with('wpStore')
            ->whereHas('wpStore', function ($query) {
                $query->where('tenant_id', getLogInTenantId());

                if ($this->storeId) {
                    $query->where('id', $this->storeId);
                }
            })
            ->select('wp_orders.*');
    }

    public function changeFilterStore($id)
    {
        $this->storeId = $id;
        $this->setBuilder($this->builder());
    }
    public function placeholder()
    {
        return view('lazy_loading.without-filter-skelecton');
    }
}