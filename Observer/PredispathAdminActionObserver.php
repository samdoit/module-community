<?php
/**
 * Copyright © Samdoit (support@samdoit.com). All rights reserved.
 * Please visit Samdoit.com for license details (http://www.samdoit.com/end-user-license-agreement).
 */

namespace Samdoit\Community\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Community observer
 */
class PredispathAdminActionObserver implements ObserverInterface
{
    /**
     * @var \Samdoit\Community\Model\AdminNotificationFeedFactory
     */
    protected $feedFactory;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $backendAuthSession;

    /**
     * @param \Samdoit\Community\Model\AdminNotificationFeedFactory $feedFactory
     * @param \Magento\Backend\Model\Auth\Session $backendAuthSession
     */
    public function __construct(
        \Samdoit\Community\Model\AdminNotificationFeedFactory $feedFactory,
        \Magento\Backend\Model\Auth\Session $backendAuthSession
    ) {
        $this->feedFactory = $feedFactory;
        $this->backendAuthSession = $backendAuthSession;
    }

    /**
     * Predispath admin action controller
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->backendAuthSession->isLoggedIn()) {
            $feedModel = $this->feedFactory->create();
            /* @var $feedModel \Samdoit\Community\Model\AdminNotificationFeed */
            $feedModel->checkUpdate();
        }
    }
}
