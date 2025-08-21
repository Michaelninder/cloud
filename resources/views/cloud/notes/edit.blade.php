@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Edit Note') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('cloud.notes.update', $note->slug) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $note->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea id="content" name="content" rows="10" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('content', $note->content) }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            {{-- <script>
                                tinymce.init({
                                    selector: '#content',
                                    plugins: 'advlist autolink lists link image charmap print preview anchor',
                                    toolbar_mode: 'floating',
                                });
                            </script> --}}
                        </div>

                        <div class="mb-4">
                            <x-input-label for="slug" :value="__('Custom Slug (optional)')" />
                            <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug', $note->slug)" />
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Leave empty to auto-generate based on title. Changing the slug will change its public URL.</p>
                        </div>

                        <div class="mb-4">
                            <label for="is_public" class="flex items-center">
                                <x-checkbox id="is_public" name="is_public" :checked="old('is_public', $note->is_public)" />
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Make Public') }}</span>
                            </label>
                            <x-input-error :messages="$errors->get('is_public')" class="mt-2" />
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Public notes can be accessed via a unique URL without logging in.</p>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="categories" :value="__('Categories')" />
                            <select multiple id="categories" name="categories[]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', $selectedCategories)) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('categories')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tags" :value="__('Tags')" />
                            <select multiple id="tags" name="tags[]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $selectedTags)) ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button class="ms-4">
                                {{ __('Update Note') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection