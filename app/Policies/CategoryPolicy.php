<?php

namespace App\Policies;

use App\Models\Category;
use Uwla\Lacl\Traits\ResourcePolicy;
use Uwla\Lacl\Contracts\ResourcePolicy as ResourcePolicyContract;

class CategoryPolicy implements ResourcePolicyContract
{
    use ResourcePolicy;

    /**
     * Get the model associated with this Policy.
     */
    public function getResourceModel()
    {
        return Category::class;
    }
}
