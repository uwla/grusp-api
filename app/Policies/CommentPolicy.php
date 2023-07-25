<?php

namespace App\Policies;

use App\Models\Comment;
use Uwla\Lacl\Traits\ResourcePolicy;
use Uwla\Lacl\Contracts\ResourcePolicy as ResourcePolicyContract;

class CommentPolicy implements ResourcePolicyContract
{
    use ResourcePolicy;

    /**
     * Get the model class of this resource.
     *
     * @return string
     */
    public function getResourceModel()
    {
        return Comment::class;
    }
}
