<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Requests\UpdateFavoriteRequest;
use App\Models\User;

class FavoriteController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Favorite::class);

        $index = Favorite::filter(request(['search', 'username']))->get();

        return $this->sendResponse($index, 'Data retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFavoriteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFavoriteRequest $request)
    {
        $this->authorize('create', Favorite::class);

        $validated = $request->validated();
        $validated['user_id'] = User::where('username', $validated['username'])->first()->id;
        
        $store = Favorite::create($validated);

        return $this->sendResponse($store, 'Data stored successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        $this->authorize('view', $favorite);

        return $this->sendResponse($favorite, 'Data retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFavoriteRequest  $request
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFavoriteRequest $request, Favorite $favorite)
    {
        $this->authorize('update', $favorite);

        $validated = $request->validated();
        $validated['user_id'] = User::where('username', $validated['username'])->first()->id;

        $update = $favorite->update($validated);

        return $this->sendResponse($update, 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        $this->authorize('delete', $favorite);

        $favorite->delete();

        return $this->sendResponse(null, 'Data deleted successfully.');
    }
}
