<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Vote::class, 'vote');
    }

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
        // validation rules
        $rules = [
            'vote' => 'required|boolean',
            'grupo_id' => 'required|integer',
        ];

        // validate request
        $request->validate($rules);

        // get the Grupo to be voted on
        $grupo = Grupo::find($request->grupo_id);

        // check if grupo actually exists
        if ($grupo == null)
        {
            return response([
                'errors' => [
                    'grupo_id' => ['Grupo não existe.']
                ]
            ], 422);
        }

        // get the user making the request
        $user = $request->user();

        // the attributes of the new vote
        $attr = [
            'user_id' => $user->id,
            'grupo_id' => $grupo->id,
        ];

        // check if user has already voted here..
        $vote = Vote::where($attr)->first();

        // if vote already exists... this should be a update request (not store)
        if ($vote)
            return $this->update($request, $vote);

        // create the vote
        $attr['vote'] = $request->vote;
        $vote = Vote::create($attr);

        // grant the user permission to access the modify/delete the vote
        $permissions = $vote->createCrudPermissions();
        $user->addPermissions($permissions);

        // return the vote
        return $vote;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vote $vote)
    {
        $rules = ['vote' => 'required|boolean'];
        $request->validate($rules);
        $vote->update(['vote' => $request->vote]);
        return $vote;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vote $vote)
    {
        $vote->deleteThisModelPermissions();
        $vote->delete();
        return $vote;
    }
}
