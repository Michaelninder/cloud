@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Link Details') }}
        </h2>
        <a href="{{ route('cloud.links.edit', $link->slug) }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white ring-gray-300 transition duration-150 ease-in-out hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 active:bg-indigo-900 dark:focus:ring-offset-gray-800">
            {{ __('Edit Link') }}
        </a>
    </div>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug:</p>
                        <p class="mt-1 text-lg font-semibold">{{ $link->slug }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Original URL:</p>
                        <a href="{{ $link->original_url }}" target="_blank" class="mt-1 text-blue-600 hover:underline dark:text-blue-400">
                            {{ $link->original_url }}
                        </a>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Shortened URL:</p>
                        <p class="mt-1 text-lg font-semibold flex items-center">
                            <span id="shortenedUrl">{{ url($link->slug) }}</span>
                            <button onclick="copyToClipboard('shortenedUrl')" class="ml-2 p-1 rounded-md text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h3.2a2 2 0 012 2V17a2 2 0 01-2 2H7.8a2 2 0 01-2-2V7a2 2 0 012-2h3.2"></path></svg>
                            </button>
                        </p>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At:</p>
                        <p class="mt-1 text-base">{{ $link->created_at->format('M d, Y H:i A') }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated:</p>
                        <p class="mt-1 text-base">{{ $link->updated_at->format('M d, Y H:i A') }}</p>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <form action="{{ route('cloud.links.destroy', $link->slug) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this link?');">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>
                                {{ __('Delete Link') }}
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            const textToCopy = element.textContent || element.innerText;

            navigator.clipboard.writeText(textToCopy).then(() => {
                alert('Copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>
@endsection