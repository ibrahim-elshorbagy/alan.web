<?php

namespace App\Livewire;

use Livewire\Component;
use App\Livewire\LivewireTableComponent;
use Illuminate\Database\Eloquent\Builder;
use App\Models\CustomPage as ModelsCustomPage;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CustomPage extends LivewireTableComponent
{
    protected $model = ModelsCustomPage::class;
    public bool $showButtonOnHeader = true;
    public string $buttonComponent = 'sadmin.custom_page.add-button';
    protected $listeners = ['refresh', 'resetPageTable'];
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
                ->searchable(),
            Column::make(__('messages.blog.slug'), 'slug')->sortable()->view('sadmin.custom_page.columns.preview'),
            Column::make(__('messages.blog.status'), 'status')
                ->sortable()
                ->view('sadmin.custom_page.columns.status'),
            Column::make(__('messages.common.action'), 'id')
                ->view('sadmin.custom_page.columns.action'),
        ];
    }

    public function builder(): Builder
    {
        return ModelsCustomPage::query()->select('custom_pages.*');
    }

    public function resetPageTable($pageName = 'custom-page')
    {
        $rowsPropertyData = $this->getRows()->toArray();
        $prevPageNum = $rowsPropertyData['current_page'] - 1;
        $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
        $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;

        $this->setPage($pageNum, $pageName);
    }

}
