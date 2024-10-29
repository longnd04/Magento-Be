<?php

namespace Aht\Demo\Controller\Adminhtml\Demo;

use Aht\Demo\Api\BrandRepositoryInterface;
use Magento\Backend\App\Action;
use Aht\Demo\Model\Brand\ImageUploader;
use Aht\Demo\Model\BrandFactory;

class Save extends Action
{
    private $postFactory;
    protected $imageUploader;
    protected $brandRepository;
    protected $brandFactory;
    public function __construct(
        Action\Context $context,
        BrandRepositoryInterface $brandRepository,
        BrandFactory $brandFactory,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->brandRepository = $brandRepository;
        $this->imageUploader = $imageUploader;
        $this->brandFactory = $brandFactory;
    }
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['entity_id']) ? $data['entity_id'] : null;

        $post = $this->brandFactory->create();

        if ($id) {
            $post->load($id);
        }
        try {
            $logo = $data['logo']['value'] ?? '';
            $logoName = $data['logo'][0]['name'] ?? false;
            if ($logoName) {
                $logo = $this->imageUploader->moveFileFromTmp($logoName);
            }

            $post->setName($data['name']);
            $post->setDescription($data['description']);
            $post->setLogo($logo);
            $this->brandRepository->save($post);
            $this->messageManager->addSuccessMessage(__('You saved the brand.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        return $this->resultRedirectFactory->create()->setPath('aht/demo/index');
    }
}
