<?php

namespace Aht\Demo\Model\ResourceModel;

class Brand extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('aht_brand', 'entity_id');
    }
}
