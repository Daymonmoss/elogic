<?php
declare(strict_types=1);

namespace Elogic\Vendors\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Elogic\Vendors\Api\Data\VendorsInterface;
use Elogic\Vendors\Model\ResourceModel\VendorsResourceModel;


class VendorsModel extends AbstractExtensibleModel implements VendorsInterface
{

    protected function _construct() :void
    {
        $this->_init(VendorsResourceModel::class);
    }

    /**
     * @return string
     */
    public function getId() :?string
    {
      return $this->getData(VendorsInterface::FIELD_NAME_ID);
    }

    /**
     * @return string|null
     */
    public function getLogo() :?string
    {
        return $this->getData(VendorsInterface::FIELD_NAME_LOGO);
    }

    /**
     * @param string|null $logo
     * @return VendorsInterface
     */
    public function setLogo(?string $logo) :VendorsInterface
    {
        return $this->setData(VendorsInterface::FIELD_NAME_LOGO, $logo);
    }

    /**
     * @return string|null
     */
    public function getName() :?string
    {
        return $this->getData(VendorsInterface::FIELD_NAME_NAME);
    }

    /**
     * @param string|null $name
     * @return VendorsModel
     */
    public function setName(?string $name) :VendorsInterface
    {
        return $this->setData(VendorsInterface::FIELD_NAME_NAME, $name);
    }

    /**
     * @return string|null
     */
    public function getDescription() :?string
    {
        return $this->getData(VendorsInterface::FIELD_NAME_DESCRIPTION);
    }

    /**
     * @param string|null $description
     * @return VendorsInterface
     */
    public function setDescription(?string $description) :VendorsInterface
    {
        return $this->setData(VendorsInterface::FIELD_NAME_DESCRIPTION, $description);
    }


    /**
     * @return string
     */
    public function getDateAdded() :string
    {
        return $this->getData(VendorsInterface::FIELD_NAME_DATE_ADDED);
    }
}
