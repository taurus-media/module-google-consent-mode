<?php
/**
 * Copyright (c) 2024. Taurus. All rights reserved
 * @author Alexander Tolochko
 */

namespace Taurus\GoogleConsentMode\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;

class DefaultMode extends Select
{
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
        return [
            ['label' => 'granted', 'value' => 'granted'],
            ['label' => 'denied', 'value' => 'denied']
        ];
    }
}
