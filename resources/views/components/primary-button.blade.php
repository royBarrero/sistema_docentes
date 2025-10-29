<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-widest transition ease-in-out duration-150']) }} style="background-color: #2563eb; color: white;">
    {{ $slot }}
</button>