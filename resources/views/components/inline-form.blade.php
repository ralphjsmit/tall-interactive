@php
    $parameters = [
        'slot' => $slot,
    ];

    $optionalParameters = [
        'container',
        'controlsDesign',
        'description',
        'form',
        'formVersion',
        'hideControls',
        'maxWidth',
        'model',
        'submitWith',
        'title',
    ];

    foreach ($optionalParameters as $optionalParameter) {
        if ( $attributes->has($optionalParameter) ) {
            $parameters[$optionalParameter] = $attributes->get($optionalParameter);
        }
    }

@endphp

@livewire('tall-interactive::inline-form', $parameters)


