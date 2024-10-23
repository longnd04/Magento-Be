<?php

namespace Aht\Demo\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Aht\Demo\Model\ResourceModel\Brand\CollectionFactory;

class Brand extends AbstractSource
{
    protected $brandCollectionFactory;

    public function __construct(CollectionFactory $brandCollectionFactory)
    {
        $this->brandCollectionFactory = $brandCollectionFactory;
    }

    public function getAllOptions()
    {
        if (!$this->_options) {
            $brandCollection = $this->brandCollectionFactory->create();

            foreach ($brandCollection as $brand) {
                $this->_options[] = [
                    'label' => $brand->getName(), 
                    'value' => $brand->getId(),   
                ];
            }
        }
        return $this->_options;
    }
}
