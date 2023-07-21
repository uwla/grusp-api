<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Tag::class, 'tag');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::withTagNames(Tag::where('namespace', 'grupo')->get());
        foreach ($tags as $tag)
        {
            $tag->category = $tag->tags->first();
            unset($tag->tags);
        }
        return $tags;
    }

    /**
     * Show a specific resource.
     */
    public function show(Tag $tag)
    {
        return $tag;
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated['namespace'] = 'grupo';
        $tag = Tag::create($validated);
        $tag->setTags([$request->category]);
        $tag->category = $request->category;
        return $tag;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate($this->rules());
        $tag->update($validated);
        $tag->setTags([$request->category]);
        $tag->category = $request->category;
        return $tag;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $request = request();
        $request->validate(['password' => 'required|current_password']);
        $tag->deleteThisModelPermissions();
        $tag->delete();
        return $tag;
    }

    /**
     * Get the validation rules.
     */
    public function rules()
    {
        $categories = Tag::where('namespace', 'tag')->pluck('name');
        $in = Rule::in($categories);
        return [
            'name'        => 'required|string|max:50',
            'description' => 'nullable|string|max:250',
            'category'    => ['required', 'string', $in],
        ];
    }
}
