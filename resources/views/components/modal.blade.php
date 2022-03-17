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
        'form',
        'forceCloseOnSubmit',
        'hideControls',
        'livewire',
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

<div>
    @livewire('tall-interactive::modal', $parameters, key($parameters['id']))
</div>


