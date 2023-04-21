<?php

namespace App\Policies;

use App\Models\Tag;
use Uwla\Lacl\Traits\ResourcePolicy;
use Uwla\Lacl\Contracts\ResourcePolicy as ResourcePolicyContract;

class TagPolicy implements ResourcePolicyContract
{
     use ResourcePolicy;

    /**
     * Get the model associated with this Policy.
     */
    public function getResourceModel()
    {
        return Tag::class;
    }
}
