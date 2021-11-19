<?php
declare(strict_types=1);

namespace Elogic\Vendors\Controller\Adminhtml\Index;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Elogic\Vendors\Api\Data\VendorsInterface;


class Save extends AbstractController implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData() :array
    {
        return [
            'label' => __('Save Vendor'),
            'class' => 'primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'elogic_vendors_form.elogic_vendors_form',
                                'actionName' => 'save',
                                'params' => [
                                    true,
                                    [
                                        'back' => 'continue'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'sort_order' => 30
        ];
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute() :ResultInterface
    {
        $redirect = $this->resultFactory->create('redirect');

        try {
            $data = $this->getRequest()->getPostValue();

            /** @var VendorsInterface $model */
            $model = $this->vendorsModelFactory->create();

            $postData = !empty($data['vendor']) ? $data['vendor'] : [];

            if (!empty($postData['id'])) {
                try {
                    $model = $this->vendorsRepository->getById($postData['id']);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This vendor no longer exists.'));
                    return $redirect->setPath(self::DEFAULT_ACTION_PATH);
                }
            }

            $model->setName($postData['name'])
                  ->setDescription($postData['description'])
                  ->setLogo($postData['logo'][0]['url']);

            $this->vendorsRepository->save($model);

            $newVendorId = $model->getId();


            $this->messageManager->addSuccessMessage(__("Now you have a new vendor! Successfully saved to the database!"));
            $redirect->setPath(self::DEFAULT_ACTION_PATH . '/index', ['id' => $newVendorId]);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("Sorry, was unable to save a vendor form. =("));
            $redirect->setPath(self::DEFAULT_ACTION_PATH . '/index');
        }

        return $redirect;
    }
}
