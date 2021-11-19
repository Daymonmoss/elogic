<?php
declare(strict_types=1);

namespace Elogic\Vendors\ViewModel;

use Magento\Catalog\Model\ResourceModel\Product as ProductResource;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class VendorView implements ArgumentInterface
{

    /**
     * @var ProductResource
     */

    private $productResource;

    /**
     * @param ProductResource $productResource
     */
    public function __construct(
        ProductResource $productResource
    )
    {
        $this->productResource = $productResource;
    }

    /**
     * @param $product
     * @return array|null
     */
    public function getProductElogicVendor($product) :?array
    {
        $attribute = $this->productResource->getAttribute('elogic_vendor');
        $value = $attribute->getFrontend()->getValue($product);
        return $value;
    }

}
