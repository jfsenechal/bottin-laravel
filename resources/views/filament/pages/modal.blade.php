<div>
    {{$name}}

    @foreach ($categories as $category)
        <button type="button" value="{{ $category->id }}" wire:click="{{$action->getModalAction('report')}}" wire:key="{{ $category->id }}">
            {{ $category->name }}
        </button>
    @endforeach

    <x-filament-actions::modals />
</div>
