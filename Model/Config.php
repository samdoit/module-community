<?php
/**
 * Copyright © Samdoit (support@samdoit.com). All rights reserved.
 * Please visit Samdoit.com for license details (http://www.samdoit.com/end-user-license-agreement).
 */

declare(strict_types=1);

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
    public function receiveProductUpdates(int|string|null $storeId = null): mixed
    {
        return $this->getConfig(self::XML_PATH_RECEIVE_PRODUCT_UPDATES, $storeId);
    }

    public function receiveSpecialOffers(int|string|null $storeId = null): mixed
    {
        return $this->getConfig(self::XML_PATH_RECEIVE_SPECIAL_OFFERS, $storeId);
    }

    public function receiveNews(int|string|null $storeId = null): mixed
    {
        return $this->getConfig(self::XML_PATH_RECEIVE_NEWS, $storeId);
    }

    public function receiveTipsAndTricks(int|string|null $storeId = null): mixed
    {
        return $this->getConfig(self::XML_PATH_RECEIVE_TIPS_AND_TRICKS, $storeId);
    }

    public function receiveGeneralInformation(int|string|null $storeId = null): mixed
    {
        return $this->getConfig(self::XML_PATH_RECEIVE_GENERAL_INFORMATION, $storeId);
    }

    public function receiveNotifications(int|string|null $storeId = null): array
    {
        return [
            'update' => $this->receiveProductUpdates($storeId),
            'offer' => $this->receiveSpecialOffers($storeId),
            'news' => $this->receiveNews($storeId),
            'tip_trick' => $this->receiveTipsAndTricks($storeId),
            'general' => $this->receiveGeneralInformation($storeId)
        ];
    }

    public function menuEnabled(int|string|null $storeId = null): mixed
    {
        return $this->getConfig(self::XML_PATH_MENU_ENABLED, $storeId);
    }

    public function getConfig(string $path, int|string|null $storeId = null): mixed
    {
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
