@php
    $parameters = [
        'slot' => $slot,
    ];

    $optionalParameters = [
        'container',
        'controlsDesign',
        'description',
        'form',
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

    $parameters['params'] = $attributes->except(array_keys($parameters))->getAttributes();
@endphp

@livewire('tall-interactive::inline-form', $parameters)


