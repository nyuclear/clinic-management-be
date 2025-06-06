<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function getAll();
    public function getAllWithRole($currentPage, $perPage);
    public function getById($id);
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
}