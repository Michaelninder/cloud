<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tags') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Your Tags</h3>
                    @if($tags->isEmpty())
                        <p class="text-gray-600 dark:text-gray-300">You have no tags yet.</p>
                    @else
                        <ul class="list-disc pl-5 space-y-2">
                            @foreach($tags as $tag)
                                <li class="text-gray-900 dark:text-gray-100">{{ $tag->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>