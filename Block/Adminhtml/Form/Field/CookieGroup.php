<?php
/**
 * Copyright (c) 2024. Taurus. All rights reserved
 * @author Alexander Tolochko
 */

namespace Taurus\GoogleConsentMode\Block\Adminhtml\Form\Field;

use Amasty\GdprCookie\Model\Cookie\CookieData;
use Magento\Framework\View\Element\Html\Select;
use Magento\Store\Model\StoreManagerInterface;

class CookieGroup extends Select
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CookieData
     */
    private $cookieData;

    /**
     * @param \Magento\Framework\View\Element\Context $context
     * @param StoreManagerInterface $storeManager
     * @param CookieData $cookieData
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        StoreManagerInterface $storeManager,
        CookieData $cookieData,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->storeManager = $storeManager;
        $this->cookieData = $cookieData;
    }

    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param $value
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    private function getSourceOptions(): array
    {
        $cookieSettings = $this->cookieData->getGroupData(
            (int) $this->storeManager->getStore()->getId()
        );

        $options = [
            ['label' => __('-- Please, select --'), 'value' => 0]
        ];

        foreach ($cookieSettings['groupData'] as $cookieGroup) {
            $options[] = [
                'label' => $cookieGroup['name'],
                'value' => $cookieGroup['groupId']
            ];
        }

        return $options;
    }
}
