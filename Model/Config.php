<?php
/**
 * Copyright © Samdoit (support@samdoit.com). All rights reserved.
 * Please visit Samdoit.com for license details (http://www.samdoit.com/end-user-license-agreement).
 */

namespace Samdoit\Community\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    /**
     * Receive Notifications
     */
    const XML_PATH_RECEIVE_PRODUCT_UPDATES = 'samdoit_extension/notification/update';
    const XML_PATH_RECEIVE_SPECIAL_OFFERS = 'samdoit_extension/notification/offer';
    const XML_PATH_RECEIVE_NEWS = 'samdoit_extension/notification/news';
    const XML_PATH_RECEIVE_TIPS_AND_TRICKS = 'samdoit_extension/notification/tip_trick';
    const XML_PATH_RECEIVE_GENERAL_INFORMATION = 'samdoit_extension/notification/general';

    /**
     * Display Menu
     */
    const XML_PATH_MENU_ENABLED = 'samdoit_extension/menu/display';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Receive Product Updates
     *
     * @param  null $storeId
     * @return string
     */
    public function receiveProductUpdates($storeId = null)
    {
        return $this->getConfig(
            self::XML_PATH_RECEIVE_PRODUCT_UPDATES,
            $storeId
        );
    }

    /**
     * Receive Special Offers
     *
     * @param  null $storeId
     * @return string
     */
    public function receiveSpecialOffers($storeId = null)
    {
        return $this->getConfig(
            self::XML_PATH_RECEIVE_SPECIAL_OFFERS,
            $storeId
        );
    }

    /**
     * Receive News
     *
     * @param  null $storeId
     * @return string
     */
    public function receiveNews($storeId = null)
    {
        return $this->getConfig(
            self::XML_PATH_RECEIVE_NEWS,
            $storeId
        );
    }

    /**
     * Receive Tips & Tricks
     *
     * @param  null $storeId
     * @return string
     */
    public function receiveTipsAndTricks($storeId = null)
    {
        return $this->getConfig(
            self::XML_PATH_RECEIVE_TIPS_AND_TRICKS,
            $storeId
        );
    }

    /**
     * Receive General Information
     *
     * @param  null $storeId
     * @return string
     */
    public function receiveGeneralInformation($storeId = null)
    {
        return $this->getConfig(
            self::XML_PATH_RECEIVE_GENERAL_INFORMATION,
            $storeId
        );
    }

    /**
     * Receive Notifications
     *
     * @param  null $storeId
     * @return array
     */
    public function receiveNotifications($storeId = null)
    {
        return [
            'update' => $this->receiveProductUpdates(),
            'offer' => $this->receiveSpecialOffers(),
            'news' => $this->receiveNews(),
            'tip_trick' => $this->receiveTipsAndTricks(),
            'general' => $this->receiveGeneralInformation()
        ];
    }

    /**
     * Display Menu
     *
     * @param  null $storeId
     * @return string
     */
    public function menuEnabled($storeId = null)
    {
        return $this->getConfig(
            self::XML_PATH_MENU_ENABLED,
            $storeId
        );
    }

    /**
     * Retrieve store config value
     *
     * @param  string $path
     * @param  null   $storeId
     * @return mixed
     */
    public function getConfig($path, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
