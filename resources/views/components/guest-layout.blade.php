<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>International Language Center - ILC</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-white">
    <div class="flex flex-col min-h-screen">

        <!-- Navigation Bar -->

        <!-- Main Content -->
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>

        <!-- Footer -->


    </div>
</body>

</html>
