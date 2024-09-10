<?php

namespace App\Livewire;

use App\Models\Category;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Illuminate\Support\Collection;

class BrowseDraft extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $categories = [];
    public array|null $breadcrumbs = null;
    public ?Collection $breadcrumb = null;

    public function mount(): void
    {
        $this->breadcrumbs = [];
        $this->breadcrumb = new Collection();
        $this->categories = Category::where('parent_id', '=', null)->orderby('name')->get();
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required(),
                MarkdownEditor::make('content'),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        dd($this->form->getState());
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
                $this->categories = Category::where('parent_id', $category->id)->get();
            });
    }

    public function render(): View
    {
        return view('filament.pages.modal');
    }
}
