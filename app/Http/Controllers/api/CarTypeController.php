<?php

namespace App\Http\Controllers\api;

use App\Car;
use App\CarType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class CarTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $user = JWTAuth::parseToken()->authenticate();

        return response()->json(CarType::all());


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $rules = [
            'name' => 'required',
            'details' => 'required',

        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return response()->json($validation->messages(), 422);
        }
        if($user->hasRole('admin')){
            $model = CarType::create($request->all());
            return response()->json($model);
        }else{
            return response()->json(['error' => 'access-denied'], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(CarType::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if($user->hasRole('admin')){
            $model = CarType::findOrFail($id);
            $model->update($request->all());
            $model->save();
            return response()->json($model);
        }else{
            return response()->json(['error' => 'access-denied'], 401);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user->hasRole('admin')){
            $model = CarType::findOrFail($id);
            $model->delete();
            return response()->json(['message' => 'model deleted successfully'], 200);
        }else{
            return response()->json(['error' => 'access-denied'], 401);
        }

    }
}
