<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => 'db-btn db-btn-primary'
    ]) }}
>
    {{ $slot }}
</button>