<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    use CrudController;

    public function model()
    {
        return Tag::class;
    }

    public function rules()
    {
        return [
            'name'        => 'required|string|max:50',
            'description' => 'nullable|string|max:250',
        ];
    }
}