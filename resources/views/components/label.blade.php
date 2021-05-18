@props(['value'])

<label {{ $attributes->merge(['class' => 'col-4']) }}>
    {{ $value ?? $slot }}
</label>
