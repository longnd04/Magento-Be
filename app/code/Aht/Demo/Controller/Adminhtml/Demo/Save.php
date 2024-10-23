<?php

namespace Aht\Demo\Controller\Adminhtml\Demo;

use Aht\Demo\Model\BrandFactory;
use Magento\Backend\App\Action;
use Aht\Demo\Model\Brand\ImageUploader;

class Save extends Action
{
    private $postFactory;
    protected $imageUploader;

    public function __construct(
        Action\Context $context,
        BrandFactory $postFactory,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->postFactory = $postFactory;
        $this->imageUploader = $imageUploader;
    }
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['entity_id']) ? $data['entity_id'] : null;
        $post = $this->postFactory->create();

        if ($id) {
            $post->load($id);
        }

        try {
            $logo = $data['logo']['value'] ?? '';
            $logoName = $data['logo'][0]['name'] ?? false;
            if ($logoName) {
                $logo = $this->imageUploader->moveFileFromTmp($logoName);
            }

            $newData = [
                'name' => $data['name'],
                'description' => $data['description'],
                'logo' => $logo,
            ];

            $post->addData($newData);
            $post->save();
            $this->messageManager->addSuccessMessage(__('You saved the post.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }
        return $this->resultRedirectFactory->create()->setPath('aht/demo/index');
    }
}
