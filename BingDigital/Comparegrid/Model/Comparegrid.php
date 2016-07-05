<?php

namespace BingDigital\Comparegrid\Model;

class Comparegrid extends \Magento\Framework\Model\AbstractModel
{

    protected function _construct()
    {
        $this->_init('BingDigital\Comparegrid\Model\ResourceModel\Comparegrid');
    }

}