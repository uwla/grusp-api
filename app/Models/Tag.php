<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Uwla\Ltags\Models\Tag as BaseTag;

/**
 * A tag is used to group related Grupo models.
 */
class Tag extends BaseTag
{
    use HasFactory, Permissionable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 'name', 'description', 'namespace' ];

    /**
     * Get the namespace for the tags that label this model.
     *
     * @return string
     */
    public function getTagNamespace()
    {
        return 'tag';
    }

    /**
     * Attach the categories to the given tags.
     */
    public static function withCategories($tags)
    {
        $tags = Tag::withTagNames($tags);
        foreach ($tags as $tag)
        {
            $tag->category = $tag->tags->first();
            unset($tag->tags);
        }
        return $tags;
    }
}
