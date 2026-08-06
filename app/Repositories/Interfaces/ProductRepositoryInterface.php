<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll();

    public function findById($id);

    public function create(array $data);

    public function update($product, array $data);

    public function delete($product);
}