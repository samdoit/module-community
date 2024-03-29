<?php
/**
 * Copyright © Samdoit (support@samdoit.com). All rights reserved.
 * Please visit Samdoit.com for license details (http://www.samdoit.com/end-user-license-agreement).
 */

namespace Samdoit\Community\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\ProductMetadataInterface;

/**
 * Class Section
 *
 * @package Samdoit\Community\Model
 */
final class Section
{
    const MODULE = 'samdoitmodule';

    const ENABLED = 'enabled';

    const KEY = 'key';

    const TYPE = 'samdoittype';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $key;

    /**
     * @var ProductMetadataInterface
     */
    protected $metadata;


    /**
     * Section constructor.
     *
     * @param ScopeConfigInterface     $scopeConfig
     * @param ProductMetadataInterface $metadata
     * @param null                     $name
     * @param null                     $key
     */
    final public function __construct(
        ScopeConfigInterface $scopeConfig,
        ProductMetadataInterface $metadata,
        $name = null,
        $key = null
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->metadata = $metadata;
        $this->name = $name;
        $this->key = $key;
    }

    /**
     * @return bool
     */
    final public function isEnabled()
    {
        return (bool) $this->getConfig(self::ENABLED);
    }

    /**
     * @return string
     */
    final public function getModule()
    {
        $module = (string) $this->getConfig(self::MODULE);

        $url = $this->scopeConfig->getValue(
            'web/unsecure/base' . '_' . 'url',
            ScopeInterface::SCOPE_STORE,
            0
        );

        if (\Samdoit\Community\Model\UrlChecker::showUrl($url)) {
            if ($module && ($this->getConfig(self::TYPE) == 'Paid')) {
                return $module;
            }
        }
        return false;
    }

    /**
     * @return string
     */
    final public function getKey()
    {
        if (null !== $this->key) {
            return $this->key;
        } else {
            return $this->getConfig(self::KEY);
        }
    }

    /**
     * @return string
     */
    final public function getName()
    {
        return (string) $this->name;
    }

    /**
     * @return string
     */
    final public function getType()
    {
        return (string) $this->getConfig(self::TYPE);
    }

    /**
     * @param  $data
     * @param  null $k
     * @return bool
     */
    final public function validate($data)
    {
        $result = false;
        $module = (string) $this->getConfig(self::MODULE);

        if ($module && isset($data[$module])) {
            return !empty($data[$module]);
        }

        $id = $this->getModule();
        $k = $this->getKey();
        if (!empty($k)) {
            $result = $this->validateIDK($id, $k);
            if (!$result) {
                $id .= 'Plus';
                $result = $this->validateIDK($id, $k);
            }
        }

        return $result;
    }

    /**
     * @param  string $id
     * @param  string $k
     * @return bool
     */
    private function validateIDK($id, $k)
    {
        $l = substr($id, 1, 1);
        $d = (string) strlen($id);

        return ((string) strlen($k) >= '32')
            && (strpos($k, $l, 5) == 5)
            && (strpos($k, $d, 19) == 19);
    }

    /**
     * @param  string $field
     * @return mixed
     */
    private function getConfig($field)
    {
        $g = 'general';
        return $this->scopeConfig->getValue(
            implode('/', [$this->name, $g, $field]),
            ScopeInterface::SCOPE_STORE,
            0
        );
    }
}
