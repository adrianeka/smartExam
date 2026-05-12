@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-black text-sm text-gray-700 dark:text-black']) }}>
    {{ $value ?? $slot }}
</label>
