<?php

namespace App\Http\Controllers;

use App\Filters\UserFilter;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new UserFilter();
        $filterItems = $filter->transform($request);

        $users = User::where($filterItems)->paginate();
        return UserResource::collection($users->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        // First of all - user should not be able to update username once that is set.
        if(isset($request->username)) {
            return response()->json(['error' => 'username cannot be updated once set'], 500);
        }

        // Check if the user is updating the password. In this case, the old password should match first
        // Otherwise show errors to user.
        if(isset($request->password)) {
            if(!isset($request->oldPassword)) {
                return response()->json(['error' => 'You need to provide the old password before updating your password'], 500);
            }
            if(!Hash::check($request->oldPassword, $user->password)) {
                return response()->json(['error' => 'Username and password combination does not match'], 500);
            }
        }

        // Update all requested fields after password related checks are done.
        $fields = [];
        if(isset($request->password)) $fields['password'] = Hash::make($request->password);
        if(isset($request->email)) $fields['email'] = $request->email;
        if(isset($request->name)) $fields['name'] = $request->name;
        $user->update($fields);

        // If phone is a part of the update, then update the phone number in the profile.
        // Later we will have simple user profile rest operations, we can move this operation there.
        if(isset($request->phone)) {
            $userProfile = UserProfile::where(['user_id' => $user->id]);
            if($userProfile) {
                $userProfile->update([
                    'phone' => $request->phone,
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
