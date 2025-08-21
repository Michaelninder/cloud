<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="bi bi-house-door-fill mr-2"></i>{{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                @auth
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('cloud.tags.index')" :active="request()->routeIs('cloud.tags.*')">
                            <i class="bi bi-tags-fill mr-2"></i>{{ __('Tags') }}
                        </x-nav-link>
                        <x-nav-link :href="route('cloud.files.index')" :active="request()->routeIs('cloud.files.*')">
                            <i class="bi bi-file-earmark-fill mr-2"></i>{{ __('Files') }}
                        </x-nav-link>
                        <x-nav-link :href="route('cloud.folders.index')" :active="request()->routeIs('cloud.folders.*')">
                            <i class="bi bi-folder-fill mr-2"></i>{{ __('Folders') }}
                        </x-nav-link>
                        <x-nav-link :href="route('cloud.links.index')" :active="request()->routeIs('cloud.links.*')">
                            <i class="bi bi-link-45deg mr-2"></i>{{ __('Links') }}
                        </x-nav-link>
                    </div>
                @endauth
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <img class="h-8 w-8 rounded-full object-cover mr-2" src="{{ Auth::user()->avatar() }}" alt="{{ Auth::user()->name }}">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">
                                <i class="bi bi-person-fill mr-2"></i>{{ __('Profile') }}
                            </x-dropdown-link>
                            <div class="border-t border-gray-200 dark:border-gray-600"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    <i class="bi bi-box-arrow-right mr-2"></i>{{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <x-nav-link :href="route('login')">
                        <i class="bi bi-box-arrow-in-right mr-2"></i>{{ __('Log In') }}
                    </x-nav-link>
                    @if (Route::has('register'))
                        <x-nav-link :href="route('register')">
                            <i class="bi bi-person-plus-fill mr-2"></i>{{ __('Register') }}
                        </x-nav-link>
                    @endif
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="bi bi-house-door-fill mr-2"></i>{{ __('Dashboard') }}
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('cloud.tags.index')" :active="request()->routeIs('cloud.tags.*')">
                    <i class="bi bi-tags-fill mr-2"></i>{{ __('Tags') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cloud.files.index')" :active="request()->routeIs('cloud.files.*')">
                    <i class="bi bi-file-earmark-fill mr-2"></i>{{ __('Files') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cloud.folders.index')" :active="request()->routeIs('cloud.folders.*')">
                    <i class="bi bi-folder-fill mr-2"></i>{{ __('Folders') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cloud.links.index')" :active="request()->routeIs('cloud.links.*')">
                    <i class="bi bi-link-45deg mr-2"></i>{{ __('Links') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            @auth
                <div class="flex items-center px-4">
                    <img class="h-9 w-9 rounded-full object-cover mr-2" src="{{ Auth::user()->avatar() }}" alt="{{ Auth::user()->name }}">
                    <div>
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        <i class="bi bi-person-fill mr-2"></i>{{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            <i class="bi bi-box-arrow-right mr-2"></i>{{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        <i class="bi bi-box-arrow-in-right mr-2"></i>{{ __('Log In') }}
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">
                            <i class="bi bi-person-plus-fill mr-2"></i>{{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>