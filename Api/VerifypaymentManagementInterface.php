<?php
/**
 * Copyright © 1.0.0 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Slot\Payment\Api;

interface VerifypaymentManagementInterface
{

    /**
     * POST for verifypayment api
     * @param string $param
     * @return string
     */
    public function postVerifypayment($param);
}

