@php
    $parameters = [
        'id' => $attributes->get('id'),
    ];

    $optionalParameters = [
        'closeonSubmit',
        'dismissable',
        'dismissableWith',
        'form',
        'maxWidth',
    ];

    foreach ($optionalParameters as $optionalParameter) {
        if ( $attributes->has($optionalParameter) ) {
            $parameters[$optionalParameter] = $attributes->get($optionalParameter);
        }
    }

@endphp

@livewire('tall-interactive::modal', $parameters)


