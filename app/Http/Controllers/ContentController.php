<?php

namespace App\Http\Controllers;

use App\Enums\ContentEvent;
use App\Models\Content;
use App\Http\Requests\StoreContentRequest;
use App\Http\Requests\UpdateContentRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class ContentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $index = Content::filter(request(['search', 'title', 'category', 'event']))->get();

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

        if(isset($validated['event'])){
            $validator = Validator::make($validated, [
                'event' => [new Enum(ContentEvent::class)],
            ]);

            if($validator->fails()){
                return $this->sendError($validator->errors(), 400);
            }

            $validated = array_merge($validated, $validator->validated());
        }

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

        if(isset($request->title) && $request->title != $content->title)
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

        if(isset($validated['event'])){
            $validator = Validator::make($validated, [
                'event' => [new Enum(ContentEvent::class)],
            ]);

            if($validator->fails()){
                return $this->sendError($validator->errors(), 400);
            }

            $validated = array_merge($validated, $validator->validated());
        }

        if(isset($validated['intro']) && $validated['intro'] != $content->intro)
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
