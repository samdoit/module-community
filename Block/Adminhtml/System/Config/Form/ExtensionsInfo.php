<?php
/**
 * Copyright © Samdoit (support@samdoit.com). All rights reserved.
 * Please visit Samdoit.com for license details (http://www.samdoit.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Samdoit\Community\Block\Adminhtml\System\Config\Form;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\HTTP\Client\Curl;
use Samdoit\Community\Api\ModuleVersionInterface;

class ExtensionsInfo extends Field
{
    /**
     * @var ModuleListInterface
     */
    private $moduleList;

    /**
     * @var ModuleVersionInterface
     */
    private $moduleVersion;

    /**
     * @var Curl
     */
    private $curl;

    public function __construct(
        Context $context,
        ModuleListInterface $moduleList,
        ModuleVersionInterface $moduleVersion,
        Curl $curl,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->moduleList = $moduleList;
        $this->moduleVersion = $moduleVersion;
        $this->curl = $curl;
    }

    public function render(AbstractElement $element): string
    {
        $products = $this->getJsonObject();

        if (!$products) {
            return '';
        }

        $lists = [
            'need_update' => __('Extensions to Update'),
            'up_to_date' => __('Up-to-Date Extensions'),
            'new_extensions' => __('Available NEW Extensions'),
        ];

        $html = '';
        foreach ($lists as $listKey => $lable) {
            $html .= '<h3>' . $this->escapeHtml($lable) . '</h3>';
            $html .= '<table class="data-grid">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th class="data-grid-th">' . $this->escapeHtml(__('Extension')) . '</th>';
            $html .= '<th class="data-grid-th">' . $this->escapeHtml(__('Version')) . '</th>';
            $html .= '<th class="data-grid-th">' . $this->escapeHtml(__('Change Log')) . '</th>';
            $html .= '<th class="data-grid-th">' . $this->escapeHtml(__('User Guide')) . '</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody class="samdoit-section">';

            foreach ($products as $productKey => $product) {
                $moduleName = 'Samdoit_' . $productKey;
                $module = $this->moduleList->getOne($moduleName);

                if ((!$module && $listKey != 'new_extensions') || ($module && $listKey == 'new_extensions')) {
                    continue;
                }
                if ($listKey == 'up_to_date' &&
                    version_compare($this->moduleVersion->execute($moduleName), $product->version) < 0
                ) {
                    continue;
                }
                if ($listKey == 'need_update' &&
                    version_compare($this->moduleVersion->execute($moduleName), $product->version) >= 0
                ) {
                    continue;
                }

                if ($listKey == 'need_update') {
                    $version = $this->moduleVersion->execute($moduleName) . ' -> ' . $product->version;
                } elseif ($listKey == 'new_extensions') {
                    $version = $product->version;
                } else {
                    $version = $this->moduleVersion->execute($moduleName);
                }

                $html .= '<tr>';
                $html .= '<td><a target="_blank" href="' . $this->escapeUrl($product->product_url) . '">'
                    . $this->escapeHtml($product->product_name) . '</a></td>';
                $html .= '<td>' . $this->escapeHtml($version) . '</td>';
                $html .= '<td><a target="_blank" href="' . $this->escapeUrl($product->change_log_url) . '">'
                    . $this->escapeHtml(__('Change Log')) . '</a></td>';
                $html .= '<td><a target="_blank" href="' . $this->escapeUrl($product->documentation_url) . '">'
                    . $this->escapeHtml(__('User Guide')) . '</a></td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table></br>';
        }
        return $html;
    }

    private function getJsonObject(): mixed
    {
        try {
            $this->curl->get('https://licence.samdoit.com/media/magento/product-versions.json');
            $result = $this->curl->getBody();
        } catch (\Exception) {
            return null;
        }

        if (!$result) {
            return null;
        }

        return json_decode($result);
    }
}
