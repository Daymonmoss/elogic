<?php
declare(strict_types=1);

namespace Elogic\Vendors\Controller\Adminhtml\Index;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Elogic\Vendors\Model\VendorsModelFactory;

class Delete extends AbstractController implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData() :array
    {
        $data = [];
        if ($this->getRequest()->getParam('id', null) !== null) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure this is not honest and reliable vendor?'
                    ) . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }
    /**
     * Url to send delete requests to.
     *
     * @return string
     */
    public function getDeleteUrl() :string
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getRequest()->getParam('id', null)]);
    }

    /**
     * Figure out how to redirect an admin user to this controller with the id/*some_id_number_here*,
     * so that this controller can delete the 'vendor' record by 'id' in the url.
     ** @var VendorsModelFactory $vendorsModelFactory
     * @return ResponseInterface|ResultInterface
     */
    public function execute() :ResultInterface
    {
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        (int)$id = $this->getRequest()->getParam('id');

        if ($id) {
            try {
                $model = $this->vendorsRepository->getById($id);
                $this->vendorsRepository->delete($model);
                $this->messageManager->addSuccessMessage(__("You have deleted the vendor!"));
                return $redirect->setPath(self::DEFAULT_ACTION_PATH . 'index');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__("Was unable to delete this unpopular vendor. =("));
                return $redirect->setPath('*/*/edit' . ['page_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find this vendor to delete.'));
        return $redirect->setPath(self::DEFAULT_ACTION_PATH . 'index');
    }
}

