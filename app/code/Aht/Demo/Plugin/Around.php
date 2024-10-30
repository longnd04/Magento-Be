<?php

namespace Aht\Demo\Plugin;

use Aht\Demo\Api\Data\BrandInterface;
use Aht\Demo\Api\BrandRepositoryInterface;

class Around
{

    public function aroundSave(
        BrandRepositoryInterface $subject,
        callable $proceed,
        BrandInterface $brand
    ) {
        // Lấy giá hiện tại
        $price = $brand->getDescription(); 

        // Cộng thêm 100 vào giá
        if ($price !== null) {
            $brand->getDescription($price + 100);
        }

        // Gọi phương thức gốc để lưu
        return $proceed($brand);
    }
}
