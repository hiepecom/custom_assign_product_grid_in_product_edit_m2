<?php

namespace BingDigital\Comparegrid\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;

class CompareGrid extends \Magento\Backend\App\Action
{

    protected $_resultLayoutFactory;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    )
    {
        parent::__construct($context);
        $this->_resultLayoutFactory = $resultLayoutFactory;
    }

    protected function _isAllowed()
    {
        return true;
    }

    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        $resultLayout->getLayout()->getBlock('custom.edit.tab.comparegrid')
            ->setProductsRelated($this->getRequest()->getPost('products_compare', null));
        return $resultLayout;
    }

}
