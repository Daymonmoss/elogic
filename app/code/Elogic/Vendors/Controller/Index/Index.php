<?php
declare(strict_types=1);

namespace Elogic\Vendors\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;


class Index extends Action
{
    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute() :?ResultInterface
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
