@props([
    'class' => '',
])

<button
    {{ $attributes }}
    class="
        py-7 px-9
        btn btn-dash btn-secondary
        {{ $class }}
       ">
    {{ $slot }}
</button>
