<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

         @fluxAppearance
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800 antialiased">
        <livewire:common.menu :tile="__('tile')">
            {{$slot}}
        </livewire:common.menu>
        @fluxScripts
    </body>
</html>
