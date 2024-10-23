<?php

declare(strict_types=1);

namespace Aht\Demo\Model\Brand;

use Aht\Demo\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Aht\Demo\Model\Brand\FileInfo;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends AbstractDataProvider
{
    protected $dataPersistor;
    protected $loadedData;
    protected $collection;
    protected $_storeManager;
    protected $fileInfo;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        DataPersistorInterface $dataPersistor,
        FileInfo $fileInfo,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->_storeManager = $storeManager;
        $this->fileInfo = $fileInfo;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    // public function convertValues($banner)
    // {
    //     $fileName = $banner->getLogo(); 
    //     if ($this->fileInfo->isExist($fileName)) {
    //         $stat = $this->fileInfo->getStat($fileName);
    //         $mime = $this->fileInfo->getMimeType($fileName);
    //         $image = [
    //             'name' => $fileName,
    //             'url' => $this->_storeManager->getStore()->getBaseUrl() . "pub/media/aht/demo/".$fileName,
    //             'size' => isset($stat) ? $stat['size'] : 0,
    //             'type' => $mime,
    //         ];
    //         $banner->setImage([$image]);
    //     }
    //     return $banner;
    // }


    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $model) {
            if ($model->getLogo()) {
                $model->setLogo($this->getLogoData($model->getLogo()));
            }
            $this->loadedData[$model->getId()] = $model->getData();
        }

        // $data = $this->dataPersistor->get('aht_brand');

        // if (!empty($data)) {
        //     $model = $this->collection->getNewEmptyItem();
        //     $model->setData($data);
        //     if (isset($data['logo'])) {
        //         $model->setLogo($data['logo']);
        //     }
        //     $this->loadedData[$model->getId()] = $model->getData();
        //     $this->dataPersistor->clear('aht_brand');
        // }
        return $this->loadedData;
    }

    private function getLogoData($logo)
    {
        $data = [];
        if ($logo) {
            $data[0]['name'] = $logo;
            $data[0]['url'] = $this->_storeManager->getStore()->getBaseUrl() . "media/aht/demo/".$logo;
            $stat = $this->fileInfo->getStat($logo);
            $data[0]['size'] = isset($stat) ? $stat['size'] : 0;
            $data[0]['type'] = $this->fileInfo->getMimeType($logo);
        }
        return $data;

    }
}
