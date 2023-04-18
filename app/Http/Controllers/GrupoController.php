<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Http\Controllers\CrudController;

class GrupoController extends Controller
{
    use CrudController;

    public function model()
    {
        return Grupo::class;
    }

    public function rules()
    {
        return [
            'titulo'    => 'required|string|min:2|max:200',
            'descricao' => 'required|string|max:5000',
        ];
    }
}
