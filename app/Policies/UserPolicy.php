<?php

namespace App\Policies;

use App\Models\User;
use Uwla\Lacl\Traits\ResourcePolicy;
use Uwla\Lacl\Contracts\ResourcePolicy as ResourcePolicyContract;

class UserPolicy implements ResourcePolicyContract
{
    use ResourcePolicy;

    /**
     * Get the model associated with this Policy.
     */
    public function getResourceModel()
    {
        return User::class;
    }
}
