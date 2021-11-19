<?php
declare(strict_types=1);

namespace Elogic\Vendors\Controller\Adminhtml\Index;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Index extends AbstractController
{
    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute() :?ResultInterface
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Vendors List'));

        return $resultPage;
    }

    /**
     * @return bool
     */
    public function isAllowed() :bool
    {
        return $this->_authorization->isAllowed('Elogic_Vendors::table');
    }

}
