<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class GrupoController extends Controller
{
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
        // main image is required to create a grupo
        $rules = $this->rules();
        $rules['img'][] = 'required';

        $attributes = $request->validate($rules);

        // the tags are not attributes
        unset($attributes['tags']);

        // create the Grupo
        $grupo = Grupo::create($attributes);

        // set the Grupo tags
        $tags = $request->tags;
        if (is_array($tags))
        {
            $tags = Tag::findByName($tags, 'grupo');
            $grupo->addTags($tags);
            $grupo->tags = $tags->pluck('name');
        }

        // handle upload of the cover image (main image)
       if ($request->hasFile('img')) {
            // random file name
            $ext = $request->img->getClientOriginalExtension();
            $name = Str::upper(Str::random());
            $filename = "{$name}{$ext}";

            // add file
           $grupo->addMediaFromRequest('img')
                 ->usingFileName($filename)
                 ->toMediaCollection('cover_image');
       }

        // handle upload of the images (additional images)
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image)
            {
                // random name
                $ext = $image->getClientOriginalExtension();
                $name = Str::upper(Str::random());
                $filename = "{$name}.{$ext}";

                // add image
                $grupo->addMedia($image)
                    ->usingFileName($filename)
                    ->toMediaCollection('content_images');
            }
        }

        // grant the user permission to access the Grupo
        $user = $request->user();
        $permissions = $grupo->createCrudPermissions();
        $user->addPermissions($permissions);

        // return the Grupo
        return $grupo->attachMediaUrl();
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
        $rules = $this->rules();

        // main image is not required to create a grupo
        $rules = $this->rules();
        $rules['img'][] = 'nullable';

        // to update a Grupo, we need to add a rule to ensure proper deletion of images
        $content_images = $grupo->content_images();
        if ($content_images)
        {
            $ids = $content_images->pluck('id');
            $delete_image_rule = Rule::in($ids);
            $rules['images_del'] = 'nullable|array|min:1|max:20';
            $rules['images_del.*'] = $delete_image_rule;
        }

        // validate it
        $attributes = $request->validate($rules);

        // the tags are not attributes
        unset($attributes['tags']);

        // update attributes
        $grupo->update($attributes);

        // set the Grupo tags
        $tags = $request->tags;
        if (is_array($request->tags)) {
            $tags = Tag::findByName($tags, 'grupo');
            $grupo->setTags($tags);
            $grupo->tags = $tags->pluck('name');
        } else {
            $grupo->delAllTags();
        }

        // handle upload of the cover image (main image)
        if ($request->hasFile('img')) {
            // random file name
            $ext = $request->img->getClientOriginalExtension();
            $name = Str::upper(Str::random());
            $filename = "{$name}{$ext}";

            // add file
            $grupo->clearMediaCollection('cover_image');
            $grupo->addMediaFromRequest('img')
                  ->usingFileName($filename)
                  ->toMediaCollection('cover_image');
        }

        // handle upload of the images (additional images)
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image)
            {
                // random filename
                $ext = $image->getClientOriginalExtension();
                $name = Str::upper(Str::random());
                $filename = "{$name}.{$ext}";

                // add image
                $grupo->addMedia($image)
                    ->usingFileName($filename)
                    ->toMediaCollection('content_images');
            }
        }

        // handle deletion of the images
        if ($request->has('images_del'))
        {
            // Laravel Media Library will delete the file associated with the model
            // upon calling the `delete()` method on the model
            $ids = $request->images_del;
            foreach ($ids as $id)
                Media::find($id)->delete();
        }

            // return the updated Grupo
            return $grupo->attachMediaUrl();
        }

    /**
     * Delete the specified resource.
     */
    public function destroy(Grupo $grupo)
    {
        $request = request();
        $request->validate(['password' => 'required|current_password']);
        $grupo->deleteThisModelPermissions();
        $grupo->clearMediaCollection('cover_images');
        $grupo->clearMediaCollection('content_images');
        $grupo->delete();
        return $grupo;
    }

    /**
     * Get the validation rules.
     */
    public function rules()
    {
        $tags = Tag::where('namespace', 'grupo')->get();
        $tag_rule = Rule::in($tags->pluck('name'));
        $optional_text_rules = 'nullable|string|min:5|max:300';

        return [
            'titulo'      => 'required|string|min:2|max:200',
            'descricao'   => 'required|string|min:10|max:1500',
            'img'         => ['mimes:jpg,png', 'min:1', 'max:2000', 'dimensions:min_width=200,max_width=800,ratio=1/1'],
            'images'      => 'nullable|array|min:1|max:15',
            'images.*'    => 'mimes:jpg,png|min:1|max:2000',
            'tags'        => 'nullable|array|min:1|max:15',
            'tags.*'      => [$tag_rule],

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
