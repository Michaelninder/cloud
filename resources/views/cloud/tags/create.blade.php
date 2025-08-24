@extends('layouts.app')

@section('header')
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Tag') }}
        </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Create new Tag</h3>
                    <form action="{{ route('cloud.tags.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Tag Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="My Cool Tag" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea name="description" id="description" rows="3"
                                      class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                      placeholder="A brief description of the tag">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Create Tag') }}
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
@endsection