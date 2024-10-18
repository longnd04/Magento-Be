<?php

namespace Aht\Demo\Controller\Adminhtml\Demo;

use Aht\Demo\Model\BrandFactory;
use Magento\Backend\App\Action;

/**
 * Class Save
 */
class Save extends Action
{
    /**
     * @var BrandFactory
     */
    private $postFactory;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param BrandFactory $postFactory
     */
    public function __construct(
        Action\Context $context,
        BrandFactory $postFactory
    ) {
        parent::__construct($context);
        $this->postFactory = $postFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['entity_id']) ? $data['entity_id'] : null;

        $newData = [
            'name' => $data['name'],
            'description' => $data['description'],
            'logo' => $data['logo'],
        ];

        $post = $this->postFactory->create();

        if ($id) {
            $post->load($id);
        }

        try {
            $post->addData($newData);
            $post->save();
            $this->messageManager->addSuccessMessage(__('You saved the post.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        return $this->resultRedirectFactory->create()->setPath('aht/demo/index');
    }
}
