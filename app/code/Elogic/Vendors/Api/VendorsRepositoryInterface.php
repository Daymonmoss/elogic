<?php
declare(strict_types=1);

namespace Elogic\Vendors\Api;

use Elogic\Vendors\Model\ResourceModel\VendorsResourceModel;
use Elogic\Vendors\Api\Data\VendorsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NotFoundException;

interface VendorsRepositoryInterface
{
    /**
     * @param string|null $id
     * @return VendorsInterface
     * @throws NotFoundException
     */
    public function getById(?string $id) :VendorsInterface ;

    /**
     * @param VendorsInterface $model
     * @return VendorsResourceModel
     */
    public function save(VendorsInterface $model) :VendorsResourceModel;

    /**
     * @param VendorsInterface $model
     * @return true
     * @throws CouldNotDeleteException
     */
    public function delete(VendorsInterface $model) :bool;

    /**
     * @param string $id
     * @return true
     * @throws CouldNotDeleteException
     */
    public function deleteById(string $id) :bool;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria) :SearchResultsInterface;
}
