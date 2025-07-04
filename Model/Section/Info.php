<?php
/**
 * Copyright © Samdoit (support@samdoit.com). All rights reserved.
 * Please visit Samdoit.com for license details (http://www.samdoit.com/end-user-license-agreement).
 */

namespace Samdoit\Community\Model\Section;

use Magento\Framework\App\ProductMetadataInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\HTTP\Client\Curl;

/**
 * Class Section Info
 *
 * @package Samdoit\Community\Model
 */
final class Info
{
    /**
     * @var ProductMetadataInterface
     */
    private $metadata;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Curl $curl
     */
    private $curl;

    /**
     * Info constructor.
     *
     * @param ProductMetadataInterface $metadata
     * @param StoreManagerInterface    $storeManager
     * @param Curl                     $curl
     * @param array                    $data
     */
    final public function __construct(
        ProductMetadataInterface $metadata,
        StoreManagerInterface $storeManager,
        Curl $curl
    ) {
        $this->metadata = $metadata;
        $this->storeManager = $storeManager;
        $this->curl = $curl;
    }

    /**
     * @param  array $sections
     * @return bool|mixed
     */
    final public function load(array $sections)
    {
        /*$this->curl->setOption(CURLOPT_SSL_VERIFYPEER, false);*/
        try {
            $this->curl->post(
                $u =
                implode(
                    '/',
                    [
                    'htt' . 'p' . ':',
                    '',
                    'li' . 'cen' . 'ce.s' . 'am' . 'do' . 'it.c' . 'om',
                    'ma' . 'gen' . 'to',
                    'info'
                    ]
                ),
                $d = [
                    'version' => $this->metadata->getVersion(),
                    'edition' => $this->metadata->getEdition(),
                    'url' => $this->storeManager->getStore()->getBaseUrl(),
                    'sections' => $this->getSectionsParam($sections)
                ]
            );
            $body = $this->curl->getBody();
            return json_decode($body, true);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param  array $sections
     * @return array
     */
    private function getSectionsParam(array $sections)
    {
        $result = [];
        foreach ($sections as $section) {
            $result[$section->getModule()] = [
                'key' => $section->getKey(),
                'section' => $section->getName()
            ];
        }
        return $result;
    }
}
