<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Comment::class, 'comment');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // get the validation rules
        $rules = [
            'comment' => 'required|string|min:3|max:500',
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

        // the attributes of the comment
        $attr = [
            'user_id' => $user->id,
            'grupo_id' => $grupo->id,
            'comment' => $request->comment,
        ];

        // create the vote
        $comment = Comment::create($attr);

        // grant the user permission to access the modify/delete the vote
        $permissions = $comment->createCrudPermissions();
        $user->addPermissions($permissions);

        // the user id of the author comment shall not be public
        // but the author name must be public
        $comment->author = $user->name;
        unset($comment->user_id);

        // return the comment
        return $comment;
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Comment $comment)
    // {
    //     $rules = [ 'comment' => 'required|string|min:3|max:500' ];
    //     $request->validate($rules);
    //     $comment->update(['comment' => $request->comment]);
    //     return $comment;
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->deleteThisModelPermissions();
        $comment->delete();
        return $comment;
    }
}
