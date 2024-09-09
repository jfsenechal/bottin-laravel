<?php

namespace App\Filament\Pages;

use App\Models\Category;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class Draft extends Page
{
    protected static string $view = 'filament.pages.draft';
    public $data;
    public array|null $breadcrumbs = null;
    public ?Collection $breadcrumb = null;

    public function mount(): void
    {
        $this->breadcrumbs = [];
        $this->breadcrumb = new Collection();
        $this->data = Category::where('parent_id', '=', null)->orderby('name')->get();
    }

    public function selectAction(): Action
    {
        return Action::make('select')
            ->label(function (array $arguments) {
                return $arguments['name'];
            })
            ->icon('heroicon-m-chevron-right')
            ->iconPosition('after')
            ->action(function (array $arguments) {
                $category = Category::query()->find($arguments['categoryId']);
                $this->breadcrumbs['/'.$category->id] = $category->name;
                $this->breadcrumb->add($category);
                $this->data = Category::where('parent_id', $category->id)->get();
            });
    }


}
