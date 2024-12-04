# Magento 2 Customer Import from CLI by Mdbhojwani


## Table of contents

- [Summary](#summary)
- [Installation](#installation)
- [Specifications](#specifications)
- [License](#license)


## Summary

Module is use to imports the Customer data from Commandline. 
File Format Accept: CSV or JSON

## Installation

### Composer
 - Run the command on CLI `composer require mdbhojwani/magento2-customerimport`
 - Enable module `php bin/magento module:enable Mdbhojwani_CustomerImport` 
 - Setup Upgrade `php bin/magento setup:upgrade`
 - Compile `php bin/magento setup:di:compile`
 - Deploy Static Content `php bin/magento setup:static-content:deploy -f`
 - Flush the cache by running `php bin/magento cache:flush`

### Manual
 - Extract code here `app/code/Mdbhojwani/CustomerImport`
 - Enable module `php bin/magento module:enable Mdbhojwani_CustomerImport` 
 - Setup Upgrade `php bin/magento setup:upgrade`
 - Compile `php bin/magento setup:di:compile`
 - Deploy Static Content `php bin/magento setup:static-content:deploy -f`
 - Flush the cache by running `php bin/magento cache:flush`


## Specifications

 - Console Command
   
   `php bin/magento customer:import <profile-name> <source>`

 - Example Command
    JSON : `php bin/magento customer:import sample-json sample.json`
    CSV  : `php bin/magento customer:import sample-csv sample.csv`

 - we also need run re-index the 'customer_grid' indexer, once customer import command execution completed, 
    `php bin/magento indexer:reindex customer_grid`


## License

[Open Software License ("OSL") v. 3.0](https://opensource.org/license/osl-3-0-php)

