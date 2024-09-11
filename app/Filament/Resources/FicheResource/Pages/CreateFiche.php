<?php

namespace App\Filament\Resources\FicheResource\Pages;

use App\Filament\Resources\FicheResource;
use App\Models\City;
use App\Models\Fiche;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

use function Filament\Support\is_app_url;

class CreateFiche extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = FicheResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Nouvelle fiche';
    }

    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();

        if ($resource::hasPage('edit') && $resource::canEdit($this->getRecord())) {
            return $resource::getUrl('edit', ['record' => $this->getRecord(), ...$this->getRedirectUrlParameters()]);
        }

        return $resource::getUrl('index');
    }

    protected function getSteps(): array
    {
        return [
            Step::make('Name')
                ->description('Lors de la création, il sera verifié si une fiche existe avec le nom et la localité')
                ->schema([
                    TextInput::make('societe')
                        ->required()
                        ->autocomplete(false)
                        ->minLength(3)
                        ->afterStateUpdated(function ($state, Set $set, Get $get) {
                            $slug = Str::slug($get('societe'));
                            $fiche = Fiche::where('slug', '=', $slug)->first();
                            if ($fiche) {
                                $slug = $slug.'-'.$get('localite');
                            }
                            $set('slug', $slug);
                        }),
                    TextInput::make('localite')
                        ->autocomplete(false)
                        ->datalist(
                            fn() => City::all()->pluck('name')->toArray(),
                        ),
                    Hidden::make('slug')
                        ->disabled()
                        ->required(),
                    //->unique(Fiche::class, 'slug', fn($record) => $record),
                ]),
        ];
    }

    public function create(bool $another = false): void
    {
        $fiche = Fiche::where('societe', '=', $this->data['societe'])
            ->where('localite', '=', $this->data['localite'])->first();
        if ($fiche) {
            Notification::make()
                ->title('Une fiche avec le même nom et la même localité existe déjà')
                ->danger()
                ->send();

            $resource = static::getResource();
            if ($resource::hasPage('edit') && $resource::canEdit($fiche)) {
                $redirectUrl = $resource::getUrl(
                    'edit',
                    ['record' => $fiche, ...$this->getRedirectUrlParameters()],
                );
            } else {
                $redirectUrl = $resource::getUrl('index');
            }

            $this->redirect($redirectUrl, navigate: FilamentView::hasSpaMode() && is_app_url($redirectUrl));

            return;
        }

        parent::create($another);
    }
}
