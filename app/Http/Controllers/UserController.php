<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('logout', 'info');
    }

    /**
     *用户登录
     *
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if ($user) {

            return $this->success([
                'token' => Auth::user()->createToken('auth_token')->plainTextToken
            ]);
        }
        return $this->failed('账号或密码错误', 500);
    }

    /**
     *用户注册
     *
     */
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|min:3|max:20',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->email),
        ]);

        return $this->success([
            'token' => $user->createToken('auth_token')->plainTextToken
        ], 'success');

    }

    /**
     *用户登出
     *
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return $this->success('成功');
    }

    /**
     *用户信息
     */
    public function info(Request $request)
    {
        $user = $request->user();

        return $this->success(UserResource::make($user));
    }

    /**
     *
     * 用户列表
     *
     **/

    public function list(Request $request)
    {
        $users = User::query()->paginate(16);
        return $this->success(new UserCollection($users));
    }

    /*
     *用户分配角色
     *
     */
    public function assignRole(Request $request)
    {
        $user = User::query()->findOrFail($request->id);

        $roleIds = $request->role_ids;
        $roles = Role::query()->whereIn('id', $roleIds)->get();


        $user->syncRoles($roles);

        return $this->success('角色分配成功!');
    }
}
