<?php

declare(strict_types=1);

namespace EonInfosys\Eoncore\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ActionInterface;

abstract class Eoncore extends Action implements ActionInterface
{
    public const ADMIN_RESOURCE_VIEW = 'EonInfosys_Eoncore::index';

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('EonInfosys_Eoncore::index')
            ->addBreadcrumb(__('EonInfosys'), __('EonInfosys'));

        return $resultPage;
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE_VIEW);
    }
}
