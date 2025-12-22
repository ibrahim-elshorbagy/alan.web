<?php

namespace App\Livewire;

use App\Models\ProductCategory;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class ProductCategoriesTable extends LivewireTableComponent
{
    protected $model = ProductCategory::class;

    public bool $showButtonOnHeader = true;

    protected $listeners = ['refresh' => '$refresh', 'resetPageTable'];

    public string $buttonComponent = 'whatsapp_stores.products_category.add-button';

    public $whatsappStoreId;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('product-categories-table');
        $this->setDefaultSort('created_at', 'desc');
        $this->setColumnSelectStatus(false);
        $this->setQueryStringStatus(false);
        $this->resetPage('whatsapp-store-product-table');
        
        
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.common.icon'), "id")
                ->view('whatsapp_stores.products_category.columns.image'),
            Column::make(__('messages.common.name'), "name")
                ->searchable()
                ->sortable(),
            Column::make(__('messages.whatsapp_stores.product_count'), "created_at")
                ->view('whatsapp_stores.products_category.columns.products_count')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.common.action'), "updated_at")
                ->view('whatsapp_stores.products_category.columns.action'),
        ];
    }

    public function builder(): Builder
    {
        return ProductCategory::query()
            ->where('whatsapp_store_id', $this->whatsappStoreId)
            ->withCount('products');
    }

    public function placeholder()
    {
        return view('lazy_loading.without-filter-skelecton');
    }
}
