<?php
declare(strict_types=1);

namespace Elogic\Vendors\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\DataObject;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\Result\JsonFactory;
use Elogic\Vendors\Api\VendorsRepositoryInterface;
use Elogic\Vendors\Model\VendorsModelFactory;
use Elogic\Vendors\Model\ResourceModel\Collection\VendorsCollectionFactory;
use Elogic\Vendors\Model\ResourceModel\VendorsResourceModel;

abstract class AbstractController extends Action
{
    const DEFAULT_ACTION_PATH = 'vendors/index/';
    /**
     * @var VendorsModelFactory
     */
    protected $vendorsModelFactory;

    /**
     * @var VendorsResourceModel
     */
    protected $vendorsResourceModel;

    /**
     * @var VendorsCollectionFactory
     */
    protected $vendorsCollectionFactory;

    /**
     * @var VendorsRepositoryInterface
     */
    protected $vendorsRepository;

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * Image uploader
     *
     * @var ImageUploader
     */
    protected $imageUploader;

    public function __construct(
        Context $context,
        Filter $filter,
        JsonFactory $jsonFactory,
        ImageUploader $imageUploader,
        VendorsCollectionFactory $vendorsCollectionFactory,
        VendorsModelFactory $vendorsModelFactory,
        VendorsRepositoryInterface $vendorsRepository,
        VendorsResourceModel $vendorsResourceModel
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->jsonFactory = $jsonFactory;
        $this->imageUploader = $imageUploader;
        $this->vendorsCollectionFactory = $vendorsCollectionFactory;
        $this->vendorsModelFactory = $vendorsModelFactory;
        $this->vendorsRepository = $vendorsRepository;
        $this->vendorsResourceModel = $vendorsResourceModel;
    }

    /**
     * @return DataObject[]
     */
    public function getAllVendors()
    {
        $collection = $this->vendorsCollectionFactory->create();
        return $collection->getItems();
    }
}
