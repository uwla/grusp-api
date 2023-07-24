<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class VoteController extends Controller
{
    /**
     * Display a listing of the user's votes.
     */
    public function index()
    {
        $user = auth()->user();
        return Vote::where('user_id', $user->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $rules = [
            'vote' => 'required|boolean',
            'grupo_id' => 'required|integer'
        ];
        $request->validate($rules);

        // get the Grupo
        $grupo = Grupo::find($request->grupo_id);
        if ($grupo == null)
        {
            return response([
                'errors' => [
                    'grupo_id' => ['Grupo não existe.']
                ]
            ], 422);
        }

        // get the user
        $user = $request->user();

        // vote
        if ($request->vote)
            $vote = $user->upvote($grupo);
        else
            $vote = $user->downvote($grupo);

        return $vote;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vote $vote)
    {
        $user = auth()->user();
        if ($vote->user_id != $user->id)
            return new AuthorizationException;
        $vote->delete();
        return $vote;
    }
}
