<?php

namespace Aht\Demo\Block;

use Magento\Framework\View\Element\Template;
use Aht\Demo\Model\ResourceModel\Brand\CollectionFactory;

class Index extends Template
{
    protected $brandCollectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $brandCollectionFactory,
        array $data = []
    ) {
        $this->brandCollectionFactory = $brandCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getBrands()
    {
        if (!$this->hasData('brands')) {
            $brandCollection = $this->brandCollectionFactory->create();
            $brandCollection->addFieldToSelect('*');
            $this->setData('brands', $brandCollection);
        }
        return $this->getData('brands');
    }
}
