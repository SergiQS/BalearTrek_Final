<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>BackOffice</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
   <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<body class="d-flex">

     <!-- @include('layouts.sidebar') --> 

    

    <main class="flex-grow-1 p-4">
        @yield('content')
    </main>

</body>

</html>