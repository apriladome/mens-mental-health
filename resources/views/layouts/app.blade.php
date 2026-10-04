<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', "Men's Mental Health & Resilience Platform") }}</title>

    <!-- Typography -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|jetbrains-mono:400,500" rel="stylesheet" />

    <!-- Assets via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body 
    x-data="{ 
        stealth: localStorage.getItem('mmh_stealth_mode') === 'true',
        toggleStealth() {
            this.stealth = !this.stealth;
            localStorage.setItem('mmh_stealth_mode', this.stealth);
        }
    }" 
    :class="{ 'theme-stealth': stealth }"
    class="min-h-screen bg-surface-base text-content-primary antialiased selection:bg-tactical-steel selection:text-surface-base"
>
    <!-- Modular Navigation Header -->
    <x-navigation.header />

    <!-- Main Content Container -->
    <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>