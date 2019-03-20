define(
    [
        'Magento_Checkout/js/view/summary/abstract-total'
    ],
    function (Component) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'ProKarma_TotalItemsQty/summary/itemsqtytotal'
            },
            getValue: function() {
                var qty = 0;
                if(window.checkoutConfig.quoteItemData) {
                  var noOfItem =   window.checkoutConfig.quoteItemData.length;
                    for (var i = 0; i < noOfItem; i++) {
                        qty += window.checkoutConfig.quoteItemData[i].qty
                    }
                }
                return qty;
            }
        });
    }
);