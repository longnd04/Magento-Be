<?php

namespace Aht\Demo\Model\Brand;

use Aht\Demo\Model\Brand\FileInfo;
use Magento\Framework\App\ObjectManager;


class ImageUploader
{
    protected $coreFileStorageDatabase;
    protected $mediaDirectory;
    private $uploaderFactory;
    protected $storeManager;
    protected $logger;
    protected $baseTmpPath;
    protected $basePath;
    protected $allowedExtensions;
    private $fileInfo;
    public function __construct(
        \Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDatabase,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Psr\Log\LoggerInterface $logger,
        FileInfo $fileInfo,
        $baseTmpPath = 'aht/demo',
        $basePath = 'aht/demo',
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png']
    ) {
        $this->coreFileStorageDatabase = $coreFileStorageDatabase;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->uploaderFactory = $uploaderFactory;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->baseTmpPath = $baseTmpPath;
        $this->fileInfo = $fileInfo;
        $this->basePath = $basePath;
        $this->allowedExtensions = $allowedExtensions;
    }

    public function setBaseTmpPath($baseTmpPath)
    {
        $this->baseTmpPath = $baseTmpPath;
    }

    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }
    public function setAllowedExtensions($allowedExtensions)
    {
        $this->allowedExtensions = $allowedExtensions;
    }

    public function getBaseTmpPath()
    {
        return $this->baseTmpPath;
    }
    public function getBasePath()
    {
        return $this->basePath;
    }
    public function getAllowedExtensions()
    {
        return $this->allowedExtensions;
    }
    public function getFilePath($path, $imageName)
    {
        return rtrim($path, '/') . '/' . ltrim($imageName, '/');
    }

    public function moveFileFromTmp($imageName)
    {
        $baseTmpPath = $this->getBaseTmpPath();
        $basePath = $this->getBasePath();

        $baseImagePath = $this->getFilePath($basePath, $imageName);
        $baseTmpImagePath = $this->getFilePath($baseTmpPath, $imageName);

        try {
            if ($this->fileInfo->isExist($imageName, $this->baseTmpPath)) {
                $this->coreFileStorageDatabase->copyFile(
                    $baseTmpImagePath,
                    $baseImagePath
                );
                $this->mediaDirectory->renameFile(
                    $baseTmpImagePath,
                    $baseImagePath
                );
            }
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Something went wrong while saving the file(s).')
            );
        }

        return $imageName;
    }
    private function getFileInfo()
    {
        if ($this->fileInfo === null) {
            $this->fileInfo = ObjectManager::getInstance()->get(FileInfo::class);
        }
        return $this->fileInfo;
    }
    public function saveFileToTmpDir($fileId)
    {
        $baseTmpPath = $this->getBaseTmpPath();
        $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
        $uploader->setAllowedExtensions($this->getAllowedExtensions());
        $uploader->setAllowRenameFiles(true);

        $result = $uploader->save($this->mediaDirectory->getAbsolutePath($baseTmpPath));

        if (!$result) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('File can not be saved to the destination folder.')
            );
        }

        $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
        $result['url'] = $this->storeManager
            ->getStore()
            ->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . $this->getFilePath($baseTmpPath, $result['file']);
        $result['name'] = $result['file'];

        if (isset($result['file'])) {
            try {
                $relativePath = rtrim($baseTmpPath, '/') . '/' . ltrim($result['file'], '/');
                $this->coreFileStorageDatabase->saveFile($relativePath);
            } catch (\Exception $e) {
                $this->logger->critical($e);
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while saving the file(s).')
                );
            }
        }

        return $result;
    }

    public function deleteImage($imageName, $type = 'dir')
    {
        $basePath = $this->getBasePath();
        if ($type == 'tmp') {
            $basePath = $this->getBaseTmpPath();
        }

        if ($this->fileInfo->isExist($imageName, $basePath)) {
            $this->fileInfo->deleteFile($imageName, $basePath);
        }
    }
}
