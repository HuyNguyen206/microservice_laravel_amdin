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
    public function __construct()
    {
            $this->middleware(['permission:view_users|edit_users'])->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::with('roles')->latest()->paginate(50);
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
        try {
            $user = User::create($request->validated() +
                ['password' => bcrypt($request->password ?? 'password')]);
            $user->assignRole($request->get('role', 'viewer'));
            return \response()->success($user, Response::HTTP_CREATED);
        }catch (\Throwable $ex) {
            return \response()->error($ex->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
       return \response()->success((new UserResource($user->load('roles'))));
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
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'roles' => 'required'
        ]);
        $user->update($request->only('first_name', 'last_name'));
        $user->assignRole($request->roles);
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
        $user = auth()->user();
        return \response()->success(new UserResource($user->load('roles')));
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
