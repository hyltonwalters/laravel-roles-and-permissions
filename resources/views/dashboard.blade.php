<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#222222]">

@include('layouts.navigation')

<div class="flex justify-center py-12">
    <div class="w-1/2 justify-center sm:px-6 lg:px-8 mx-6">
        <div class="bg-white dark:bg-[#303030] border-2 border-[#F84453] overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-white font-bold dark:text-white">
                {{ __("Welcome ") }} {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
            </div>
        </div>
    </div>
</div>
</body>
</html>
