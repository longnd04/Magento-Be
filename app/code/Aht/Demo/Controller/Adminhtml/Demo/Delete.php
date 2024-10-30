<?php

declare(strict_types=1);

namespace Aht\Demo\Controller\Adminhtml\Demo;

use Aht\Demo\Api\BrandRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\Event\ManagerInterface;

class Delete extends \Aht\Demo\Controller\Adminhtml\Brand 
{
    /**
     * @var BrandRepositoryInterface
     */
    protected $brandRepository;
    
    protected $eventManager; 

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param BrandRepositoryInterface $brandRepository
     */
    public function __construct(
        Context $context,
        BrandRepositoryInterface $brandRepository,
        Registry $coreRegistry,
        ManagerInterface $eventManager, 

    ) {
        parent::__construct($context, $coreRegistry);
        $this->brandRepository = $brandRepository;
        $this->eventManager = $eventManager;
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('entity_id');

        if ($id) {
            try {
                $brand = $this->brandRepository->get($id);
                $this->brandRepository->deleteById($id);
                $this->eventManager->dispatch('custom_aht_delete', ['brand' => $brand]);

                $this->messageManager->addSuccessMessage(__('You deleted the Brand.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a Brand to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
