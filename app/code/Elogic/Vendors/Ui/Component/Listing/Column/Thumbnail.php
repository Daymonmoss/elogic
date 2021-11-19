<?php
declare(strict_types=1);

namespace Elogic\Vendors\Ui\Component\Listing\Column;

use Magento\Catalog\Helper\Image;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;


class Thumbnail extends Column
{
    const ALT_FIELD = 'title';

    /**
     * @var Image
     */
    private $imageHelper;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Image $imageHelper
     * @param UrlInterface $urlBuilder
     * @param StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Image $imageHelper,
        UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    )
    {
        $this->storeManager = $storeManager;
        $this->imageHelper = $imageHelper;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     * @throws NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource) :array
    {
        if(isset($dataSource['data']['items']))
        {
            $fieldName = $this->getData('name');

            foreach($dataSource['data']['items'] as &$item)
            {
                $baseUrl = $this ->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_WEB );

                $url = $this->imageHelper->getDefaultPlaceholderUrl('image');

                if($item[$fieldName] != '')
                {
                    $url = $baseUrl . $item[$fieldName];
                }

                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_alt'] = $item['name'] . " - " . $item['description'];
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl('vendors/index/edit',['id' => $item['id']]);
                $item[$fieldName. '_orig_src'] = $url;
            }
        }

        return $dataSource;
    }
}
