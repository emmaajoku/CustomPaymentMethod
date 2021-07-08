# Mage2 Module Slot Payment

    ``slot/module-payment``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Payment Method

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Slot`
 - Enable the module by running `php bin/magento module:enable Slot_Payment`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require slot/module-payment`
 - enable the module by running `php bin/magento module:enable Slot_Payment`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration

 - slotpaystack - payment/slotpaystack/*


## Specifications

 - API Endpoint
	- POST - Slot\Payment\Api\VerifypaymentManagementInterface > Slot\Payment\Model\VerifypaymentManagement

 - Observer
	- sales_order_place_after > Slot\Payment\Observer\Sales\OrderPlaceAfter

 - Payment Method
	- slotpaystack


## Attributes



