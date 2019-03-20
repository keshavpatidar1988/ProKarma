Synopsis

This module is Design for Magento 2.2.X and later versions.

Installation Step

1. Create directory structure if not present 

magento_installation_root/app/code/

2. Upload all the files inside ProKarma Folder and follow below CLI commands to install the module
/ProKarma/MyProducts/etc/module.xml
/ProKarma/MyProducts/i18n/en_US.csv

/ProKarma/MyProducts/Block/Customer/MyProducts.php
/ProKarma/MyProducts/Controller/Customer/Index.php
/ProKarma/MyProducts/etc/adminhtml/system.xml
/ProKarma/MyProducts/etc/frontend/events.xml
/ProKarma/MyProducts/etc/frontend/routes.xml
/ProKarma/MyProducts/etc/acl.xml
/ProKarma/MyProducts/etc/config.xml
/ProKarma/MyProducts/Helper/Customer/MyProducts.php
/ProKarma/MyProducts/Observer/CartAddObserver.php
/ProKarma/MyProducts/view/frontend/layout/customer_account.xml
/ProKarma/MyProducts/view/frontend/layout/myproducts_customer_index.xml
/ProKarma/MyProducts/view/frontend/templates/myproducts.phtml
/ProKarma/MyProducts/composer.json
/ProKarma/MyProducts/README.md
/ProKarma/MyProducts/registration.php

*****Installation using composer 

*****composer require prokarma/module-my-products dev-develop (for this git repo need to add into magento root composer.json file)

Below commands need to run to make sure module installed properly: 

php bin/magento module:enable ProKarma_MyProducts

php bin/magento cache:clean

php bin/magento cache:flush

php bin/magento setup:di:compile

php bin/magento setup:static-content:deploy -f (-f is force full cleanup)





