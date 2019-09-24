<?php

/* created by pacoder */
namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{

    /**
     * @api {post} /authentication/ Authenticate
     * @apiName Post AUTHENTICATE
     * @apiGroup AUTHENTICATION
     * @apiSuccess {object} AuthenticateObject Returns Object of authenticated user.
     * @apiSuccessExample AuthenticateObject
     * HTTP/1.1 200 AuthenticateObject
     * {
     *  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODA4MlwvYXV0aGVudGljYXRlIiwiaWF0IjoxNTQyODI0NTE3LCJleHAiOjE1NDI4MjgxMTcsIm5iZiI6MTU0MjgyNDUxNywianRpIjoiQThRbmd6RWtNUFh4YjhOeCIsInN1YiI6MywicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.BE1zwitfV14gv0ksn1b0K54krj1JYM9Kvl6teRDvS8s"
     * }
     *
     * @apiParam {string} email email
     * @apiParam {string}  password password
     *
     * @apiError {object} Unprocessable  Entity Returns error <code>422</code> if required field are not filled
     * @apiErrorExample UnprocessableEntity
     * HTTP/1.1 404 UnprocessableEntity
     * @apiError {object} Unprocessable  Entity Returns error <code>422</code> if required field are not filled
     * @apiErrorExample UnprocessableEntity
     * HTTP/1.1 404 UnprocessableEntity

     * {
     * "email": [
     * "The email field is required."
     * ],
     * "password": [
     * "The password field is required."
     * ]
     * }
     *
     *
     *
     * @apiError {Array} Access-Denied If email doesnt match password , It will return a <code>401:Access-Denied</code> error code.
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 401 Access Denied
     *  {
     *    "error":"access-denied"
     *  }
     */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('phone', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'access-denied'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = Auth::user();
        // all good so return the token
        return response()->json(compact('token', 'user'));
    }
}
