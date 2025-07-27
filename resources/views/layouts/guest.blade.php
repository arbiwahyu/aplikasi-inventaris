<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    {{-- Container utama yang mengatur background abu-abu dan posisi tengah --}}
    <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 bg-gray-100">

        {{-- Kartu putih tunggal yang membungkus logo dan form --}}
        <div class="w-full max-w-md py-8 px-6 bg-white shadow-md overflow-hidden sm:rounded-lg">

            <div class="flex justify-center mb-6">
                <a href="/">
                    {{-- Anda bisa sesuaikan lagi ukurannya di sini jika perlu --}}
                    <x-application-logo class="w-32 h-32 fill-current text-gray-500" />
                </a>
            </div>

            {{ $slot }}
        </div>
    </div>
</body>

</html>
