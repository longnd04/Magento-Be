<?php

namespace Aht\Demo\Api;

interface BrandRepositoryInterface
{
    public function getAllBrand();

    public function getById(String $id);

    public function createBrand(\Aht\Demo\Api\Data\BrandInterface $data);

    public function updateBrand(String $id, \Aht\Demo\Api\Data\BrandInterface $data);

    public function save(\Aht\Demo\Api\Data\BrandInterface $brand);

    public function delete(String $id);
}
