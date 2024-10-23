<?php

namespace Aht\Demo\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\DataObject;

class Image extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $brand;
    protected $_storeManager;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Aht\Demo\Model\Brand $brand,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->brand = $brand;
        $this->_storeManager = $storeManager;
    }
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$item) {
                $item = $this->prepareItemData($item, $fieldName);
            }
        }

        return $dataSource;
    }
    private function prepareItemData(array $item, string $fieldName): array
    {
        $logoPath = !empty($item['logo']) ? $item['logo'] : '';
        $item[$fieldName . '_src'] = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . "aht/demo/" . $logoPath;
        $item[$fieldName . '_orig_src'] = $item[$fieldName . '_src']; // Same as _src in this case
        $item[$fieldName . '_link'] = $this->urlBuilder->getUrl("aht/demo/edit", ['entity_id' => $item['entity_id']]);
        $item[$fieldName . '_alt'] = isset($item['name']) ? $item['name'] : __('Brand Image');

        return $item;
    }
}
