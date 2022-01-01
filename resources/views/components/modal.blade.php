@php
    $parameters = [
        'id' => $attributes->get('id'),
        'maxWidth' => $attributes->has('maxWidth') ? $attributes->get('maxWidth') : '2xl',
    ];

    if ( $attributes->has('form') ) {
        $parameters['form'] = $attributes->get('form');
    }
@endphp

@livewire('tall-interactive::modal', $parameters)


