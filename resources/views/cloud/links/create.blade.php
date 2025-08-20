@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Create New Link') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('cloud.links.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="original_url" :value="__('Original URL')" />
                            <x-text-input id="original_url" class="block mt-1 w-full" type="url" name="original_url" :value="old('original_url')" required autofocus />
                            <x-input-error :messages="$errors->get('original_url')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="slug" :value="__('Custom Slug (optional)')" />
                            <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug')" maxlength="5" />
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Leave empty to auto-generate. Max 5 characters.</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Create Link') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection