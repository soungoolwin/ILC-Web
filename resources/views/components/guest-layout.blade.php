<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <div class="flex flex-col min-h-screen">

        <!-- Navigation Bar -->
        <nav class="bg-blue-600 p-4 shadow">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-white text-lg font-bold">My Website</h1>
                <div>
                    <a href="#" class="text-white px-4">Home</a>
                    <a href="#" class="text-white px-4">About</a>
                    <a href="#" class="text-white px-4">Contact</a>
                </div>
            </div>
        </nav>
        <!-- Main Content -->
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-blue-600 text-white text-center p-4">
            <p>&copy; 2024 My Website. All rights reserved.</p>
        </footer>

    </div>
</body>

</html>
