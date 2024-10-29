<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Aht\Demo\Model;

use Aht\Demo\Api\Data\BrandInterface;
use Magento\Framework\Model\AbstractModel;

class Brand extends AbstractModel implements BrandInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Aht\Demo\Model\ResourceModel\Brand::class);
    }

    /**
     * @inheritDoc
     */
    public function getBrandId()
    {
        return $this->getData(self::BRAND_ID);
    }

    /**
     * @inheritDoc
     */
    public function setBrandId($brandId)
    {
        return $this->setData(self::BRAND_ID, $brandId);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getLogo()
    {
        return $this->getData(self::LOGO);
    }

    /**
     * @inheritDoc
     */
    public function setLogo($logo)
    {
        return $this->setData(self::LOGO, $logo);
    }
}
