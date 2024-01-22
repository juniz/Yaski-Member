
@props([
    'label' => null,
    'id' => null,
    'model' => null,
])

{{-- @php $wireModel = $attributes->get('wire:model'); @endphp --}}

<div class="row mb-4">
    @if ($label)
        <label for="{{ $id }}" class="col-sm-3 col-form-label">{{ $label }}</label>
    @endif

    <div class="col-sm-9">
        <select
            id="{{ $id }}"
            name="{{ $id }}"
            {{ $attributes->merge(['class' => 'form-select']) }}
            @if ($model)
                wire:model.defer="{{ $model }}"
            @endif
        >
            {{ $slot }}
        </select>

        @error($id)
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="text-danger" id="{{ $id }}Error" data-ajax-feedback="{{ $id }}"></div>
    </div>
</div>
