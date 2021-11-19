<?php
declare(strict_types=1);

namespace Elogic\Vendors\Model\ResourceModel;

use Elogic\Vendors\Api\Data\VendorsInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class VendorsResourceModel extends AbstractDb
{
    protected function _construct() :void
    {
        $this->_init(
            VendorsInterface::TABLE_NAME,
            VendorsInterface::FIELD_NAME_ID
        );
    }
}
