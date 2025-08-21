<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function lander()
    {
        return view('pages.lander');
    }

    public function dashboard()
    {
        $stats['tags'] = auth()->user()->tags()->count();
        $stats['links'] = auth()->user()->links()->count();
        return view('pages.dashboard', compact('stats'));
    }
}
