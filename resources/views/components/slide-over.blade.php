@php
    $parameters = [
        'id' => $attributes->get('id'),
        'slot' => $slot,
    ];

    $optionalParameters = [
        'closeOnSubmit',
        'description',
        'dismissable',
        'dismissableWith',
        'forceCloseOnSubmit',
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

@livewire('tall-interactive::slide-over', $parameters)


