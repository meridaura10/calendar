<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dracula">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-base-200 min-h-[100vh]">
   <x-layouts.app.header />

    {{ $slot }}

   @livewireScripts
</body>
