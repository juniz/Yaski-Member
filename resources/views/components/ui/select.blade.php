
@props([
    'label' => null,
    'id' => null,
    'model' => null,
])

{{-- @php $wireModel = $attributes->get('wire:model'); @endphp --}}

<div class="form-group">
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif

    <select
        id="{{ $id }}"
        name="{{ $id }}"
        {{ $attributes->merge(['class' => 'form-select']) }}
        @if ($model)
            @if($attributes->has('live'))
                wire:model.debounce.500ms="{{ $model }}"
            @else
                wire:model.defer="{{ $model }}"
            @endif
        @endif
        @if($attributes->has('disable'))
            disabled
        @endif
    >
        {{ $slot }}
    </select>

    @error($id)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
