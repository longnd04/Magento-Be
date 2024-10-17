<?php

namespace Aht\Demo\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    private $_postFactory;

    public function __construct(\Aht\Demo\Model\BrandFactory $postFactory)
    {
        $this->_postFactory = $postFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $data = [
                'name' => "It is Test Upgrade Data",
                'description' => "t is Test's description Upgrade Data",
                'images' => "test.jpg Upgrade Data",
            ];
            $post = $this->_postFactory->create();
            $post->addData($data)->save();
        }
        $setup->startSetup();
    }
}
