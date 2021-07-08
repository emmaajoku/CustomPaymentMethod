<?php
/**
 * Copyright © 1.0.0 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Slot\Payment\Observer\Sales;

class OrderPlaceAfter implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        //Your observer code
    }
}

