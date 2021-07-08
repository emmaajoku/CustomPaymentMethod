<?php
/**
 * Copyright © 1.0.0 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Slot\Payment\Model\Payment;

class Slotpaystack extends \Magento\Payment\Model\Method\AbstractMethod
{

    protected $_code = "slotpaystack";
    protected $_isOffline = true;

    public function isAvailable(
        \Magento\Quote\Api\Data\CartInterface $quote = null
    ) {
        return parent::isAvailable($quote);
    }
}

