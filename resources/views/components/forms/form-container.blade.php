<div class="{{ $applyContainer ? "sm:rounded-md {$attributes->get('maxWidth')} bg-white rounded-2xl overflow-hidden shadow-md" : '' }}">

    <div @class(['px-6' => $applyContainer, 'py-4'])>
        {{ $slot }}
    </div>

    {{ $controls }}
</div>
