<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Http\Requests\StoreContentRequest;
use App\Http\Requests\UpdateContentRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;

class ContentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Content::class);

        $index = Content::filter(request(['search', 'category', 'event']))->get();

        return $this->sendResponse($index, 'Data retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContentRequest $request)
    {
        $this->authorize('create', Content::class);

        $validated = $request->validated();

        $validated['slug'] = SlugService::createSlug(Content::class, 'slug', $validated['title']);
        $validated['excerpt'] = Str::limit(strip_tags($validated['intro']), 200, '...');

        $store = Content::create($validated);

        return $this->sendResponse($store, 'Data stored successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        $this->authorize('view', $content);

        return $this->sendResponse($content, 'Data retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContentRequest  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContentRequest $request, Content $content)
    {
        $this->authorize('update', $content);

        if($request->title != $content->title)
        {
            $add = $request->validate([
                'title' => 'string|unique:contents|min:4'
            ]);
            $validated = $request->safe()->merge($add)->toArray();
            $validated['slug'] = SlugService::createSlug(Content::class, 'slug', $validated['title']);
        }else
        {
            $validated = $request->validated();
        }

        if($request->intro != $content->intro)
        {
            $validated['excerpt'] = Str::limit(strip_tags($validated['intro']), 200, '...');
        }

        $update = $content->update($validated);

        return $this->sendResponse($update, 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        $this->authorize('delete', $content);

        $content->delete();

        return $this->sendResponse(null, 'Data deleted successfully.');
    }
}
