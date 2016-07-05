<?php

namespace BingDigital\Comparegrid\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Backend\App\Action;
use BingDigital\Comparegrid\Model\ResourceModel\Comparegrid\CollectionFactory;

class Productsaveafter implements ObserverInterface
{
    protected $_request;
    protected $collectionFactory;
    protected $_jsHelper;
    protected $comparegrid;

    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        CollectionFactory $collectionFactory,
        \BingDigital\Comparegrid\Model\Comparegrid $comparegrid
    )
    {
        $this->_request = $context->getRequest();
        $this->collectionFactory = $collectionFactory;
        $this->comparegrid = $comparegrid;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $_productId = $observer->getProduct()->getId();
        $params = $this->_request->getParams();
        if($params){
            $string_compare_product_id = str_replace('&',',',$params['compare_product_id']);
            $compareCollection = $this->collectionFactory->create()
                ->addFieldToFilter('product_id', array('eq' => $_productId))->getFirstItem();

            if($compareCollection->getId()){
                $model = $this->comparegrid->load($compareCollection->getId());
            } else {
                $model = $this->comparegrid;
            }
                    $model->setData('product_id', $_productId);
                    $model->setData('assign_product_id', $string_compare_product_id);
            try{
                $model->save();
            }catch (\Magento\Framework\Exception\LocalizedException $e)
            {
                $e->getMessage();
            }


        }
    }
}