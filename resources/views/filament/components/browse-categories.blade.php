@php
    // this is how we access the registered action using the name we set
    $processCategoryAction = $getAction('processCategory');
    $categories = $getCategories();
    $breadcrumb = $getBreadcrumb();
@endphp
<div>
    @if (count($breadcrumb) > 0)
        <h3>Vous avez sélectionné</h3>
        <x-filament::breadcrumbs :breadcrumbs="$breadcrumb"/>
    @endif

    @if (count($categories) > 0)
        <div class="mt-3 flex flex-col divide-y">
            @foreach ($categories as $category)
                <button type="button" wire:key="{{ $category->id }}" class="p-3">
                    {{ $processCategoryAction(['categoryId' => $category->id, 'name'=>$category->name]) }}
                </button>
            @endforeach
        </div>
    @endif
</div>
