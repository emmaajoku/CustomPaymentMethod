define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'slotpaystack',
                component: 'Slot_Payment/js/view/payment/method-renderer/slotpaystack-method'
            }
        );
        return Component.extend({});
    }
);