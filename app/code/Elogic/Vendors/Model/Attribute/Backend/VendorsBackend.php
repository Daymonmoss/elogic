<?php
declare(strict_types=1);

namespace Elogic\Vendors\Model\Attribute\Backend;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\Exception\LocalizedException;

class VendorsBackend extends AbstractBackend
{
    /**
     * Validate
     * @param Product $object
     * @throws LocalizedException
     * @return bool
     */
    public function validate($object) :bool
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());

        if ($value == null && $object->getTypeId() == "simple") {
            throw new LocalizedException(
                __('Elogic Vendor must have some vendor' . "\n")
            );
        }
        return true;
    }
}
