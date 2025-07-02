<?php
/**
 * Copyright © Samdoit (support@samdoit.com). All rights reserved.
 * Please visit Samdoit.com for license details (http://www.samdoit.com/end-user-license-agreement).
 */

namespace Samdoit\Community\Block\Adminhtml\System\Config\Form;

use Samdoit\Community\Api\ModuleVersionInterface;

/**
 * Admin Samdoit configurations information block
 */
class Info extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    protected $moduleList;

    /**
     * @var ModuleVersionInterface
     */
    protected $moduleVersion;

    /**
     * Info constructor.
     *
     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
     * @param \Magento\Backend\Block\Template\Context       $context
     * @param array                                         $data
     * @param ModuleVersionInterface|null                   $moduleVersion
     */
    public function __construct(
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Backend\Block\Template\Context $context,
        array $data = [],
        ?ModuleVersionInterface $moduleVersion = null
    ) {
        parent::__construct($context, $data);
        $this->moduleList = $moduleList;
        $this->moduleVersion = $moduleVersion ?: \Magento\Framework\App\ObjectManager::getInstance()->get(
            \Samdoit\Community\Api\ModuleVersionInterface::class
        );
    }

    /**
     * Return info block html
     *
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $useUrl = \Samdoit\Community\Model\UrlChecker::showUrl($this->getUrl());
        $version = $this->moduleVersion->execute($this->getModuleName());
        $html = '<div style="padding:10px;background-color:#f8f8f8;border:1px solid #ddd;margin-bottom:7px;">
            ' . $this->escapeHtml($this->getModuleTitle()) . ' v' . $this->escapeHtml($version) . ' was developed by ';
        if ($useUrl) {
            $html .= '<a href="' . $this->escapeHtml($this->getModuleUrl()) . '" target="_blank">Samdoit</a>';
        } else {
            $html .= '<strong>Samdoit</strong>';
        }
        $html .= '.</div>';

        return $html;
    }

    /**
     * Return extension url
     *
     * @return string
     */
    protected function getModuleUrl()
    {
        return 'https://sam' . 'do' . 'it.com?utm_source=Mage' . 'nto' . '2' . 'Config' .
            '&utm_medium=link&utm_campaign=regular';
    }

    /**
     * Return extension title
     *
     * @return string
     */
    protected function getModuleTitle()
    {
        return ucwords(str_replace('_', ' ', $this->getModuleName())) . ' Extension';
    }
}
