<?php
namespace Aht\Demo\Model\ResourceModel\Product;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'aht_demo_product_collection';
    protected $_eventObject = 'product_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Aht\Demo\Model\Product', 'Aht\Demo\Model\ResourceModel\Product');
    }
}
