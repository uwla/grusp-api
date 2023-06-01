<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GrupoController extends Controller
{
    use CrudController;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Grupo::class, 'grupo');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Grupo::withExtraData(Grupo::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate($this->rules());

        // the tags are not attributes
        unset($attributes['tags']);

        // create the Grupo
        $grupo = Grupo::create($attributes);

        // set the Grupo tags
        $tags = $request->tags;
        if (is_array($tags))
        {
            $tags = Tag::findByName($tags);
            $grupo->addTags($tags);
            $grupo->tags = $tags->pluck('name');
        }

        // handle upload of the cover image (main image)
       if ($request->hasFile('img')) {
           $grupo->addMediaFromRequest('img')
                 ->toMediaCollection('cover_image');
       }

        // handle upload of the images (additional images)
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image)
                $grupo->addMedia($image)->toMediaCollection('content_images');
        }

        // grant the user permission to access the Grupo
        $user = $request->user();
        $grupo->createCrudPermissions();
        $grupo->attachCrudPermissions($user);

        // return the Grupo
        return $grupo;
    }

    /**
     * Display the specified resource.
     */
    public function show(Grupo $grupo)
    {
        return $grupo->attachExtraData();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grupo $grupo)
    {
        $attributes = $request->validate($this->rules());

        // the tags are not attributes
        unset($attributes['tags']);

        // update attributes
        $grupo->update($attributes);

        // set the Grupo tags
        $tags = $request->tags;
        if (is_array($request->tags)) {
            $tags = Tag::findByName($tags);
            $grupo->setTags($tags);
            $grupo->tags = $tags->pluck('name');
        } else {
            $grupo->delAllTags();
        }

        // handle upload of the cover image (main image)
        if ($request->hasFile('img')) {
            $grupo->clearMediaCollection('cover_image');
            $grupo->addMediaFromRequest('img')
                  ->toMediaCollection('cover_image');
        }

        // handle upload of the images (additional images)
        if ($request->hasFile('images')) {
            $grupo->clearMediaCollection('content_images');
            $images = $request->file('images');
            foreach ($images as $image)
                $grupo->addMedia($image)->toMediaCollection('content_images');
        }


        // return the updated Grupo
        return $grupo;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grupo $grupo)
    {
        // require user password before deleting the Grupo
        $request = request();
        $request->validate([ 'password' => 'required|current_password' ]);

        $grupo->deletetThisModelPermissions();
        $grupo->delete();
        return $grupo;
    }

    /**
     * Get the validation rules.
     */
    public function rules()
    {
        $tags = Tag::taggedBy('taggable'); // only tags that are taggable
        $tag_rule = Rule::in($tags->pluck('name'));
        $optional_text_rules = 'nullable|string|max:300';

        return [
            'titulo'      => 'required|string|min:2|max:200',
            'descricao'   => 'required|string|max:5000',
            'img'         => 'nullable|mimes:jpg,png',
            'images'      => 'nullable|array|min:1|max:15',
            'images.*'    => 'mimes:jpg,png',
            'tags'        => 'nullable|array|min:1|max:15',
            'tags.*'      => $tag_rule,

            // the following fields are unstructured data
            // because I did not want to restrict users in their answer format,
            // and wanted to give them more flexibility to suit their needs
            'contato'     => $optional_text_rules,
            'horario'     => $optional_text_rules,
            'links'       => $optional_text_rules,
            'lugar'       => $optional_text_rules,
            'mensalidade' => $optional_text_rules,
            'publico'     => $optional_text_rules,
        ];
    }
}
