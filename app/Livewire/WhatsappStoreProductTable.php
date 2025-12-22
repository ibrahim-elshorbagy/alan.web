<?php

namespace App\Livewire;

use App\Models\WhatsappStoreProduct;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class WhatsappStoreProductTable extends LivewireTableComponent
{
    protected $model = WhatsappStoreProduct::class;


    public bool $showButtonOnHeader = true;

    protected $listeners = ['refresh' => '$refresh', 'resetPageTable'];

    public string $buttonComponent = 'whatsapp_stores.products.add-button';

    public $whatsappStoreId;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('whatsapp-store-product-table');
        $this->setDefaultSort('created_at','desc');
        $this->setColumnSelectStatus(false);
        $this->setQueryStringStatus(false);
        $this->resetPage('whatsapp-store-product-table');

        $this->setThAttributes(function(Column $column) {
            if ($column->isField('id')) {
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
            Column::make('currency', 'currency_id')
                ->hideIf(1),
            Column::make(__('messages.vcard.product_name'), "name")
                ->searchable()
                ->sortable(),
            Column::make(__('messages.whatsapp_stores.category'), "category_id")
                ->searchable()
                ->format(fn($value, $row) => $row->category?->name ?? '-')
                ->sortable(),
            Column::make(__('messages.whatsapp_stores.selling_price'), "selling_price")
                ->view('whatsapp_stores.products.columns.selling_price')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.whatsapp_stores.net_price'), "net_price")
                ->searchable()
                ->view('whatsapp_stores.products.columns.net_price')
                ->sortable(),
            Column::make(__('messages.whatsapp_stores.available_stock'), "available_stock")
                ->searchable()
                ->view('whatsapp_stores.products.columns.available_stock')
                ->sortable(),
            Column::make(__('messages.common.action'), "id")
                ->view('whatsapp_stores.products.columns.action'),

        ];
    }

    public function builder(): Builder
    {
        return WhatsappStoreProduct::where('whatsapp_store_id',$this->whatsappStoreId);
    }

    public function placeholder()
    {
        return view('lazy_loading.without-filter-skelecton');
    }
}
