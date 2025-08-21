@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Note Details') }}
        </h2>
        <div class="flex items-center space-x-2">
            @if($note->is_public)
                <button onclick="copyToClipboard('{{ url('notes/' . $note->slug) }}')" class="p-2 rounded-md text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 tooltip" data-tooltip="Copy Public Link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h3.2a2 2 0 012 2V17a2 2 0 01-2 2H7.8a2 2 0 01-2-2V7a2 2 0 012-2h3.2" />
                    </svg>
                </button>
                <a href="{{ url('notes/' . $note->slug) }}" target="_blank" class="p-2 rounded-md text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 tooltip" data-tooltip="Open Public Link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            @endif
            <a href="{{ route('cloud.notes.edit', $note->slug) }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white ring-gray-300 transition duration-150 ease-in-out hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 active:bg-indigo-900 dark:focus:ring-offset-gray-800">
                {{ __('Edit Note') }}
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-3xl font-bold mb-4">{{ $note->title }}</h1>

                    <div class="mb-6 flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                        <span>Created: {{ $note->created_at->format('M d, Y H:i A') }}</span>
                        <span>Last Updated: {{ $note->updated_at->format('M d, Y H:i A') }}</span>
                        <span>
                            Status:
                            @if($note->is_public)
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-100">
                                    Public
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-200 px-2 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                    Private
                                </span>
                            @endif
                        </span>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Content:</h4>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! $note->content !!}
                        </div>
                    </div>

                    @if($note->categories->isNotEmpty())
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Categories:</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($note->categories as $category)
                                    <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-100">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($note->tags->isNotEmpty())
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Tags:</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($note->tags as $tag)
                                    <span class="inline-flex items-center rounded-full bg-purple-100 px-3 py-1 text-sm font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-100">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 flex justify-end">
                        <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-note-deletion-{{ $note->id }}')"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white ring-gray-300 transition duration-150 ease-in-out hover:bg-red-700 focus:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 active:bg-red-900 dark:focus:ring-offset-gray-800">
                            {{ __('Delete Note') }}
                        </button>

                        <x-modal name="confirm-note-deletion-{{ $note->id }}" :show="$errors->noteDeletion->isNotEmpty()" focusable>
                            <form method="post" action="{{ route('cloud.notes.destroy', $note->slug) }}" class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Are you sure you want to delete this note?') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Once this note is deleted, all of its resources and data will be permanently deleted. Please confirm you wish to delete your note.') }}
                                </p>

                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>

                                    <x-danger-button class="ms-3">
                                        {{ __('Delete Note') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </div>
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
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Public link copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>
@endsection