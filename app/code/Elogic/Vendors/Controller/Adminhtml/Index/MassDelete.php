<?php
declare(strict_types=1);

namespace Elogic\Vendors\Controller\Adminhtml\Index;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class MassDelete extends AbstractController
{
    /**
     * @return ResponseInterface|ResultInterface
     * @throws LocalizedException
     */
    public function execute() :?ResultInterface
    {
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        $collection = $this->filter->getCollection($this->vendorsCollectionFactory->create());
        $collectionSize = $collection->getSize();

        if (!empty($collection)) {
            $collection->delete();
            $this->messageManager->addSuccessMessage(
                __('A total of %1 vendor(s) has been deleted.', $collectionSize)
            );
        } else {
            $this->messageManager->addWarningMessage("Please select vendors to delete");
        }

        return $redirect->setPath(self::DEFAULT_ACTION_PATH . 'index');
    }
}
