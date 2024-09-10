<?php

namespace App\Livewire;

use App\Models\Category;
use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Collection;

//inspired https://medium.com/@chrishansondev/laravel-filament-building-custom-form-components-not-fields-afeb842dacd5
class BrowseCategories extends Component implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.components.browse-categories';
    // our members data, you can pass an array or closure
    protected Collection|array|Closure $categories = [];
    protected array $breadcrumb;

    public function mount(): void
    {
        $this->form->fill();
    }

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();

        return $static;
    }

    protected function setUp(): void
    {
        parent::setUp();
        // register our custom action, add as many actions here as you need
        $this->registerActions([
            fn(BrowseCategories $component): Action => $component->getProcessCategoryAction(),
        ]);
    }

    // this method is used to set the data from the form the component is used in
    public function categories(Collection|array|Closure $members): static
    {
        $this->categories = $members;

        return $this;
    }

    // this method is what we use to get the data in the view template
    public function getCategories(): array|Collection
    {
        // we need to evaluate the categories property to see if its a plain array or closure
        return $this->evaluate($this->categories);
    }

    public function breadcrumb(array $breadcrumb): static
    {
        $this->breadcrumb = $breadcrumb;

        return $this;
    }

    public function getBreadcrumb(): array
    {
        // we need to evaluate the members property to see if its a plain array or closure
        return $this->evaluate($this->breadcrumb);
    }

    // the action we registered in the setup method
    public function getProcessCategoryAction(): Action
    {
        // I haven't done it yet but you can expose more of this to be configured from the parent form
        // name this action something meaningful, you need it in the view
        return Action::make('processCategory')
            ->label(function (array $arguments) {
                return $arguments['name'];
            })
            ->outlined() // makes this an outlined button, remove if you want default
            ->action(function (Set $set, array $arguments) {
                // I use ray for local testing, remove this line or use dump or dd
                // here you can handle the action how ever you need to
                $set('categorySelected', $arguments['categoryId']);
                $category = Category::query()->find($arguments['categoryId']);
                $this->breadcrumb[$category->id] = $category->name;
                $this->categories(Category::childrenOfParent($category->id));
            });
    }

    // this is required when registering actions otherwise you'll get Key() error
    public function getKey(): string
    {
        return 'browseCategories';
    }

}
