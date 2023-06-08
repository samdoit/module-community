# Samdoit Community Extension by [Samdoit](http://www.samdoit.com/product/magento.html)

[![Total Downloads](http://poser.pugx.org/samdoit/module-community/downloads)](https://packagist.org/packages/samdoit/module-community) 
[![Latest Stable Version](http://poser.pugx.org/samdoit/module-community/v/stable)](https://packagist.org/packages/samdoit/module-community) 

## Requirements
  * Magento Community Edition 2.1.x-2.4.x or Magento Enterprise Edition 2.1.x-2.4.x

## Installation Method 1 - Installing via composer
  * Open command line
  * Using command "cd" navigate to your magento2 root directory
  * Run the commands:
  
```
composer require samdoit/module-community
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

## Installation Method 2 - Installing via FTP using archive
  * Download [ZIP Archive](https://github.com/samdoit/module-community/archive/main.zip)
  * Extract files
  * In your Magento 2 root directory create folder app/code/Samdoit/Community
  * Copy files and folders from archive to that folder
  * In command line, using "cd", navigate to your Magento 2 root directory
  * Run the commands:
```
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

## Support
If you have any issues, please [contact us](http://www.samdoit.com/contact)
then if you still need help, open a bug report in GitHub's
[issue tracker](https://github.com/samdoit/module-community/issues).

## License
The code is licensed under [EULA](http://www.samdoit.com/end-user-license-agreement).

## [Magento Extensions](http://www.samdoit.com/product/magento.html) by Samdoit
