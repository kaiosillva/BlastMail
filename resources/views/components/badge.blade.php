@props([
    'warning' => null,
])
<span
    {{ $attributes->class([
        'inline-flex items-center justify-center rounded-full w-fit border px-2 py-1 text-xs font-medium text-white dark:text-white',
        'border-amber-500 bg-amber-500 dark:border-amber-500 dark:bg-amber-500' => $warning,
    ]) }}>
    {{ $slot }}
</span>
