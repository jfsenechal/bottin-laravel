@php
    // this is how we access the registered action using the name we set
    $processCheckinAction = $getAction('processCheckin');
    $members = $getMembers();
    $breadcrumb = $getBreadcrumb();
@endphp
<div>
    @if (count($breadcrumb) > 0)
        <h3>Vous avez sélectionné</h3>
        <x-filament::breadcrumbs :breadcrumbs="$breadcrumb"/>
    @endif

    @if (count($members) > 0)
        <div class="mt-3 flex flex-col divide-y">
            @foreach ($members as $member)
                <button type="button" wire:key="{{ $member->id }}" class="p-3">
                    {{ $processCheckinAction(['userId' => $member->id, 'name'=>$member->name]) }}
                </button>
            @endforeach
        </div>
    @endif
</div>
