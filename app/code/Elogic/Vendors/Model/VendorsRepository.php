<?php
declare(strict_types=1);

namespace Elogic\Vendors\Model;

use Elogic\Vendors\Api\Data\VendorsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Elogic\Vendors\Api\VendorsRepositoryInterface;
use Elogic\Vendors\Model\ResourceModel\VendorsResourceModel;
use Elogic\Vendors\Model\ResourceModel\Collection\VendorsCollectionFactory;

class VendorsRepository implements VendorsRepositoryInterface
{
    /**
     * @var VendorsModelFactory
     */
    private $vendorsModelFactory;

    /**
     * @var VendorsResourceModel
     */
    private $vendorsResourceModel;

    /**
     * @var VendorsCollectionFactory
     */
    private $vendorsCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * Repository constructor.
     *
     * @param VendorsModelFactory $vendorsModelFactory
     * @param VendorsResourceModel $vendorsResourceModel
     * @param VendorsCollectionFactory $vendorsCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        VendorsModelFactory $vendorsModelFactory,
        VendorsResourceModel $vendorsResourceModel,
        VendorsCollectionFactory $vendorsCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->vendorsModelFactory = $vendorsModelFactory;
        $this->vendorsResourceModel = $vendorsResourceModel;
        $this->vendorsCollectionFactory = $vendorsCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param VendorsInterface|VendorsModel $model
     * @return VendorsResourceModel
     * @throws CouldNotSaveException
     */
    public function save(VendorsModel $model) :VendorsResourceModel
    {
        try {
            return $this->vendorsResourceModel->save($model);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__("Sorry. I cannot save this vendor. =("));
        }
    }

    /**
     * @param VendorsInterface|VendorsModel $model
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(VendorsModel $model) :bool
    {
        try {
            $this->vendorsResourceModel->delete($model);
            return true;
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__("Sorry. I cannot delete this vendor. =("));
        }
    }

    /**
     * @param string $id
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById(string $id) :bool
    {
        try {
            $this->vendorsResourceModel->delete($this->getById($id));

            return true;
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__("Sorry. I cannot delete this vendor. =("));
        }
    }

    /**
     * @param string|null $id
     * @return VendorsModel|VendorsInterface
     * @throws NoSuchEntityException
     */
    public function getById(?string $id) :VendorsModel
    {
        try {
            $model = $this->vendorsModelFactory->create();
            $this->vendorsResourceModel->load($model, $id);

            return $model;
        } catch (\Exception $e) {
            throw new NoSuchEntityException(__("Sorry. No vendor with this id"));
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria) :SearchResultsInterface
    {
        $collection = $this->vendorsCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->searchResultsFactory->create();

        $searchResult->setSearchCriteria($searchCriteria)
            ->setTotalCount($collection->getSize())
            ->setItems($collection->getItems());

        return $searchResult;
    }
}
