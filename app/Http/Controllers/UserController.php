<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Resources\UserResource;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::with('role')->paginate(5);
        return response()->json(UserResource::collection($users)->response()->getData(), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
      return \response()->json(User::create($request->only('first_name', 'last_name', 'email') +
          ['password' => bcrypt($request->password)]), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
       return \response()->json(new UserResource($user->load('role')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $user->update($request->only('first_name', 'last_name') + [
            'password' => bcrypt($request->password)
            ]);
        return \response()->success($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return \response()->json([],Response::HTTP_NO_CONTENT);
    }

    public function me()
    {
        return \response()->success(new UserResource(auth()->user()->load('role')));
    }

    public function updateInfoCurrentUser(UpdateInfoRequest $request)
    {
        $user = auth()->user();
        $user->update(\request()->only('first_name', 'last_name') + [
                'password' => bcrypt(\request()->password)
            ]);
        return \response()->success($user);
    }
}
