<?php
declare(strict_types=1);

namespace Elogic\Vendors\Block\Adminhtml\Index\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

use Elogic\Vendors\Api\VendorsRepositoryInterface;

class GenericButton
{
    /** @var Context */
    protected $context;

    /** @var VendorsRepositoryInterface */
    protected $repository;

    public function __construct(
        Context $context,
        VendorsRepositoryInterface $repository
    ) {
        $this->context      = $context;
        $this->repository   = $repository;
    }

    /**
     * Return Vendor ID
     *
     * @return int|null
     */
    public function getStatusId(): ?int
    {
        try {
            return $this->repository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = []) :string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
