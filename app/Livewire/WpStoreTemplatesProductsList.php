<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\WhatsappStore;
use App\Models\ProductCategory;
use App\Models\WhatsappStoreProduct;
use Request;

class WpStoreTemplatesProductsList extends Component
{
    use WithPagination;

    public $whatsappStoreId;
    public $search = '';
    public $dateFilter;
    public $minPrice;
    public $maxPrice;
    public $priceSortOrder = '';
    public $selectedCategory = null;
    public $category = null;
    public $categoryFilter = [];
    public $categorySelected = null;
    public $categorySelectedFilter = [];


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }
    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function applyPriceFilter()
    {
        $this->resetPage();
    }

    public function setPriceSortOrder($order)
    {
        $this->priceSortOrder = $order;
        $this->resetPage();
    }

    public function setCategory($categoryId)
    {
        $this->selectedCategory = $this->selectedCategory == $categoryId ? null : $categoryId;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'dateFilter', 'minPrice', 'maxPrice', 'priceSortOrder', 'selectedCategory', 'categoryFilter']);
        $this->resetPage();
    }



    public function render()
    {

        $dateLimit = match ($this->dateFilter) {
            '3_days' => now()->subDays(3),
            '1_week' => now()->subWeek(),
            '1_month' => now()->subMonth(),
            '6_months' => now()->subMonths(6),
            '1_year' => now()->subYear(),
            default => null,
        };


        $this->category = isset(request()->category) ?  request()->category : null;

        $this->categorySelected = $this->category ?? $this->selectedCategory;
        $this->categorySelectedFilter = array_merge(
            is_array($this->categoryFilter) ? $this->categoryFilter : [],
            $this->category ? [$this->category] : []
        );
        $this->categoryFilter = $this->categorySelectedFilter;

        $whatsappStoreId = $this->whatsappStoreId;
        $urlAlias = WhatsappStore::where('id', $whatsappStoreId)->value('url_alias');
        $template = WhatsappStore::where('id', $whatsappStoreId)->first()?->template?->name;
        $whatsappStore = WhatsappStore::find($this->whatsappStoreId);
        $perPage = ($template === 'travel') ? 5 : 9;

        $products = WhatsappStoreProduct::where('whatsapp_store_id', $this->whatsappStoreId)
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->when($dateLimit, fn($query) => $query->where('created_at', '>=', $dateLimit))
            ->when($this->minPrice, fn($query) => $query->where('selling_price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($query) => $query->where('selling_price', '<=', $this->maxPrice))
            ->when(!empty($this->categorySelectedFilter), fn($query) => $query->whereIn('category_id', $this->categorySelectedFilter))
            ->when($this->categorySelected, fn($query) => $query->where('category_id', $this->categorySelected))
            ->when($this->priceSortOrder, function ($query) {
                if ($this->priceSortOrder === '1') {
                    $query->orderBy('selling_price', 'asc'); // Low to High
                } elseif ($this->priceSortOrder === '2') {
                    $query->orderBy('selling_price', 'desc'); // High to Low
                }
            })
            ->paginate($perPage);

        $categories = ProductCategory::where('whatsapp_store_id', $this->whatsappStoreId)->get();

        return view('livewire.whatsapp_store.' . $template, compact('products', 'categories', 'whatsappStoreId', 'urlAlias','whatsappStore'));
    }
}
