<?php

namespace App\Http\Controllers\Cloud;

use App\Http\Controllers\Controller;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = auth()->user()->links()->paginate(12);
        return view('cloud.links.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cloud.links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => ['required', 'string', 'url'],
            'slug' => ['nullable', 'string', 'max:5', 'unique:links,slug'],
        ]);

        $slug = $request->input('slug');
        if (empty($slug)) {
            do {
                $slug = Str::random(5);
            } while (Link::where('slug', $slug)->exists());
        }

        $link = Link::create([
            'user_id' => auth()->user()->id,
            'original_url' => $request->input('original_url'),
            'slug' => $slug,
        ]);

        return redirect()->route('cloud.links.index')->with('success', __('Link created successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        $link = Link::findOrFail($link->id);
        /*dd($link);
        if ($link->user_id !== auth()->id()) {
            abort(403);
        }*/
        return view('cloud.links.show', compact('link'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        //
    }
}
