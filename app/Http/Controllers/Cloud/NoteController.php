<?php

namespace App\Http\Controllers\Cloud;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Note;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class NoteController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = auth()->user()->notes()->paginate(12);
        return view('cloud.notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = auth()->user()->categories()->get();
        $tags = auth()->user()->tags()->get();

        return view('cloud.notes.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:notes,slug'],
            'is_public' => ['boolean'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['uuid', Rule::exists('categories', 'id')->where(function ($query) {
                return $query->where('user_id', auth()->id());
            })],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['uuid', Rule::exists('tags', 'id')->where(function ($query) {
                return $query->where('user_id', auth()->id());
            })],
        ]);

        $slug = $validatedData['slug'] ?? Str::slug($validatedData['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Note::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $note = auth()->user()->notes()->create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'] ?? null,
            'slug' => $slug,
            'is_public' => $validatedData['is_public'] ?? false,
        ]);

        if (isset($validatedData['categories'])) {
            $note->categories()->sync($validatedData['categories']);
        }
        if (isset($validatedData['tags'])) {
            $note->tags()->sync($validatedData['tags']);
        }

        return redirect()->route('cloud.notes.index')->with('success', __('Note created successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return view('cloud.notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        $categories = auth()->user()->categories()->get();
        $tags = auth()->user()->tags()->get();
        $selectedCategories = $note->categories->pluck('id')->toArray();
        $selectedTags = $note->tags->pluck('id')->toArray();

        return view('cloud.notes.edit', compact('note', 'categories', 'tags', 'selectedCategories', 'selectedTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('notes', 'slug')->ignore($note->id)],
            'is_public' => ['boolean'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['uuid', Rule::exists('categories', 'id')->where(function ($query) {
                return $query->where('user_id', auth()->id());
            })],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['uuid', Rule::exists('tags', 'id')->where(function ($query) {
                return $query->where('user_id', auth()->id());
            })],
        ]);

        $slug = $validatedData['slug'] ?? Str::slug($validatedData['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Note::where('slug', $slug)->where('id', '!=', $note->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $note->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'] ?? null,
            'slug' => $slug,
            'is_public' => $validatedData['is_public'] ?? false,
        ]);

        if (isset($validatedData['categories'])) {
            $note->categories()->sync($validatedData['categories']);
        } else {
            $note->categories()->detach();
        }
        if (isset($validatedData['tags'])) {
            $note->tags()->sync($validatedData['tags']);
        } else {
            $note->tags()->detach();
        }

        return redirect()->route('cloud.notes.index')->with('success', __('Note updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('cloud.notes.index')->with('success', __('Note deleted successfully!'));
    }
}