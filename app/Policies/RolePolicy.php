<?php

namespace App\Policies;

use App\Models\Role;
use Uwla\Lacl\Traits\ResourcePolicy;
use Uwla\Lacl\Contracts\ResourcePolicy as ResourcePolicyContract;

class RolePolicy implements ResourcePolicyContract
{
    use ResourcePolicy;

    /**
     * Get the model associated with this Policy.
     */
    public function getResourceModel()
    {
        return Role::class;
    }
}
