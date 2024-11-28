<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => "required|email",
                'password' => "required",
            ]);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'code' => 422,
                    'status' => 'error',
                    'data' => null,
                    'message' => 'Kredensial tidak sesuai atau akun Anda telah dinonaktifkan'
                ], 422);
            }

            $user = User::where('email', $credentials['email'])->first();

            // $user->tokens()->delete();
            $generateToken = $user->createToken($credentials['email'], ['*'], now()->addHours(4));

            return response()->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'Login successful. Welcome back!',
                'data' => [
                    'id' => $user->id,
                    'token' => $generateToken->plainTextToken,
                ]
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => $e->getMessage(),
                'data' => null
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Something went wrong, please try again later',
                'data' => null
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'Logout successful. Goodbye!',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Something went wrong, please try again later',
                'data' => null
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $credentials = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ]);

            $credentials['password'] = bcrypt($credentials['password']);

            $user = User::create($credentials);

            return response()->json([
                'status' => 'success',
                'code' => 201,
                'message' => 'Register successful. Welcome!',
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => $e->getMessage(),
                'data' => null
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Something went wrong, please try again later',
                'data' => null
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
