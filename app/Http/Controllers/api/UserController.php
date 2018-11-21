<?php

namespace App\Http\Controllers\api;

use App\Role;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), User::rules());
        if ($validator->fails()) {
            return response()->json($validator->messages(),422);
        }

        $data = [
            'name' => $request['name'],
            'email' => $request['email'],
            'location' => !empty($request['email']) ? $request['email'] : '-',
            'password' => bcrypt($request['password'])
        ];

        $role = Role::findOrFail($request['role_id']);
        $user = User::create($data);
        $user->attachRole($role);
        return response()->json(['message' => 'success','user'=> $user],200);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), User::rules($id));
        if ($validator->fails()) {
            return response()->json($validator->messages(),422);
        }
        $user = JWTAuth::parseToken()->authenticate();
        if($user->hasRole('admin')) {
            $user = User::findOrFail($id);
            $user->email = $request['email'];
            $user->name = $request['name'];
            $user->location = !empty($request['location']) ? $request['location']  : '';
            if ($request['password']) {
                $user->password = bcrypt($request['password']);
            }
            $user->save();
            return response()->json($user);
        }elseif ($user->id == $id){
            $user_ = User::findOrFail($id);

            if($user_->id == $user->id){
                $user->email = $request['email'];
                $user->name = $request['name'];
                $user->location = !empty($request['location']) ? $request['location']  : '';
                if ($request['password']) {
                    $user->password = bcrypt($request['password']);
                }
                $user->save();
                return JsonResponse::create($user);
            }else{
                return JsonResponse::create(['error' => 'access-denied']);
            }
        }
        else{
            return JsonResponse::create(['error' => 'access-denied']);
        }
    }
}
