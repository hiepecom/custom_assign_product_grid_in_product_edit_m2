<?php
namespace BingDigital\Comparegrid\Block\Adminhtml\Product\Edit\Tab;

use BingDigital\Comparegrid\Model\ResourceModel\Comparegrid\CollectionFactory;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Catalog\Model\Product;

class Compare extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $productCollectionFactory;

    protected $comparegridCollectionFactory;

    protected $registry = null;

    protected $_objectManager = null;

    protected $request;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        CollectionFactory $comparegridCollectionFactory,
        array $data = []
    )
    {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->_objectManager = $objectManager;
        $this->registry = $registry;
        $this->request = $request;
        $this->comparegridCollectionFactory = $comparegridCollectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('compared_productsGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->getProduct() && $this->getProduct()->getId()) {
            $this->setDefaultFilter(['in_products' => 1]);
        }
    }

    public function getProduct()
    {
        return  $this->registry->registry('current_product');
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_product') {
            $productIds = $this->_getSelectedProducts();

            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin' => $productIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    protected function _prepareCollection()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSelect('sku');
        $collection->addAttributeToSelect('price');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_product',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_product',
                'align' => 'center',
                'index' => 'entity_id',
                'values' => $this->_getSelectedProducts(),
            ]
        );

        $this->addColumn(
            'entity_id',
            [
                'header' => __('Product ID'),
                'type' => 'number',
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );

        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'sku',
            [
                'header' => __('Sku'),
                'index' => 'sku',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'currency',
                'index' => 'price',
                'width' => '50px',
            ]
        );

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->_getData(
            'grid_url'
        ) ? $this->_getData(
            'grid_url'
        ) : $this->getUrl(
            'comparegrid/*/comparegrid',
            ['_current' => true]
        );
    }

    public function getRowUrl($row)
    {
        return '';
    }

    public function getAssignProductCompare(){
      $paramProductId = 0;
        if($this->request->getParam('id')){
            $paramProductId = $this->request->getParam('id');
        }
        $compareCollection = $this->comparegridCollectionFactory->create()
            ->addFieldToFilter('product_id', array('eq' => $paramProductId))->getFirstItem();
        $arrAssignProductId = $compareCollection->getAssignProductId();
        $arrAssignProductId = explode(',',$arrAssignProductId);
        return $arrAssignProductId;
    }

    protected function _getSelectedProducts()
    {
        $products = $this->getAssignProductCompare();
        return $products;
    }

    public function getSelectedProducts()
    {
        $products = $this->getAssignProductCompare();
        return $products;
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return true;
    }

}
