<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        @vite('resources/css/app.css')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
    </head>
    <body>
        <header>
            <div style="background-color: #0D4E86" class="p-2">
                <img src="{{ asset('images/web-heading.png') }}" alt="Web Banner" class="w-[50rem]">
            </div>
        </header>

        <main>
            @yield('content')
        </main>

        <footer>

        </footer>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>

        @yield('custom_script')
    </body>
</html>