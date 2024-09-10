<?php

namespace App\Livewire;

use App\Models\Category;
use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Illuminate\Database\Eloquent\Collection;

class MemberCheckinList extends Component
{
    protected string $view = 'filament.pages.member';
    // our members data, you can pass an array or closure
    protected Collection|array|Closure $members = [];
    protected array $breadcrumb;
    public array $data = ['yyy'];

    public static function make(): static
    {
        $static = app(static::class, []);
        $static->configure();

        return $static;
    }

    protected function setUp(): void
    {
        parent::setUp();
        // register our custom action, add as many actions here as you need
        $this->registerActions([
            fn(MemberCheckinList $component): Action => $component->getProcessCheckinAction(),
        ]);

    }

    // this method is used to set the data from the form the component is used in
    public function members(Collection|array|Closure $members): static
    {
        $this->members = $members;

        return $this;
    }

    // this method is what we use to get the data in the view template
    public function getMembers(): array|Collection
    {
        // we need to evaluate the members property to see if its a plain array or closure
        return $this->evaluate($this->members);
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
    public function getProcessCheckinAction(): Action
    {
        // I haven't done it yet but you can expose more of this to be configured from the parent form
        // name this action something meaningful, you need it in the view
        return Action::make('processCheckin')
            ->label(function (array $arguments) {
                return $arguments['name'];
            })
            ->outlined() // makes this an outlined button, remove if you want default
            ->action(function (array $arguments) {
                // I use ray for local testing, remove this line or use dump or dd
                // here you can handle the action how ever you need to
                $category = Category::query()->find($arguments['userId']);
                $this->breadcrumb[$category->id] = $category->name;
                $this->members(Category::childrenOfParent($category->id));
                //    dump('User2 ID: '.$arguments['userId']);
            });
    }

    // this is required when registering actions otherwise you'll get Key() error
    public function getKey(): string
    {
        return 'memberCheckins';
    }
}
