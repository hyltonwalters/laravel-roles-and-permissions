@props(['messages'])

@if ($messages->any())
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
        @foreach ($messages->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
