<?php

namespace App\Filament\Resources;

use App\Enum\SocialNetworksEnum;
use App\Filament\Resources\FicheResource\Pages;
use App\Livewire\BrowseCategories;
use App\Models\Category;
use App\Models\City;
use App\Models\Fiche;
use App\Models\Tag;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;


class FicheResource extends Resource
{
    protected static ?string $model = Fiche::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static array $disabledFieldsMarkdown = [
        'image',
        'attachFiles',
        'table',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->columns('xl')
            ->schema([
                Tabs::make('Tabs')
                    ->columns(2)
                    ->tabs([
                        Tabs\Tab::make('Coordonnées')
                            ->schema([
                                Forms\Components\TextInput::make('societe')
                                    ->required()
                                    ->autocomplete(false)->columnSpan(2)
                                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)),
                                    ),
                                Forms\Components\TextInput::make('rue')
                                    ->autocomplete(false),
                                Forms\Components\TextInput::make('numero')
                                    ->autocomplete(false),
                                Forms\Components\TextInput::make('cp')->label('Code postal')->integer(),
                                Forms\Components\TextInput::make('localite')
                                    ->autocomplete(false)
                                    ->datalist(
                                        fn() => City::all()->pluck('name')->toArray(),
                                    ),
                                Forms\Components\TextInput::make('website')
                                    ->url()
                                    ->prefix('https://'),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->prefixIcon('heroicon-m-at-symbol'),
                            ]),
                        Tabs\Tab::make('Contacts')
                            ->schema([
                                Forms\Components\Repeater::make('contacts')
                                    ->columns(2)
                                    ->relationship('contacts')
                                    ->addable()
                                    ->reorderable(false)
                                    ->addActionLabel('Ajouter un contact')
                                    ->schema([
                                        Forms\Components\TextInput::make('nom')
                                            ->autocomplete(false)
                                            ->maxLength(150),
                                        Forms\Components\TextInput::make('prenom')
                                            ->autocomplete(false)
                                            ->maxLength(150),
                                        Forms\Components\TextInput::make('fonction')
                                            ->autocomplete(false)
                                            ->maxLength(150),
                                        Forms\Components\TextInput::make('email')
                                            ->label('Email')
                                            ->email()
                                            ->prefixIcon('heroicon-m-at-symbol')
                                            ->autocomplete(false)
                                            ->maxLength(150),
                                        Forms\Components\TextInput::make('gsm')
                                            ->autocomplete(false)
                                            ->tel(),
                                        Forms\Components\TextInput::make('telephone')
                                            ->label('Téléphone')
                                            ->autocomplete(false)
                                            ->tel(),
                                    ]),
                            ]),
                        Tabs\Tab::make('Classement(s)')
                            ->schema([
                                Section::make('Ajouter un recherchant par mot clef')
                                    ->schema([
                                        Forms\Components\Select::make('categories')
                                            ->relationship('categories', 'name')
                                            ->searchable()
                                            ->multiple()
                                            ->columnSpanFull()
                                            ->helperText(''),
                                    ]),
                                Section::make('Ajouter en parcourant')
                                    ->schema([
                                        Forms\Components\Actions::make([
                                            Action::make('browseCategories')
                                                ->label('Parcour les catégories')
                                                ->successNotification(
                                                    Notification::make()
                                                        ->success()
                                                        ->title('User updated')
                                                        ->body('The user has been saved successfully.'),
                                                )
                                                ->form([
                                                    Forms\Components\Hidden::make('categorySelected'),
                                                    BrowseCategories::make('categoryBrowse')
                                                        ->categories(function (Get $get) {
                                                            $search = $get('categorySelected');

                                                            return Category::roots();
                                                        })
                                                        ->breadcrumb([]),
                                                ])
                                                ->action(function (?Fiche $record, array $data) {
                                                    $category = $data['categorySelected'];
                                                    $record->categories()->attach($category);
                                                    /* $this->refreshFormData([
                                                         'status',
                                                     ]);*/
                                                    //todo refresh
                                                }),
                                        ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Infos complémentaires')
                            ->schema([
                                Forms\Components\MarkdownEditor::make('comment1')
                                    ->disableToolbarButtons(self::$disabledFieldsMarkdown),
                                Forms\Components\MarkdownEditor::make('comment2')
                                    ->disableToolbarButtons(self::$disabledFieldsMarkdown),
                                Forms\Components\MarkdownEditor::make('comment3')
                                    ->disableToolbarButtons(self::$disabledFieldsMarkdown),
                            ]),
                        Tabs\Tab::make('Tags')
                            ->schema([
                                Forms\Components\Select::make('tags')
                                    ->multiple()
                                    ->relationship(titleAttribute: 'name')
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required(),
                                    ]),
                            ]),
                        Tabs\Tab::make('Images')
                            ->schema([
                                Forms\Components\FileUpload::make('images')
                                    ->image()
                                    ->directory('uploads/images')
                                    ->multiple(),
                            ]),
                        Tabs\Tab::make('Localisation')
                            ->schema([
                                Forms\Components\TextInput::make('latitude')
                                    ->hiddenLabel()
                                    ->hidden(false),
                                Forms\Components\TextInput::make('longitude')
                                    ->hiddenLabel()
                                    ->hidden(false),
                                Map::make('location')
                                    ->label('Location')
                                    ->columnSpanFull()
                                    ->default([
                                        'lat' => 50.1339,
                                        'lng' => 5.2040,
                                    ])
                                    ->afterStateUpdated(function (Set $set, ?array $state): void {
                                        $set('latitude', $state['lat']);
                                        $set('longitude', $state['lng']);
                                    })
                                    ->afterStateHydrated(function ($state, $record, Set $set): void {
                                        $set(
                                            'location',
                                            ['lat' => $record?->latitude, 'lng' => $record?->longitude],
                                        );
                                    })
                                    ->extraStyles([
                                        'min-height: 150vh',
                                        'border-radius: 50px',
                                    ])
                                    ->liveLocation()
                                    ->showMarker()
                                    ->markerColor("#22c55eff")
                                    ->showFullscreenControl()
                                    ->showZoomControl()
                                    ->draggable()
                                    ->tilesUrl("https://tile.openstreetmap.de/{z}/{x}/{y}.png")
                                    ->zoom(15)
                                    ->detectRetina()
                                    ->showMyLocationButton()
                                    ->extraTileControl([])
                                    ->extraControl([
                                        'zoomDelta' => 1,
                                        'zoomSnap' => 2,
                                    ]),

                            ]),
                        Tabs\Tab::make('Réseaux sociaux')
                            ->schema([
                                Forms\Components\Repeater::make('links')
                                    ->relationship()
                                    ->label('Réseaux sociaux')
                                    ->reorderable(false)
                                    ->addActionLabel('Ajouter le lien')
                                    ->schema([
                                        Forms\Components\Select::make('links')
                                            ->label('Type')
                                            ->required()
                                            ->options(
                                                SocialNetworksEnum::class,
                                            ),
                                        Forms\Components\TextInput::make('url')
                                            ->url()
                                            ->prefix('https://')
                                            ->required(),
                                    ])
                                    ->columns(2),
                            ]),
                        Tabs\Tab::make('Horaires')
                            ->schema([
                                Forms\Components\Repeater::make('links')
                                    ->relationship()
                                    ->label('Réseaux sociaux')
                                    ->reorderable(false)
                                    ->defaultItems(3)
                                    ->addable(false)
                                    ->cloneable()
                                    ->deletable(false)
                                    ->schema([
                                        Forms\Components\Select::make('links')
                                            ->label('Type')
                                            ->required()
                                            ->options(
                                                SocialNetworksEnum::class,
                                            ),
                                        Forms\Components\TextInput::make('url')
                                            ->url()
                                            ->prefix('https://')
                                            ->required(),
                                    ])
                                    ->columns(2),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('societe')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rue')->searchable(),
                Tables\Columns\TextColumn::make('localite')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('localite')->options(
                    function () {
                        $localites = [];
                        foreach (City::all()->pluck('name') as $cityName) {
                            $localites[$cityName] = $cityName;
                        }

                        return $localites;
                    },
                ),
                SelectFilter::make('tags')
                   /* ->options(
                        function () {
                            return Tag::all()->get();
                        },
                    )*/
                    ->relationship('tags', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //   ClassementsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFiches::route('/'),
            'create' => Pages\CreateFiche::route('/create'),
            'edit' => Pages\EditFiche::route('/{record}/edit'),
            'view' => Pages\ViewFiche::route('/{record}'),
        ];
    }
}
