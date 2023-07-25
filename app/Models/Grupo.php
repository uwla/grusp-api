<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Uwla\Ltags\Traits\Taggable;

class Grupo extends Model implements HasMedia
{
    use HasFactory, Taggable, Permissionable, InteractsWithMedia;

    /**
     * The attributes that are not mass assignable.
     * Other attributes will be regarded as mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Get the namespace of the tags associated with this model.
     *
     * @return string
     */
    public function getTagNamespace()
    {
        return 'grupo';
    }

    /**
     * The cover image of the Grupo.
     */
    public function cover_image()
    {
        return $this->hasOne(Media::class, 'model_id')->where('collection_name', 'cover_image');
    }

    /**
     * The content images of the Grupo
     */
    public function content_images()
    {
        return $this->hasMany(Media::class, 'model_id')->where('collection_name', 'content_images');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // VOTES

    /**
     * Get how many upvotes this Grupo has.
     *
     * @return int
     */
    public function upvotes()
    {
        return Vote::where([
            'grupo_id' => $this->id,
            'vote' => true,
        ])->count();
    }

    /**
     * Get how many upvotes this Grupo has.
     *
     * @return int
     */
    public function downvotes()
    {
        return Vote::where([
            'grupo_id' => $this->id,
            'vote' => false,
        ])->count();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // ATTACH ADDITIONAL INFORMATION TO GRUPO

    /**
     * Attach the comments users made on this Grupo.
     *
     * @return $this
     **/
    public function attachComments()
    {
        $comments = Comment::where('grupo_id', $this->id)->get();
        $comments = Comment::withAuthorNames($comments);
        $comments = Comment::withoutGrupoId($comments);
        $this->comments = $comments;
        return $this;
    }

    /**
     * Attach the urls of the media associated with this model.
     *
     * @return $this
     **/
    public function attachMediaUrl()
    {
        // get the urls of the media
        $cover_image = $this->cover_image;
        $cover_image = $cover_image ? $cover_image->getFullUrl() : null;

        $mapImg = fn($img) => ['id' => $img->id, 'url' => $img->getFullUrl()];
        $content_images = $this->content_images;
        $content_images = $content_images ? $content_images->map($mapImg) : array();

        // delete cumbersome attributes (we want just the url)
        unset($this->cover_image);
        unset($this->content_images);

        // attach the url
        $this->img = $cover_image;
        $this->images = $content_images ?? [];

        return $this;
    }

    /**
     * Attach the tags associated with this model
     *
     * @return $this
     **/
    public function attachTags()
    {
        $this->tags = $this->getTagNames();
        return $this;
    }

    /**
     * Attach the votes count of this model
     *
     * @return $this
     **/
    public function attachVotes()
    {
        $this->upvotes = $this->upvotes();
        $this->downvotes = $this->downvotes();
        return $this;
    }

    /**
     * Attach extra data to this model (tags, media, and votes)
     *
     * @return $this
     **/
    public function attachExtraData()
    {
        return $this
            ->attachTags()
            ->attachVotes()
            ->attachMediaUrl()
            ->attachComments();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // ATTACH ADDITION INFORMATION TO MULTIPLE GRUPOS

    /**
     * Get the given grupos with extra data (tags and media)
     *
     * @param  \Illuminate\Database\Eloquent\Collection
     * @return \Illuminate\Database\Eloquent\Collection
     **/
    public static function withExtraData($grupos)
    {
        if ($grupos->count() > 0)
        {
            $grupos = Grupo::withVotes($grupos);
            $grupos = Grupo::withImages($grupos);
            $grupos = Grupo::withTagNames($grupos);
        }
        return $grupos;
    }

    /**
     * Get the given grupos with their votes.
     *
     * @param  \Illuminate\Database\Eloquent\Collection
     * @return \Illuminate\Database\Eloquent\Collection
     **/
    public static function withImages($grupos)
    {
        $id2grupo = [];
        foreach ($grupos as $g)
        {
            $g->cover_image = null;
            $g->content_images = collect([]);
            $id2grupo[$g->id] = $g;
        }

        $ids = $grupos->pluck('ids');
        $mediaFiles = Media::whereIn('model_id', $ids)
            ->where('model_type', Grupo::class)
            ->get();

        foreach ($mediaFiles as $media)
        {
            $url = $media->original_url;
            $gid = $media->model_id;
            $grupo = $id2grupo[$gid];

            if ($media->collection_name == 'cover_image')
                $grupo->cover_image = $url;

            else if ($media->collection_name == 'content_images')
                $grupo->content_images->add($url);
        }

        return $grupos;
    }

    /**
     * Get the given grupos with their votes.
     *
     * @param  \Illuminate\Database\Eloquent\Collection
     * @return \Illuminate\Database\Eloquent\Collection
     **/
    public static function withVotes($grupos)
    {
        $gids = $grupos->pluck('id');
        $votes = Vote::whereIn('grupo_id', $gids)->get();

        $id2grupo = [];
        foreach ($grupos as $g)
            $id2grupo[$g->id] = $g;

        foreach ($grupos as $g)
        {
            $g->upvotes = 0;
            $g->downvotes = 0;
        }

        foreach ($votes as $vote) {
            $gid = $vote->grupo_id;
            $grupo = $id2grupo[$gid];
            if ($vote->vote)
                $grupo->upvotes += 1;
            else
                $grupo->downvotes += 1;
        }

        return $grupos;
    }
}
