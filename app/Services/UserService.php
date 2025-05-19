<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }   

    public function getAllWithRole($currentPage, $perPage)
    {
        return $this->userRepository->getAllWithRole($currentPage, $perPage);
    }

    public function getById($id)
    {
        return $this->userRepository->getById($id);
    }   

    public function create(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->userRepository->update($data, $id);
    }
    
    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }
    
    public function updateWithRole(array $data, $id)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->getById($id);
            $user->update($data);

            if (isset($data['role'])) {
                $user->roles()->syncWithoutDetaching($data['role']);
            }

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}