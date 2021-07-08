<?php
/**
 * Copyright © 1.0.0 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Slot\Payment\Model;
use Exception;
use Magento\Checkout\Model\Session;
use Magento\Framework\Event\Manager;
use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Payment\Model\MethodInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Order;
use Pstk\Paystack\Model\Payment\Paystack as PaystackModel;
use Yabacon\Paystack as PaystackLib;
use Magento\Sales\Model\Order\Email\Sender\OrderSender;

class VerifypaymentManagement implements \Slot\Payment\Api\VerifypaymentManagementInterface
{
    protected MethodInterface $paystackPaymentInstance;

    protected PaystackLib $paystackLib;

    protected OrderInterface $orderInterface;
    protected Session $checkoutSession;
    protected OrderSender $orderSender;
    protected Order $orderObj;
    /**
     * @var Manager
     */
    private Manager $eventManager;

    public function __construct(
        PaymentHelper $paymentHelper,
        Manager $eventManager,
        Session $checkoutSession,
        OrderSender $orderSender,
        Order $orderObj
    ) {
        $this->paystackPaymentInstance = $paymentHelper->getMethodInstance(PaystackModel::CODE);
        $this->orderObj = $orderObj;
        $this->checkoutSession = $checkoutSession;

        $secretKey = $this->paystackPaymentInstance->getConfigData('live_secret_key');
        if ($this->paystackPaymentInstance->getConfigData('test_mode')) {
            $secretKey = $this->paystackPaymentInstance->getConfigData('test_secret_key');
        }
        $this->orderSender = $orderSender;
        $this->paystackLib = new PaystackLib($secretKey);
    }

    /**
     * {@inheritdoc}
     */
    public function postVerifypayment($param)
    {
        if (!preg_match('/_/', $param)) {
            $order = $this->getOrder($param);
            return json_encode([
                'order_number' =>  $order->getIncrementId(),
            ]);
        }

        // we are appending quoteid
        $ref = explode('_', $param);
        $reference = $ref[0];
        $quoteId = $ref[1];
        $orderId = $ref[2];
        $order = $this->getOrder($orderId);

        try {
            $transaction_details = $this->paystackLib->transaction->verify([
                'reference' => $reference
            ]);

            if ($order && $order->getPayment()->getMethod() == "slotpaystack" && $order->getStatus() == "pending_paystarck" && $transaction_details->status === true &&
                $transaction_details->data->status === 'success' &&
                $order->getQuoteId() === $quoteId) {
                // sets the status to processing since payment has been received
                $order->setState(Order::STATE_PROCESSING)
                    ->addStatusToHistory("verified_paystarck", __("Paystack Payment Verified and Order is being processed"), true)
                    ->setCanSendNewEmailFlag(true)
                    ->setCustomerNoteNotify(true);
                $order->save();
                $this->orderSender->send($order, true);
            } else {
                $order->cancel()->save();
                return false;
            }
        } catch (Exception $e) {
            $order->cancel()->save();
            return json_encode([
                'status'=>0,
                'message'=>$e->getMessage()
            ]);
        }

    }


    /**
     * Loads the order based on the last real order
     * @param $orderId
     * @return bool|Order
     */
    private function getOrder($orderId)
    {
        if ($orderId) {
            // load and return the order instance
            return  $this->orderObj->load($orderId);
            //return $this->orderInterface->loadByIncrementId($orderId);
        }
        return false;
    }
}

