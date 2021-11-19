<?php
declare(strict_types=1);

namespace Elogic\Vendors\Controller\Adminhtml\Index;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Back extends AbstractController implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData() :array
    {
        return [
            'label' => __('Back'),
            'class' => 'back',
            'on_click' => sprintf("location.href = '%s';", $this->execute()),
            'sort_order' => 10
        ];
    }

    /**
     * @return string
     */
    public function execute() :string
    {
        return $this->getUrl('*/*/');
    }
}
