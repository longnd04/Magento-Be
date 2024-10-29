<?php

declare(strict_types=1);

namespace Aht\Demo\Controller\Adminhtml\Demo;

use Aht\Demo\Api\BrandRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Registry;

class Delete extends \Aht\Demo\Controller\Adminhtml\Brand 
{
    /**
     * @var BrandRepositoryInterface
     */
    protected $brandRepository;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param BrandRepositoryInterface $brandRepository
     */
    public function __construct(
        Context $context,
        BrandRepositoryInterface $brandRepository,
        Registry $coreRegistry
    ) {
        parent::__construct($context, $coreRegistry);
        $this->brandRepository = $brandRepository;
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
                // Xóa brand thông qua BrandRepository
                $this->brandRepository->deleteById($id);
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
