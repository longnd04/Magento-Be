<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Aht\Demo\Api\Data;

interface BrandSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Brand list.
     * @return \Aht\Demo\Api\Data\BrandInterface[]
     */
    public function getItems();

    /**
     * Set name list.
     * @param \Aht\Demo\Api\Data\BrandInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
