<?php
declare(strict_types=1);

namespace Elogic\Vendors\Controller\Adminhtml\Index;

use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Elogic\Vendors\Model\VendorsModelFactory;


class Edit extends AbstractController implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Edit Vendor;
     * @return Page|Redirect|ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @var VendorsModelFactory $vendorsModelFactory
     */
    public function execute() :ResultInterface
    {
        $id = $this->getRequest()->getParam('id');
        $name = $this->getRequest()->getParam('name');
        $description = $this->getRequest()->getParam('description');
        $logo = $this->getRequest()->getParam('logo');

        $vendor = $this->vendorsRepository->getById($id);

        if ($id) {
            if (!$vendor) {
                $this->messageManager->addErrorMessage(__('This page no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/index');
            }
            $vendor->setName($name)->setDescription($description)->setLogo($logo);
        }

        $resultPage = $this->resultFactory->create('page');
        /** @var Page $resultPage */
        $resultPage->getConfig()->getTitle()
            ->prepend($id !== null ? 'Edit '. $name : __('New Vendor'));

        return $resultPage;
    }
}
