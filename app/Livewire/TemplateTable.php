<?php

namespace App\Livewire;

use App\Models\Template;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;


class TemplateTable extends LivewireTableComponent
{
    protected $model = Template::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('Template-table');
        $this->setDefaultSort('id', 'asc');
        $this->setColumnSelectStatus(false);
        $this->setQueryStringStatus(false);
        $this->resetPage('Template-table');

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('used_count')) {
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
            Column::make(__('messages.common.name'), 'name')
                ->view('vcards.templates.columns.name')
                ->sortable()->searchable(function ($query, $searchTerm) {
                    $templateNames = [
                        1 => 'Simple Contact',
                        2 => 'Executive Profile',
                        3 => 'Clean Canvas',
                        4 => 'Professional',
                        5 => 'Corporate Connect',
                        6 => 'Modern Edge',
                        7 => 'Business Beacon',
                        8 => 'Corporate Classic',
                        9 => 'Corporate Identity',
                        10 => 'Pro Network',
                        11 => 'Portfolio',
                        12 => 'Gym',
                        13 => 'Hospital',
                        14 => 'Event Management',
                        15 => 'Salon',
                        16 => 'Lawyer',
                        17 => 'Programmer',
                        18 => 'CEO/CXO',
                        19 => 'Fashion Beauty',
                        20 => 'Culinary Food Services',
                        21 => 'Social Media',
                        22 => 'Dynamic vCard',
                        23 => 'Consulting Services',
                        24 => 'School Templates',
                        25 => 'Social Services',
                        26 => 'Retail E-commerce',
                        27 => 'Pet Shop',
                        28 => 'Pet Clinic',
                        29 => 'Marriage',
                        30 => 'Taxi Service',
                        31 => 'Handyman Services',
                        32 => 'Interior Designer',
                        33 => 'Musician',
                        34 => 'Photographer',
                        35 => 'Real Estate',
                        36 => 'Travel Agency',
                        37 => 'Flower Garden',
                        38 => 'Architecture',
                        65 => 'Reporter',
                    ];

                    $matchingIds = array_keys(array_filter(
                        array_map('strtolower', $templateNames),
                        fn($name) => strpos($name, strtolower($searchTerm)) !== false
                    ));

                    $query->whereIn('id', $matchingIds)->orWhereRaw('1 = 0');
                }),
            Column::make(__('messages.vcards_template.used_count'), 'id')
                ->view('vcards.templates.columns.count'),
        ];
    }

    public function builder(): Builder
    {
        $allowedTemplateIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 65];

        return Template::with(['vcards', 'media'])
            ->select('templates.*')
            ->whereIn('id', $allowedTemplateIds);
    }
    public function placeholder()
    {
        return view('lazy_loading.without-listing-skelecton');
    }
}
