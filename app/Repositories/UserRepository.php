<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;


class UserRepository implements UserRepositoryInterface
{
    public function getAll()
    {
        return User::all();
    }

    public function getAllWithRole($currentPage, $perPage)
    {
        return User::with('roles')
            ->withTrashed()
            ->paginate($perPage, ['*'], 'page', $currentPage);
    }

    public function getById($id)
    {
        return User::find($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }   

    public function update(array $data, $id)
    {
        $user = User::find($id);
        $user->update($data);
        return $user;
    }   

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return $user;
    }
    
    
    
}