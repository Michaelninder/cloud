<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Hello, :name!", ['name' => Auth()->user()->name]) }}
                </div>
            </div>

            <section class="mt-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Stats</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="flex items-center gap-4 rounded-xl bg-gray-100 dark:bg-gray-700 p-6 shadow hover:shadow-md transition duration-300">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-300 dark:bg-gray-600">
                            <i class="bi bi-tag text-3xl text-gray-800 dark:text-gray-200"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                Your Tags
                            </p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $stats['tags'] }}
                            </p>
                            <a class="text-blue-700 hover:text-blue-800 dark:text-blue-300 dark:hover:text-blue-200 duration-[0.3456789s]" href="{{ route('cloud.tags.index') }}">Show Tags</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>