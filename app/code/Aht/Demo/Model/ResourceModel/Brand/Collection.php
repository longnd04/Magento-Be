<?php
namespace Aht\Demo\Model\ResourceModel\Brand;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'aht_demo_brand_collection';
    protected $_eventObject = 'brand_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Aht\Demo\Model\Brand', 'Aht\Demo\Model\ResourceModel\Brand');
    }
}
