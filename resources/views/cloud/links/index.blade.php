@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Links') }}
        </h2>
        <div class="flex items-center space-x-2">
            <button id="gridLayoutBtn" class="p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 ease-in-out" title="Grid View">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
            </button>
            <button id="listLayoutBtn" class="p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 ease-in-out" title="List View">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
            </button>
            <a href="{{ route('cloud.links.create') }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white ring-gray-300 transition duration-150 ease-in-out hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 active:bg-indigo-900 dark:focus:ring-offset-gray-800">
                Create new Link
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="mb-4 text-lg font-semibold">Your Links</h3>
                    @if($links->isEmpty())
                        <p class="text-gray-600 dark:text-gray-300">You have no links yet.</p>
                    @else
                        <div id="gridLayout" class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                            @foreach($links as $link)
                                <div class="relative rounded-lg bg-gray-100 p-4 shadow-sm dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-indigo-400 dark:hover:border-indigo-600 transition duration-150 ease-in-out">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex justify-between items-center mb-2">
                                        <span>{{ $link->slug }}</span>
                                        <span class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-800 dark:bg-indigo-900 dark:text-indigo-100">
                                            {{ $link->getViewCount() }} Views
                                        </span>
                                    </h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                        <span class="font-medium">Original URL:</span> {{ Str::limit($link->original_url, 46) }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <a href="{{ route('cloud.links.show', $link->slug) }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                                            Details
                                        </a>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('cloud.links.edit', $link->slug) }}" class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 text-sm font-medium">
                                                Edit
                                            </a>
                                            <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-link-deletion-{{ $link->id }}')"
                                                class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                                                Delete
                                            </button>

                                            <x-modal name="confirm-link-deletion-{{ $link->id }}" :show="$errors->linkDeletion->isNotEmpty()" focusable>
                                                <form method="post" action="{{ route('cloud.links.destroy', $link->slug) }}" class="p-6">
                                                    @csrf
                                                    @method('delete')

                                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                        {{ __('Are you sure you want to delete this link?') }}
                                                    </h2>

                                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                        {{ __('Once your link is deleted, all of its resources and data will be permanently deleted. Please confirm you wish to delete your link.') }}
                                                    </p>

                                                    <div class="mt-6 flex justify-end">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
                                                            {{ __('Cancel') }}
                                                        </x-secondary-button>

                                                        <x-danger-button class="ms-3">
                                                            {{ __('Delete Link') }}
                                                        </x-danger-button>
                                                    </div>
                                                </form>
                                            </x-modal>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div id="listLayout" class="hidden space-y-2">
                            @foreach($links as $link)
                                <div class="relative rounded-lg bg-gray-100 p-4 shadow-sm dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-indigo-400 dark:hover:border-indigo-600 transition duration-150 ease-in-out flex items-center justify-between mb-1">
                                    <div class="flex-grow">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                            {{ $link->slug }}
                                            <span class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-800 dark:bg-indigo-900 dark:text-indigo-100 ml-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                {{ $link->getViewCount() }}
                                            </span>
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                            <span class="font-medium">Original URL:</span>
                                            <a href="{{ $link->original_url }}" target="_blank" class="text-blue-600 hover:underline dark:text-blue-400">
                                                {{ Str::limit($link->original_url, 60) }}
                                            </a>
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2 ml-4">
                                        <!--button onclick="copyToClipboard('{{ url($link->slug) }}')" class="text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 p-1 rounded-md tooltip" data-tooltip="Copy Shortened Link">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h3.2a2 2 0 012 2V17a2 2 0 01-2 2H7.8a2 2 0 01-2-2V7a2 2 0 012-2h3.2" />
                                            </svg>
                                        </button-->
                                        <!--button onclick="copyToClipboard('{{ route('cloud.links.redirect', ['link' => $link]) }}')" class="text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 p-1 rounded-md tooltip" data-tooltip="Copy Shortened Link">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h3.2a2 2 0 012 2V17a2 2 0 01-2 2H7.8a2 2 0 01-2-2V7a2 2 0 012-2h3.2" />
                                            </svg>
                                        </button-->
                                        <a href="{{ url($link->slug) }}" target="_blank" class="text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 p-1 rounded-md tooltip" data-tooltip="Open Shortened Link">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('cloud.links.show', $link->slug) }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 p-1 rounded-md tooltip" data-tooltip="Show Details">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('cloud.links.edit', $link->slug) }}" class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 p-1 rounded-md tooltip" data-tooltip="Edit Link">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-link-deletion-{{ $link->id }}')"
                                            class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 p-1 rounded-md tooltip" data-tooltip="Delete Link">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                        <x-modal name="confirm-link-deletion-{{ $link->id }}" :show="$errors->linkDeletion->isNotEmpty()" focusable>
                                            <form method="post" action="{{ route('cloud.links.destroy', $link->slug) }}" class="p-6">
                                                @csrf
                                                @method('delete')

                                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                    {{ __('Are you sure you want to delete this link?') }}
                                                </h2>

                                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                    {{ __('Once this link is deleted, all of its resources and data will be permanently deleted. Please confirm you wish to delete your link.') }}
                                                </p>

                                                <div class="mt-6 flex justify-end">
                                                    <x-secondary-button x-on:click="$dispatch('close')">
                                                        {{ __('Cancel') }}
                                                    </x-secondary-button>

                                                    <x-danger-button class="ms-3">
                                                        {{ __('Delete Link') }}
                                                    </x-danger-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $links->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            white-space: nowrap;
            margin-bottom: 8px;
            z-index: 10;
        }
    </style>

    <script>
        const gridLayoutBtn = document.getElementById('gridLayoutBtn');
        const listLayoutBtn = document.getElementById('listLayoutBtn');
        const gridLayout = document.getElementById('gridLayout');
        const listLayout = document.getElementById('listLayout');

        let currentLayout = localStorage.getItem('link_layout') || 'grid';

        function applyLayout(layout) {
            if (layout === 'grid') {
                gridLayout.classList.remove('hidden');
                listLayout.classList.add('hidden');
            } else {
                gridLayout.classList.add('hidden');
                listLayout.classList.remove('hidden');
            }
            localStorage.setItem('link_layout', layout);
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Shortened link copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }

        gridLayoutBtn.addEventListener('click', () => applyLayout('grid'));
        listLayoutBtn.addEventListener('click', () => applyLayout('list'));

        applyLayout(currentLayout);
    </script>
@endsection