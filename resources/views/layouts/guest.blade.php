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
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-50">
    <!-- Background Gradient -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute inset-x-0 -top-40 transform-gpu blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-1 translate-x-1/3 aspect-[1155/678] w-[36rem] rotate-30 bg-gradient-to-tr from-[#80d5ff] to-[#5248e0] opacity-40 sm:w-[72rem]"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        <div class="absolute inset-x-0 bottom-0 transform-gpu blur-3xl" aria-hidden="true">
            <div class="relative left-[-10rem] translate-y-1/3 aspect-[1155/678] w-[36rem] rotate-30 bg-gradient-to-tr from-[#80d5ff] to-[#5248e0] opacity-40 sm:w-[72rem]"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 relative z-10">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-lg rounded-xl">
            {{ $slot }}
        </div>
    </div>
</body>


</html>
