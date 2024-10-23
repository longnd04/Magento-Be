<?php

namespace Aht\Demo\Model;

use \Magento\Framework\DataObject\IdentityInterface;
use Aht\Demo\Api\Data\BrandInterface;

class Brand extends \Magento\Framework\Model\AbstractModel implements BrandInterface, IdentityInterface
{
    const CACHE_TAG = 'aht_demo_brand_post';

    /**
     * Model cache tag for clear cache in after save and after delete
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = self::CACHE_TAG;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Aht\Demo\Model\ResourceModel\Brand');
    }

    /**
     * Return a unique id for the model.
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }


    public function getId()
    {
        return $this->getData('entity_id');
    }
    public function setId($id)
    {
        return $this->setData('entity_id', $id);
    }
    public function getName()
    {
        return $this->getData('name');
    }
    public function setName($name)
    {
        return $this->setData('name', $name);
    }
    public function getDescription()
    {
        return $this->getData('description');
    }
    public function setDescription($description)
    {
        return $this->setData('description', $description);
    }
    public function getLogo()
    {
        return $this->getData('logo');
    }
    public function setLogo($logo)
    {
        return $this->setData('logo', $logo);
    }
}
