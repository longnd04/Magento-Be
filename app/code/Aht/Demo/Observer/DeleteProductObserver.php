<?php

namespace Aht\Demo\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

class DeleteProductObserver implements ObserverInterface
{
    protected $messageManager;

    public function __construct(ManagerInterface $messageManager)
    {
        $this->messageManager = $messageManager;
    }

    public function execute(Observer $observer)
    {
        $brand = $observer->getData('brand');
        
        if ($brand) {
            $this->messageManager->addSuccessMessage(__(' the Brand: %1', $brand->getName()));
        } else {
            $this->messageManager->addErrorMessage(__('Brand not found.'));
        }
    }
}
