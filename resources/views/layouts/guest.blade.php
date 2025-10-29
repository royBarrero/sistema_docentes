<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
      <style>
    body, html {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    .bg-gradient {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 50%, #a5f3fc 100%) !important;
    }
    input:focus {
        box-shadow: none !important;
        border-color: #3b82f6 !important;
    }
    <style>
    body, html {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    .bg-gradient {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 50%, #a5f3fc 100%) !important;
    }
    input:focus {
        box-shadow: none !important;
        border-color: #3b82f6 !important;
    }
    /* Estilos para el botón */
    button[type="submit"] {
        background-color: #2563eb !important;
        color: white !important;
        padding: 0.75rem 1.5rem !important;
        border-radius: 0.5rem !important;
        font-weight: 600 !important;
        font-size: 0.875rem !important;
    }
    button[type="submit"]:hover {
        background-color: #1d4ed8 !important;
    }
</style>
</style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="bg-gradient" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem;">
            <div style="width: 100%; max-width: 28rem; margin-top: -4rem;">
                <!-- Logo centrado -->
                <div style="display: flex; justify-content: center; margin-bottom: 2rem;">
                    <a href="/">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo FICCT" class="h-auto w-24 object-contain sm:w-28 md:w-32">
                    </a>
                </div>

                <!-- Formulario de login -->
                <div style="padding: 2rem 1.5rem; background-color: #f0f9ff; border-radius: 0.5rem; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); border: 1px solid #bfdbfe;">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>