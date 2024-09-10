<?php

namespace App\Filament\Pages;

use App\Models\Category;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class Draft extends Page
{
    protected static string $view = 'filament.pages.draft';
    public Collection $categories;
    public array|null $paths = null;

    public function mount(): void
    {
        $this->paths = [];
        $this->categories = Category::where('parent_id', '=', null)->orderby('name')->get();
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
                $this->paths['/'.$category->id] = $category->name;
                $this->categories = Category::where('parent_id', $category->id)->get();
            });
    }

    public function save()
    {
        Post::create(
            $this->only(['title', 'content'])
        );

        session()->flash('status', 'Post successfully updated.');

        return $this->redirect('/posts');
    }

}
