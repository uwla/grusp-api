<?php

namespace App\Policies;

use App\Models\Grupo;
use Uwla\Lacl\Traits\ResourcePolicy;
use Uwla\Lacl\Contracts\ResourcePolicy as ResourcePolicyContract;

class GrupoPolicy implements ResourcePolicyContract
{
    use ResourcePolicy;

    /**
     * Get the model associated with this Policy.
     */
    public function getResourceModel()
    {
        return Grupo::class;
    }
}
