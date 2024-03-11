<?php
/**
 * Copyright © Samdoit (support@samdoit.com). All rights reserved.
 * Please visit Samdoit.com for license details (http://www.samdoit.com/end-user-license-agreement).
 */

namespace Samdoit\Community\Observer;

use Magento\Framework\Event\ObserverInterface;
use Samdoit\Community\Model\SectionFactory;
use Samdoit\Community\Model\Section\Info;
use Magento\Framework\Message\ManagerInterface;

/**
 * Community observer
 */
class ConfigObserver implements ObserverInterface
{
    /**
     * @var SectionFactory
     */
    private $sectionFactory;

    /**
     * @var Info
     */
    private $info;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * ConfigObserver constructor.
     *
     * @param SectionFactory   $sectionFactory
     * @param Info             $info
     * @param ManagerInterface $messageManager
     */
    final public function __construct(
        SectionFactory $sectionFactory,
        Info $info,
        ManagerInterface $messageManager
    ) {
        $this->sectionFactory = $sectionFactory;
        $this->info = $info;
        $this->messageManager = $messageManager;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    final public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $request = $observer->getEvent()->getRequest();
        $groups = $request->getParam('groups');
        if (empty($groups['general']['fields']['enabled']['value'])) {
            return;
        }

        $key = isset($groups['general']['fields']['key']['value'])
            ? $groups['general']['fields']['key']['value']
            : null;

        $section = $this->sectionFactory->create(
            [
                'name' => $request->getParam('section'),
                'key' => $key
            ]
        );

        if ($section->getType() == 'Free') {
            return;
        } elseif ($section->getType() == 'Paid') {
            $data = $this->info->load([$section]);

            if (!$section->validate($data)) {
                $groups['general']['fields']['enabled']['value'] = 0;
                $request->setPostValue('groups', $groups);
    
                $this->messageManager->addError('Product Key is empty or invalid. The extension has been automatically disabled.');
            }
        } else {
            return;
        }
    }
}
