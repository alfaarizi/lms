<div class="drawer-side z-20">
    <label for="main-drawer" aria-label="close sidebar" class="drawer-overlay"></label>

    <div class="menu p-4 w-min min-h-full bg-base-300 text-base-content">
        <!-- Logo -->
        <div class="flex items-center justify-center mb-8 mt-5">
            <a href="{{ route('subjects.index') }}" class="text-2xl font-bold text-primary">
                {{ config('app.name', 'LMS') }}
            </a>
        </div>

        <!-- User Profile Card -->
        @auth
        <div class="flex flex-col items-center mb-6">
            <div class="avatar">
                <div class="w-16 rounded-full bg-primary text-primary-content flex items-center justify-center text-2xl">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
            <div class="mt-2 text-center">
                <h3 class="font-medium"><a href="{{ route('profile.edit') }}">{{ Auth::user()->name }}</a></h3>
                <p class="font-bold text-sm opacity-60">{{ Auth::user()->role }}</p>
            </div>
        </div>
        @endauth

        <ul class="space-y-1 w-full">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.index') ? 'active' : '' }} flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="ml-0 whitespace-nowrap">Dashboard</span>
                </a>
            </li>

            <!-- Role section -->
            <li class="menu-title">
                <span class="font-bold text-white-800">{{ Auth::check() && Auth::user()->isTeacher() ? 'Teacher' : 'Student' }}</span>
            </li>
            <li>
                <a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.index') ? 'active' : '' }} flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="ml-0 whitespace-nowrap">My Subjects</span>
                </a>
            </li>
            @if(Auth::check() && Auth::user()->isTeacher())
            <li>
                <a href="{{ route('subjects.create') }}" class="{{ request()->routeIs('subjects.create') ? 'active' : '' }} flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="ml-0 whitespace-nowrap">New Subject</span>
                </a>
            </li>
            @endif
            @if(Auth::check() && Auth::user()->isStudent())
            <li>
                <a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.index') ? 'active' : '' }} flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="ml-0 whitespace-nowrap">Take a Subject</span>
                </a>
            </li>
            @endif

            <!-- Profile Management -->
            <li class="menu-title mt-4">
                <span class="font-bold text-white-800">Account</span>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }} flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="ml-0 whitespace-nowrap">Contact</span>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }} flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="ml-0 whitespace-nowrap">Profile</span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="ml-2 whitespace-nowrap">Log Out</span>
                    </a>
                </form>
            </li>
        </ul>

        <!-- Footer -->
        <div class="mt-auto pt-4 border-t border-base-content/10 text-xs opacity-50 text-center">
            <p>&#169; {{ date('Y') }} LMS</p>
            <p>Learning Management System</p>
        </div>
    </div>
</div>
