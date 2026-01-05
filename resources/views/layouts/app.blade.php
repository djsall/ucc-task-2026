<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css'])
</head>
<body>
<header class="flex justify-center p-5">
    <ul class="flex w-full max-w-250 justify-between underline">
        <li>
            <a href="/" class="hidden" id="events-button">Events</a>
        </li>
        <li>
            <a href="/helpdesk" class="hidden" id="helpdesk-button">Helpdesk</a>
        </li>
        <li>
            <a href="/" class="hidden" id="logout-button">Logout</a>
        </li>
    </ul>
</header>
<main class="flex justify-center">
    <div class="max-w-250 w-full mt-32 flex flex-col items-center">
        @yield('content')
    </div>
</main>
</body>
@yield('scripts')
@vite(['resources/js/pages/layout.js'])
</html>
