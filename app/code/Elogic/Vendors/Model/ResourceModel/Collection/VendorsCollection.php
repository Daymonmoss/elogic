<?php
declare(strict_types=1);

namespace Elogic\Vendors\Model\ResourceModel\Collection;

use Elogic\Vendors\Api\Data\VendorsInterface;
use Elogic\Vendors\Model\ResourceModel\VendorsResourceModel;
use Elogic\Vendors\Model\VendorsModel;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Psr\Log\LoggerInterface;

class VendorsCollection extends AbstractCollection
{
    protected $_idFieldName = VendorsInterface::FIELD_NAME_ID;

    protected function _construct() :void
    {
        $this->_init(
            VendorsModel::class,
            VendorsResourceModel::class
        );
    }

    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct
    (
        ResourceConnection $resourceConnection,
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->resourceConnection = $resourceConnection;
    }

    public function delete() :void
    {
        $ids = implode(",", $this->getAllIds());
        $connection = $this->resourceConnection->getConnection();
        $table = $connection->getTableName(VendorsInterface::TABLE_NAME);
        $idField = VendorsInterface::FIELD_NAME_ID;
        $query = "DELETE FROM `" . $table . "` WHERE $idField IN ($ids)";
        $connection->query($query);
    }
}
