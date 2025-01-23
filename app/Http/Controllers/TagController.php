<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show($id) {
        $tag = Tag::findOrFail($id);

        $accommodations = $tag->accommodations;

        return view('tag.show', compact('tag', 'accommodations'));
    }
}
