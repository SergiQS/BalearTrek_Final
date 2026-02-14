<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BalearTrek</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">

    <div class="min-h-screen flex flex-col items-center justify-center">
        <h1 class="text-4xl font-bold mb-6 text-gray-800">
            Bienvenidos a BalearTrek
        </h1>

        <div class="flex gap-4">
            <a href="{{ route('login') }}"
               class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Iniciar sesión
            </a>

            <a href="{{ route('register') }}"
               class="px-6 py-3 bg-gray-700 text-white rounded hover:bg-gray-800 transition">
                Registrarse
            </a>
        </div>
    </div>

</body>
</html>