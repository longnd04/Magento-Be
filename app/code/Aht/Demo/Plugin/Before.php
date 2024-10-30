<?php

namespace Aht\Demo\Plugin;

use Aht\Demo\Api\Data\BrandInterface;
use Aht\Demo\Api\BrandRepositoryInterface;

class Before
{
    public function beforeSave(BrandRepositoryInterface $subject, BrandInterface $brand)
    {
        $name = $brand->getName();

        if (strpos($name, 'aht') !== 0) {
            $brand->setName('aht ' . $name);
        }

        return [$brand];
    }
}
