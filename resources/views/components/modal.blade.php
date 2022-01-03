@php
    $parameters = [
        'id' => $attributes->get('id'),
    ];

    $optionalParameters = [
        'closeonSubmit',
        'description',
        'dismissable',
        'dismissableWith',
        'form',
        'maxWidth',
        'record',
        'title',
    ];

    foreach ($optionalParameters as $optionalParameter) {
        if ( $attributes->has($optionalParameter) ) {
            $parameters[$optionalParameter] = $attributes->get($optionalParameter);
        }
    }

@endphp

@livewire('tall-interactive::modal', $parameters)


