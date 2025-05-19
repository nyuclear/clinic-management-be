<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use App\Http\Resources\UserResource;
use Illuminate\Pagination\Paginator;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        $currentPage = $request->input('current_page', 1);
        $perPage = $request->input('per_page', 10);

        $users = $this->userService->getAllWithRole($currentPage, $perPage);

        return UserResource::collection($users);
    }

    public function show($id)
    {
        $user = $this->userService->getById($id);
        return response()->json($user);
    }

    public function create(UserCreateRequest $request)
    {
        DB::beginTransaction();

        try {   
            $user = User::create($request->all());
            $user->password = Hash::make($request->password);
            $user->save();
            $user->roles()->syncWithoutDetaching($request->role);
            DB::commit();
            return response()->json($user);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->userService->updateWithRole($request->all(), $id);
        return response()->json($user);
    }

    public function delete($id)
    {
        $user = $this->userService->delete($id);
        return response()->json($user);
    }

}
