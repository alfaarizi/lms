<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LMS') }}</title>

        <!-- DaisyUI -->
        <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="drawer lg:drawer-open">
            <input id="main-drawer" type="checkbox" class="drawer-toggle" />
            
            <div class="drawer-content flex flex-col min-h-screen bg-base-200">
                <!-- Top navigation for mobile -->
                <div class="navbar bg-base-300 lg:hidden">
                    <div class="flex-none">
                        <label for="main-drawer" class="btn btn-square btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </label>
                    </div>
                    <div class="flex-1">
                        <a href="{{ route('dashboard') }}" class="btn btn-ghost normal-case text-xl">{{ config('app.name', 'LMS') }}</a>
                    </div>
                    <div class="flex-none">
                        <div class="dropdown dropdown-end">
                            <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                                <div class="w-10 rounded-full bg-primary text-primary-content flex items-center justify-center">
                                    <span>{{ substr(Auth::user()->name ?? 'User', 0, 1) }}</span>
                                </div>
                            </label>
                            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                                <li><a href="{{ route('profile.edit') }}">Profile</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                            Logout
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Breadcrumbs -->
                @if(isset($breadcrumbs))
                <div class="p-4">
                    <div class="breadcrumbs text-sm">
                        <ul>
                            {{ $breadcrumbs }}
                        </ul>
                    </div>
                </div>
                @endif
                
                <!-- Toast messages -->
                @if(session('success') || session('error') || session('info'))
                <div class="toast toast-top toast-end z-50">
                    @if(session('success'))
                    <div class="alert alert-success">
                        <span>{{ session('success') }}</span>
                    </div>
                    @endif
                    
                    @if(session('error'))
                    <div class="alert alert-error">
                        <span>{{ session('error') }}</span>
                    </div>
                    @endif
                    
                    @if(session('info'))
                    <div class="alert alert-info">
                        <span>{{ session('info') }}</span>
                    </div>
                    @endif
                </div>
                @endif
                
                <!-- Page Content -->
                <div class="p-4 md:p-6 lg:p-8">
                    @isset($header)
                        <header class="mb-6 px-8">
                            <h2 class="text-xl font-semibold text-primary">{{ $header }}</h2>
                        </header>
                    @endisset
                    
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>
            
            <!-- Sidebar -->
            @include('layouts.navigation')
        </div>
    </body>
</html>