<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>МКУ "ЦРО": АИС «Мониторинг ДПП»</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center">

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                            @include('blocks.welcome.docs')
                        </div>

                        <div class="p-6">
                            <div class="flex items-center">
                                <svg class="h-8 w-8 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="4" y="4" width="16" height="4" rx="1" />  <rect x="4" y="12" width="6" height="8" rx="1" />  <line x1="14" y1="12" x2="20" y2="12" />  <line x1="14" y1="16" x2="20" y2="16" />  <line x1="14" y1="20" x2="20" y2="20" /></svg>
                                <div class="ml-4 text-lg leading-7 font-semibold">Личный кабинет</div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    @if (Route::has('login'))
                                    <div class="sm:px-6 sm:py-4">
                                        @auth
                                            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Личный кабинет</a>
                                        @else
                                            <a href="{{ route('login') }}" class="block text-center sm:flex sm:inline-flex sm:items-center px-4 py-2 my-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Вход</a>

                                            @if (Route::has('register'))
                                                <a href="{{ route('register') }}" class="block text-center sm:flex sm:inline-flex sm:items-center px-4 py-2 my-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">Регистрация</a>
                                            @endif
                                        @endauth
                                    </div>
                                    @endif  
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                            @include('blocks.welcome.links')
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                        МКУ "ЦРО" г. Усть-Илимск &copy; 11.2022-{{ date ( 'm.Y' ) }} Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
