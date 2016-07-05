<?php

namespace BingDigital\Comparegrid\Model\ResourceModel\Comparegrid;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {

    protected $_previewFlag;

    public function _construct()
    {
        $this->_init('BingDigital\Comparegrid\Model\Comparegrid', 'BingDigital\Comparegrid\Model\ResourceModel\Comparegrid');
    }

}