<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Link; // Make sure to import the Link model

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

        $stats['link_views'] = 0;
        $userLinks = auth()->user()->links;
        foreach ($userLinks as $link) {
            $stats['link_views'] += $link->views()->count();
        }


        $stats['notes'] = auth()->user()->notes()->count();

        return view('pages.dashboard', compact('stats'));
    }
}