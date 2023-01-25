<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\ResponseCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $index = User::filter(request('username'))->get();

        return $this->sendResponse($index, 'Data retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        $store = User::create($validated);

        return response($store, 'Data stored successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return $this->sendResponse($user, 'Data retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        if($request->username && $request->email)
        {
            if($request->username != $user->username && $request->email != $user->email)
            {
                $validator = Validator::make($request->all(),[
                    'username' => 'unique:users|string|min:6|max:30',
                    'email' => 'unique:users|email:dns',
                ]);

                if($validator->fails()){
                    return $this->sendError($validator->errors(), ResponseCode::BAD_REQUEST);
                }

                $validated = $request->safe()->merge($validator->validated())->toArray();
            }else if($request->username != $user->username)
            {
                $validator = Validator::make($request->all(),[
                    'username' => 'unique:users|string|min:6|max:30',
                ]);

                if($validator->fails()){
                    return $this->sendError($validator->errors(), ResponseCode::BAD_REQUEST);
                }

                $validated = $request->safe()->merge($validator->validated())->toArray();
            }else if($request->email != $user->email)
            {
                $validator = Validator::make($request->all(),[
                    'email' => 'unique:users|email:dns',
                ]);

                if($validator->fails()){
                    return $this->sendError($validator->errors(), ResponseCode::BAD_REQUEST);
                }

                $validated = $request->safe()->merge($validator->validated())->toArray();
            }else
            {
                $validated = $request->validated();
            }
        }else
        {
            $validated = $request->validated();
        }

        if(isset($validated['password']))
        {
            if(!Hash::check($validated['current_password'], $user->password))
            {
                return $this->sendError('Password does not match.', ResponseCode::BAD_REQUEST);
            }

            $validated['password'] = Hash::make($validated['password']);
        }

        $update = $user->update($validated);

        return $this->sendResponse($update, 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->tokens()->delete();

        $user->delete();

        return $this->sendResponse(null, 'Data deleted successfully.');
    }
}
