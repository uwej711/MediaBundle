<?php

namespace Symfony\Cmf\Bundle\MediaBundle\Form\DataTransformer;

use Symfony\Cmf\Bundle\MediaBundle\File\UploadFileHelperInterface;
use Symfony\Cmf\Bundle\MediaBundle\FileInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ModelToFileTransformer implements DataTransformerInterface
{
    private $helper;

    /**
     * @param string $class
     */
    public function __construct(UploadFileHelperInterface $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($uploadedFile)
    {
        if (!$uploadedFile instanceof UploadedFile) {
            return $uploadedFile;
        }

        try {
            return $this->helper->handleUploadedFile($uploadedFile);
        } catch(UploadException $e) {
            throw new TransformationFailedException('Uploading file failed with ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function transform($file)
    {
        return $file;
    }
}