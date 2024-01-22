@props([
'label' => null,
'id' => null,
'type' => 'text',
'model' => null,
'placeholder' => '',
'value' => null,
])

<div class="row mb-4">
    @if ($label)
    <label for="{{ $id }}" class="col-sm-3 col-form-label">{{ $label }}</label>
    @endif

    <div class="col-sm-9">
        <input id="{{ $id }}" name="{{ $id }}" type="{{ $type }}" placeholder="{{ $placeholder }}" {{
            $attributes->merge(['class' => 'form-control']) }}
        @if ($value)
        value="{{ $value }}"
        @endif
        @if ($model)
        wire:model.defer="{{ $model }}"
        @endif
        />

        @error($id)
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="text-danger" id="{{ $id }}Error" data-ajax-feedback="{{ $id }}"></div>
    </div>
</div>