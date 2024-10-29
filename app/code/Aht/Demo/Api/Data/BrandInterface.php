<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Aht\Demo\Api\Data;

interface BrandInterface
{

    const LOGO = 'logo';
    const BRAND_ID = 'entity_id';
    const DESCRIPTION = 'description';
    const NAME = 'name';

    /**
     * Get brand_id
     * @return string|null
     */
    public function getBrandId();

    /**
     * Set brand_id
     * @param string $brandId
     * @return \Aht\Demo\Brand\Api\Data\BrandInterface
     */
    public function setBrandId($brandId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Aht\Demo\Brand\Api\Data\BrandInterface
     */
    public function setName($name);

    /**
     * Get description
     * @return string|null
     */
    public function getDescription();

    /**
     * Set description
     * @param string $description
     * @return \Aht\Demo\Brand\Api\Data\BrandInterface
     */
    public function setDescription($description);

    /**
     * Get logo
     * @return string|null
     */
    public function getLogo();

    /**
     * Set logo
     * @param string $logo
     * @return \Aht\Demo\Brand\Api\Data\BrandInterface
     */
    public function setLogo($logo);
}
