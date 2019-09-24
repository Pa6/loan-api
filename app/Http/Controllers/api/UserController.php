<?php
/* created by pacoder */
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

    /**
     * Documentation Block
     * @api {get} /user Get user
     * @apiName Get user
     * @apiGroup User
     * @apiSuccess {object} Success-Response  On success returns an array containing all users
     * @apiError (401) {object} Access-denied If token not token or it expired
     */
    public function index(){
        return response()->json(User::all());
    }

    /**
     * Documentation Block
     * @api {get} /user/{id}/show Get one user
     * @apiName Get user
     * @apiGroup Payment
     * @apiSuccess {object} Success-Response  On success returns an object containing user
     * @apiError (401) {object} Access-denied If token not token or it expired
     */
    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    /**
     * Documentation Block
     * @api {post} /user Register new user
     * @apiName Register
     * @apiGroup API-User
     * @apiError (422) {object} Unprocessable-Entity If a validation occurs. the api returns and object of validation errors
     * @apiSuccess {object} Success-Response  On success returns an object containing created entity
     * @apiError (401) {object} Access-denied If token not token or it expired
     * @apiError {object} Error with status code accordingly as well details of the error
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), User::rules());
        if ($validator->fails()) {
            return response()->json($validator->messages(),422);
        }

        $data = [
            'first_name' => $request['first_name'],
            'email' => $request['email'],
            'last_name' => $request['last_name'],
            'password' => bcrypt($request['password'])
        ];

        $role = Role::findOrFail($request['role_id']);
        $user = User::create($data);
        $user->attachRole($role);
        return response()->json(['message' => 'success','user'=> $user],200);
    }


    /**
     * Documentation Block
     * @api {patch} /user/{id} Update new user
     * @apiName Update
     * @apiGroup API-User
     * @apiError (422) {object} Unprocessable-Entity If a validation occurs. the api returns and object of validation errors
     * @apiSuccess {object} Success-Response  On success returns an object containing updated entity
     * @apiError {object} Error with status code accordingly as well details of the error
     */
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
            $user->first_name = $request['first_name'];
            $user->last_name = $request['last_name'];
            if ($request['password']) {
                $user->password = bcrypt($request['password']);
            }
            $user->save();
            return response()->json($user);
        }elseif ($user->id == $id){
            $user_ = User::findOrFail($id);

            if($user_->id == $user->id){
                $user->email = $request['email'];
                $user->first_name = $request['first_name'];
                $user->last_name = $request['last_name'];
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
