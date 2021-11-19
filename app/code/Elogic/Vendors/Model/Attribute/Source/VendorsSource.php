<?php
declare(strict_types=1);

namespace Elogic\Vendors\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Elogic\Vendors\Model\ResourceModel\Collection\VendorsCollectionFactory;
use Elogic\Vendors\Model\ResourceModel\Collection\VendorsCollection;

class VendorsSource extends AbstractSource
{
    /**
     * @var VendorsCollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var array
     */
    protected $options;

    public function __construct(VendorsCollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->options) {
            /** @var VendorsCollection $collection */
            $collection = $this->collectionFactory->create();

            $vendors = $collection->getItems();

            if (!$vendors) {
                return [];
            }

            $options = [];

            foreach ($vendors as $vendor) {
                $options[] = [
                    'value' => $vendor->getData('id'),
                    'logo' => $vendor->getData('logo'),
                    'label' => $vendor->getData('name'),
                    'description' => $vendor->getData('description')
                ];
            }

            $this->options = $options;
        }

        return $this->options;
    }

    /**
     * @param string|null $id
     * @return array|null
     */
    public function getOptionById(?string $id) :?array
    {
        $options = $this->getAllOptions();
        foreach($options as $option) {
            if($option['value'] == $id) {
                return $option;
            }
        }
        return null;
    }
}
