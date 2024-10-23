<?php
namespace Aht\Demo\Controller\Demo;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Detail extends Action
{
    protected $pageFactory;
    protected $productCollectionFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
    ) {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->pageFactory->create();
    }
}