<?php
declare(strict_types=1);

namespace Elogic\Vendors\Model\Attribute\Frontend;

use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend;
use Magento\Eav\Model\Entity\Attribute\Source\BooleanFactory;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json as Serializer;
use Magento\Store\Model\StoreManagerInterface;

class VendorsFrontend extends AbstractFrontend
{
    /**
     * @var Config
     */
    protected $eavConfig;

    public function __construct(
        BooleanFactory             $attrBooleanFactory,
        CacheInterface             $cache = null,
                                   $storeResolver = null,
        array                      $cacheTags = null,
        StoreManagerInterface      $storeManager = null,
        Serializer                 $serializer = null,
        Config                     $eavConfig
    ) {
        parent::__construct($attrBooleanFactory, $cache, $storeResolver, $cacheTags, $storeManager, $serializer);
        $this->eavConfig = $eavConfig;
    }

    /**
     * @param DataObject $object
     * @return array|null
     * @throws LocalizedException
     */
    public function getValue(DataObject $object) :?array
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
        $attributeCode = $this->getAttribute()->getAttributeCode();
        $attributeDetails = $this->eavConfig->getAttribute("catalog_product", $attributeCode);

        $return = $attributeDetails->getSource()->getOptionById($value);
        return $return;
    }
}
