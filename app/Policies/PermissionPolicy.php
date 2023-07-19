<?php

namespace App\Policies;

use App\Models\Permission;
use Uwla\Lacl\Traits\ResourcePolicy;
use Uwla\Lacl\Contracts\ResourcePolicy as ResourcePolicyContract;

class PermissionPolicy implements ResourcePolicyContract
{
    use ResourcePolicy;

    /**
     * Get the model associated with this Policy.
     */
    public function getResourceModel()
    {
        return Permission::class;
    }
}
