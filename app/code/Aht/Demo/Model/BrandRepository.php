<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Aht\Demo\Model;

use Aht\Demo\Api\BrandRepositoryInterface;
use Aht\Demo\Api\Data\BrandInterface;
use Aht\Demo\Api\Data\BrandInterfaceFactory;
use Aht\Demo\Api\Data\BrandSearchResultsInterfaceFactory;
use Aht\Demo\Model\ResourceModel\Brand as ResourceBrand;
use Aht\Demo\Model\ResourceModel\Brand\CollectionFactory as BrandCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class BrandRepository implements BrandRepositoryInterface
{

    /**
     * @var BrandCollectionFactory
     */
    protected $brandCollectionFactory;

    /**
     * @var Brand
     */
    protected $searchResultsFactory;

    /**
     * @var BrandInterfaceFactory
     */
    protected $brandFactory;

    /**
     * @var ResourceBrand
     */
    protected $resource;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;


    /**
     * @param ResourceBrand $resource
     * @param BrandInterfaceFactory $brandFactory
     * @param BrandCollectionFactory $brandCollectionFactory
     * @param BrandSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceBrand $resource,
        BrandInterfaceFactory $brandFactory,
        BrandCollectionFactory $brandCollectionFactory,
        BrandSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->brandFactory = $brandFactory;
        $this->brandCollectionFactory = $brandCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(BrandInterface $brand)
    {
        try {
            $this->resource->save($brand);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the brand: %1',
                $exception->getMessage()
            ));
        }
        return $brand;
    }

    /**
     * @inheritDoc
     */
    public function get($brandId)
    {
        $brand = $this->brandFactory->create();
        $this->resource->load($brand, $brandId);
        if (!$brand->getId()) {
            throw new NoSuchEntityException(__('Brand with id "%1" does not exist.', $brandId));
        }
        return $brand;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->brandCollectionFactory->create();
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(BrandInterface $brand)
    {
        try {
            $brandModel = $this->brandFactory->create();
            $this->resource->load($brandModel, $brand->getBrandId());
            $this->resource->delete($brandModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Brand: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($brandId)
    {
        return $this->delete($this->get($brandId));
    }
}
