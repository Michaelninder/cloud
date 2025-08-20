@extends('layouts.app')

@section('header')
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Tag') }}
        </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Update <a
                                class="text-gray-800 dark:text-gray-200 underline"
                                href="{{ route('cloud.tags.show', ['tag' => $tag]) }}">{{ $tag->name }}</a> Tag
                        </h3>
                        <button type="button" x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-tag-deletion')"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">
                            Delete Tag
                        </button>
                    </div>

                    <form action="{{ route('cloud.tags.update', ['tag' => $tag]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tag
                                Name</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $tag->name) }}"
                                placeholder="My Cool Tag"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                            @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200"
                                placeholder="A brief description of the tag">{{ old('description', $tag->description) }}</textarea>
                            @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            Update Tag
                        </button>
                        <a href="{{ route('cloud.tags.index') }}"
                            class="inline-flex items-center px-4 py-2 ml-4 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                            Back to Tags
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="confirm-tag-deletion" :show="$errors->tagDeletion->isNotEmpty()"
        focusable>
        <form method="post" action="{{ route('cloud.tags.destroy', ['tag' => $tag]) }}"
            class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to delete this tag?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Once this tag is deleted, it will no longer be associated with any files or
                folders, but the files and folders themselves will remain.
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete Tag') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
@endsection