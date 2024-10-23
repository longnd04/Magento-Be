<?php

namespace Aht\Demo\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Helper\Image as ImageHelper;

class BrandDetail extends Template
{
    protected $productCollectionFactory;
    protected $imageHelper;
    public function __construct(
        Template\Context $context,
        CollectionFactory $productCollectionFactory,
        ImageHelper $imageHelper,

        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
        $this->imageHelper = $imageHelper;
    }

    public function getProductbyBrand()
    {
        $brandId = $this->getRequest()->getParam('entity_id');
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->addAttributeToFilter('brand', $brandId);

        return $productCollection;
    }
    public function getImageUrl($product)
    {
        return $this->imageHelper->init($product, 'category_page_list')->getUrl();
    }
}
