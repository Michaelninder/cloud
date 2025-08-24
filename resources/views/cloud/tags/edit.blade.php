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
                        <h3 class="text-lg font-semibold">
                            Update
                            <a class="text-indigo-600 dark:text-indigo-400 hover:underline"
                                href="{{ route('cloud.tags.show', ['tag' => $tag]) }}">{{ $tag->name }}</a> Tag
                        </h3>
                        <button type="button" x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-tag-deletion')"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">
                            Delete Tag
                        </button>
                    </div>

                    <form action="{{ route('cloud.tags.update', ['tag' => $tag]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Tag Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $tag->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                placeholder="A brief description of the tag">{{ old('description', $tag->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Update Tag') }}
                            </x-primary-button>
                            <a href="{{ route('cloud.tags.index') }}"
                                class="inline-flex items-center px-4 py-2 ml-4 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                                {{ __('Back to Tags') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="confirm-tag-deletion" :show="$errors->tagDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('cloud.tags.destroy', ['tag' => $tag]) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete this tag?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once this tag is deleted, it will no longer be associated with any files or folders, but the files and folders themselves will remain.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Tag') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
@endsection