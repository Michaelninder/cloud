<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Tags') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="mb-4 text-lg font-semibold">Your Tags</h3>
                    @if($tags->isEmpty())
                        <p class="text-gray-600 dark:text-gray-300">You have no tags yet.</p>
                    @else
                        <div
                            class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
                        >
                            @foreach($tags as $tag)
                                <div
                                    class="rounded-lg bg-gray-100 p-4 shadow-sm dark:bg-gray-700"
                                >
                                    <h4
                                        class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                                    >
                                        {{ $tag->name }}
                                    </h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        {{ Str::limit($tag->description, 46) }}
                                    </p>
                                    <div class="mt-2 flex items-center justify-between">
                                        <a
                                            href="{{ route('cloud.tags.show', $tag->id) }}"
                                            class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                                        >
                                            Show
                                        </a>
                                        <div class="flex items-center space-x-2">
                                            <a
                                                href="{{ route('cloud.tags.edit', $tag->id) }}"
                                                class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                                            >
                                                Edit
                                            </a>
                                            <form
                                                action="{{ route('cloud.tags.destroy', $tag->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this tag?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $tags->links() }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-4">
                <a
                    href="{{ route('cloud.tags.create') }}"
                    class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white ring-gray-300 transition duration-150 ease-in-out hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 active:bg-indigo-900 dark:focus:ring-offset-gray-800"
                >
                    Create new Tag
                </a>
            </div>
        </div>
    </div>
</x-app-layout>