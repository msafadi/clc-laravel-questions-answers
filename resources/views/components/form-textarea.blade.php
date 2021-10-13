@props(['label', 'id', 'name', 'value' => ''])

<label for="{{ $id }}">{{ $label }}</label>
<div>
    <textarea id="{{ $id }}" name="{{ $name }}" {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>{{ old($name, $value) }}</textarea>
    @error($name)
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>