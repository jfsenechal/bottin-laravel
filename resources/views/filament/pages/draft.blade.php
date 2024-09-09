<x-filament-panels::page>
    <div class="text-2xl text-red-500">
        Sélectionnez la catégorie, uniquement le niveau le plus bas sera accepté
    </div>

    @if(count($breadcrumbs) > 0)
        <h3>Vous avez sélectionné</h3>
        <x-filament::breadcrumbs :breadcrumbs="$breadcrumbs"/>
    @endif

    @if(count($data) > 0)
        <h3>Parcourir les rubriques</h3>
        @foreach ($data as $category)
            <div wire:key="{{ $category->id }}">
                {{ ($this->selectAction)(['name'=>$category->name,'categoryId' => $category->id]) }}
            </div>
        @endforeach
    @endif
</x-filament-panels::page>
