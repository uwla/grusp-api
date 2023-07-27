<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Grupo;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    /**
     * Add a bookmark.
     */
    public function store(Request $request, Grupo $grupo)
    {
        $user = $request->user();
        return Bookmark::create([
            'user_id' => $user->id,
            'grupo_id' => $grupo->id,
        ]);
    }

    /**
     * Remove the bookmark.
     */
    public function destroy(Request $request, Grupo $grupo)
    {
        $user = $request->user();
        return Bookmark::where([
            'user_id' => $user->id,
            'grupo_id' => $grupo->id,
        ])->delete();
    }
}
