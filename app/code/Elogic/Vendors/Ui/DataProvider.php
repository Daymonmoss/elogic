<?php
namespace Elogic\Vendors\Ui;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Elogic\Vendors\Api\Data\VendorsInterface;
use Elogic\Vendors\Model\ResourceModel\Collection\VendorsCollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    private $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param VendorsCollectionFactory $vendorsCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        VendorsCollectionFactory $vendorsCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $vendorsCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData() :array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $vendors = $this->collection->getItems();

        if (empty($vendors)) {
            $this->loadedData = [];
        }

        /** @var $vendor VendorsInterface */
        foreach ($vendors as $vendor) {
            $vendorData = $vendor->getData();
            unset($vendorData['logo']);
            $vendorData['logo'][0]['name'] = $vendor->getName();
            $vendorData['logo'][0]['url'] = $vendor->getLogo();
            $vendorData['logo'][0]['description'] = $vendor->getDescription();
            $vendorData['logo'][0]['type'] = 'image';
            $vendorData['logo'][0]['size'] = filesize('.' . $vendor->getLogo());
            $this->loadedData[$vendor->getId()]['vendor'] = $vendorData;
        }

        return $this->loadedData;
    }
}
