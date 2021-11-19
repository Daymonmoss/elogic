<?php
declare(strict_types=1);

namespace Elogic\Vendors\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Upload extends AbstractController
{

    /**
     * Upload file controller action.
     *
     * @return ResultInterface
     */
    public function execute() :?ResultInterface
    {
        $imageUploadId = $this->_request->getParam('param_name', 'logo');
        try {
           $this->imageUploader->setBaseTmpPath('elogic/vendors');
            $imageResult = $this->imageUploader->saveFileToTmpDir($imageUploadId);
            $imageResult['url'] = parse_url($imageResult['url'], PHP_URL_PATH);
            $imageResult['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];

        } catch (\Exception $e) {
            $imageResult = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($imageResult);
    }
}
