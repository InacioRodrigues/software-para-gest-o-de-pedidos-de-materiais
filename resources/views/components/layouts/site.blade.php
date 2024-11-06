<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        @livewireStyles
        @stack('styles')
    </head>
    <body>
        <div class="flex-col w-full">
            @include('layouts.partials.header')

            <main class="flex-grow">
                {{ $slot }}
            </main>

            @include('layouts.partials.footer')
        </div>

        <!-- Scripts -->
        @livewireScripts
        @stack('scripts')
    </body>
</html>
