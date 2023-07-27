<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, Permissionable;

    /**
     * Attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Attributes that hidden in requests.
     *
     * @var array
     */
    protected $hidden = ['user_id'];

    /**
     * Get the given comments with their author names.
     *
     * @param  \Illuminate\Database\Eloquent\Collection $comments
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function withAuthorNames($comments)
    {
        // get the users
        $uids = $comments->pluck('user_id');
        $users = User::whereIn('id', $uids)->get();

        // build a lookup table for fast access
        $id2username = [];
        foreach ($users as $u)
            $id2username[$u->id] = $u->name;

        // update the comments
        foreach ($comments as $c)
        {
            $uid = $c->user_id;
            $name = $id2username[$uid];
            $c->author = $name;
            unset($c->user_id); // this field is not desire for public output
        }

        return $comments;
    }

   /**
     * Get the given comments without the grupo id.
     *
     * @param  \Illuminate\Database\Eloquent\Collection $comments
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function withoutGrupoId($comments)
    {
        foreach ($comments as $c)
            unset($c->grupo_id);
        return $comments;
    }

    /**
     * Serialize the date attributes of this model.
     *
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d h:i:s');
    }
}
