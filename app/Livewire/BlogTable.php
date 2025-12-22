<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Blog;
use App\Livewire\LivewireTableComponent;
use Illuminate\Database\Eloquent\Builder;

class BlogTable extends LivewireTableComponent
{
    protected $model = Blog::class;

    public bool $showButtonOnHeader = true;
    public string $buttonComponent = 'sadmin.blog.add-button';
    protected $listeners = ['refresh', 'statusFilter', 'resetPageTable'];
    public $status;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setThAttributes(function (Column $column) {
            if ($column->isField('status')) {
                return [
                    'class' => 'd-flex justify-content-center',
                ];
            }

            return [
                'class' => 'text-center',
            ];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.blog.title'), "title")
                ->sortable()
                ->searchable()
                ->view('sadmin.blog.columns.title'),
            Column::make(__('messages.vcard.preview_url'), 'slug')->sortable()->view('sadmin.blog.columns.preview'),
            // Column::make(__('messages.blog.description'), "description")
            //     ->searchable()
            //     ->sortable()
            //     ->view('sadmin.blog.columns.description'),
            Column::make(__('messages.blog.status'), 'status')
                ->sortable()
                ->view('sadmin.blog.columns.status'),
            Column::make(__('messages.common.action'), 'id')
                ->view('sadmin.blog.columns.action'),
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
        $query =  Blog::from('blogs');

        $query->when($status != "", function ($q) use ($status) {
            if ($status == Blog::IS_ACTIVE) {
                $q->where('status', Blog::IS_ACTIVE);
            }
            if ($status == Blog::DEACTIVATE) {
                $q->where('status', Blog::DEACTIVATE);
            }
        });

        return $query->select('blogs.*');
    }

    public function resetPageTable($pageName = 'blog-table')
    {
        $rowsPropertyData = $this->getRows()->toArray();
        $prevPageNum = $rowsPropertyData['current_page'] - 1;
        $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
        $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;

        $this->setPage($pageNum, $pageName);
    }
}
