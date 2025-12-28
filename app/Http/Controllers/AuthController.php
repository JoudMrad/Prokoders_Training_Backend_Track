<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());
        return response()->json($result, 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());
        return response()->json($result);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());
        return response()->json(['message' => 'تم تسجيل الخروج بنجاح']);
    }

    public function me(Request $request)
    {
        $user = $this->authService->getCurrentUser($request->user());
        return response()->json($user);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $this->authService->updateProfile($request->user(), $request->validated());
        return response()->json([
            'message' => 'تم تحديث الملف الشخصي بنجاح',
            'user' => $user
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->authService->changePassword($request->user(), $request->validated());
        return response()->json(['message' => 'تم تغيير كلمة المرور بنجاح']);
    }

    public function index(Request $request)
    {
        if (!$request->user() || !$request->user()->is_admin) {
            return response()->json(['message' => 'غير مصرح بالدخول'], 403);
        }

        $perPage = $request->get('per_page', 15);
        return $this->authService->getAllUsers($perPage);
    }

    public function show(Request $request, User $user)
    {
        if (!$request->user() || !$request->user()->is_admin) {
            return response()->json(['message' => 'غير مصرح بالدخول'], 403);
        }

        return new \App\Http\Resources\UserResource($user); 
    }
    
    public function logoutFromAllDevices(Request $request)
    {
        $this->authService->logoutFromAllDevices($request->user());
        return response()->json(['message' => 'تم تسجيل الخروج من جميع الأجهزة بنجاح']);
    }
}