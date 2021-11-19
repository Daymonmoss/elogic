<?php
declare(strict_types=1);

namespace Elogic\Vendors\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Elogic\Vendors\Model\VendorsModel;



/**
 * Vendor grid inline edit controller
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InlineEdit extends AbstractController
{
    /**
     * Process the request
     *
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute() :?ResultInterface
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $vendorId) {
                    $vendor = $this->vendorsRepository->getById((string)$vendorId);
                    try {
                        $vendor->setData(array_merge($vendor->getData(), $postItems[$vendorId]));
                        $this->vendorsRepository->save($vendor);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithVendorId(
                            $vendor,
                            (string)__($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add vendor title to error message
     *
     * @param VendorsModel $vendor
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithVendorId(VendorsModel $vendor, string $errorText) :string
    {
        return '[Vendor ID: ' . $vendor->getId() . '] ' . $errorText;
    }
}
