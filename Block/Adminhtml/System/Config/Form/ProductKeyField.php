<?php
/**
 * Copyright © Samdoit (support@samdoit.com). All rights reserved.
 * Please visit Samdoit.com for license details (http://www.samdoit.com/end-user-license-agreement).
 */

namespace Samdoit\Community\Block\Adminhtml\System\Config\Form;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;
use Samdoit\Community\Model\Section;
use Magento\Framework\App\ObjectManager;

/**
 * Class Product Key Field
 */
class ProductKeyField extends Field
{
    /**
     * Retrieve HTML markup for given form element
     *
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $fieldConfig = $element->getFieldConfig();
        $path = explode('/', $fieldConfig['path']);
        $path = $path[0];

        $section = ObjectManager::getInstance()->create(Section::class, ['name' => $path]);
        if ($section->getModule()) {
            if (!$element->getComment()) {
                $url = 'htt' . 'p' . ':' . '/' . '/' . 'ww' . 'w.' . 'sam' . 'do' . 'i' . 't' . '.' . 'co'
                    . 'm/' . 'down' . 'loa' . 'dab' . 'le/' . 'cus' . 'tomer' . '/'
                    . 'pr' . 'od' . 'ucts' . '/';
                $element->setComment(
                    'You can find product key in your <a href="' . $url . '" target="_blank">'
                    . 'Samdoit account</a>.'
                );
            }
            return parent::render($element);
        } else {
            return '';
        }
    }
}
