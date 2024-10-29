<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Aht\Demo\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface BrandRepositoryInterface
{

    /**
     * Save Brand
     * @param \Aht\Demo\Api\Data\BrandInterface $brand
     * @return \Aht\Demo\Api\Data\BrandInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Aht\Demo\Api\Data\BrandInterface $brand);

    /**
     * Retrieve Brand
     * @param string $brandId
     * @return \Aht\Demo\Api\Data\BrandInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($brandId);

    /**
     * Retrieve Brand matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Aht\Demo\Api\Data\BrandSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Brand
     * @param \Aht\Demo\Api\Data\BrandInterface $brand
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Aht\Demo\Api\Data\BrandInterface $brand);

    /**
     * Delete Brand by ID
     * @param string $brandId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($brandId);
}
