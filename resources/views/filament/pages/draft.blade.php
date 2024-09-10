<x-filament-panels::page>
    <div class="text-2xl text-red-500">
        Sélectionnez la catégorie, uniquement le niveau le plus bas sera accepté
    </div>

    @if(count($paths) > 0)
        <h3>Vous avez sélectionné</h3>
        <x-filament::breadcrumbs :breadcrumbs="$paths"/>
    @endif

    @if(count($categories) > 0)
        <h3>Parcourir les rubriques</h3>
        @foreach ($categories as $category)
            <div wire:key="{{ $category->id }}">
                {{ ($this->selectAction)(['name'=>$category->name,'categoryId' => $category->id]) }}
            </div>
        @endforeach
    @endif

    <form wire:submit="create">
        {{ $this->form }}

        <button type="submit">
            Submit
        </button>
    </form>

    <x-filament-actions::modals/>
</x-filament-panels::page>
