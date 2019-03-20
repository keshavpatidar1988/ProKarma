Synopsis

This module is Design for Magento 2.2.X to extend the Order Summary section at checkout and add total items qty to user

Installation Step

1. Create directory structure if not present 

magento_installation_root/app/code/

2. Upload all the files inside ProKarma Folder and follow below CLI commands to install the module
/ProKarma/TotalItemsQty/etc/module.xml
/ProKarma/TotalItemsQty/i18n/en_US.csv
/ProKarma/TotalItemsQty/view/frontend/layout/checkout_index_index.xml
/ProKarma/TotalItemsQty/view/frontend/web/js/view/summary/itemsqtytotal.js
/ProKarma/TotalItemsQty/view/frontend/web/template/summary/itemsqtytotal.html
/ProKarma/TotalItemsQty/composer.json
/ProKarma/TotalItemsQty/README.md
/ProKarma/TotalItemsQty/registration.php

*****Installation using composer 

*****composer require prokarma/module-total-items-qty dev-develop (for this git repo need to add into magento root composer.json file)

Below commands need to run to make sure module installed properly: 

php bin/magento module:enable ProKarma_TotalItemsQty

php bin/magento cache:clean

php bin/magento cache:flush

php bin/magento setup:di:compile

php bin/magento setup:static-content:deploy -f (-f is force ful cleanup)

