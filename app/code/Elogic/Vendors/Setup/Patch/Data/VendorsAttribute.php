<?php
declare(strict_types=1);

namespace Elogic\Vendors\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Elogic\Vendors\Model\Attribute\Backend\VendorsBackend;
use Elogic\Vendors\Model\Attribute\Frontend\VendorsFrontend;
use Elogic\Vendors\Model\Attribute\Source\VendorsSource;

class VendorsAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @return VendorsAttribute|void
     * @throws LocalizedException
     * @throws \Zend_Validate_Exception
     */
    public function apply() :void
    {
        $this->moduleDataSetup->startSetup();
        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->addAttribute(Product::ENTITY, 'elogic_vendor', [
            'type' => 'int',
            'label' => 'Elogic Product Vendor',
            'input' => 'select',
            'frontend' => VendorsFrontend::class,
            'backend' => VendorsBackend::class,
            'source' => VendorsSource::class,
            'required' => false,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => true,
            'user_defined' => true,
            'searchable' => true,
            'filterable' => true,
            'filterable_in_search' => true,
            'is_filterable_in_grid' => true,
            'comparable' => true,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'is_html_alowed_on_front' => true,
            'unique' => true
        ]);

        $eavSetup->addAttributeToGroup(
            Product::ENTITY,
            'Default',
            'Product Details',
            'elogic_vendor',
            19
        );

        $this->moduleDataSetup->endSetup();
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases(): array
    {
        return [];
    }
}
