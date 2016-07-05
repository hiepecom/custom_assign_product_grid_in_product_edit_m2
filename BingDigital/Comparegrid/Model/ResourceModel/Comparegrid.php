<?php

namespace BingDigital\Comparegrid\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Comparegrid extends AbstractDb {

    protected function _construct()
    {
        $this->_init('assign_compare_product', 'id');
    }
}