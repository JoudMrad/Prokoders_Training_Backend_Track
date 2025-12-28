<?php

namespace App\Services;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\UserCollection;

class AuthService
{
    
    public function register(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];
    }
    
    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['بيانات الدخول غير صحيحة'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];
    }

    public function logout(User $user): void
    {
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
    }
    
    public function getCurrentUser(User $user): UserResource
    {
        return new UserResource($user);
    }
    
    public function updateProfile(User $user, array $data): UserResource
    {
        $user->update($data);
        return new UserResource($user->fresh());
    }
    
    public function changePassword(User $user, array $data): void
    {
        if (!Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['كلمة المرور الحالية غير صحيحة'],
            ]);
        }

        $user->update([
            'password' => Hash::make($data['password'])
        ]);
    }
    
    public function getAllUsers(int $perPage = 15): UserCollection
    {
        $users = User::paginate($perPage);
        return new UserCollection($users);
    }
    
    public function logoutFromAllDevices(User $user): void
    {
        $user->tokens()->delete();
    }
}