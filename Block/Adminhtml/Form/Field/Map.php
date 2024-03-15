<?php
/**
 * Copyright (c) 2024. Taurus. All rights reserved
 * @author Alexander Tolochko
 */

namespace Taurus\GoogleConsentMode\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Ranges
 */
class Map extends AbstractFieldArray
{
    /**
     * @var DefaultMode
     */
    private $defaultModeRenderer;

    private $cookieGroupRenderer;

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('consent_name', [
            'label' => __('Consent Name')
        ]);

        $this->addColumn('default_value', [
            'label' => __('Default Mode'),
            'class' => 'required-entry',
            'renderer' => $this->getDefaultModeRenderer()
        ]);

        $this->addColumn('cookie_group_id', [
            'label' => __('Cookie Group'),
            'class' => 'required-entry',
            'renderer' => $this->getCookieGroupRenderer()
        ]);

        $this->_addAfter = false;
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];

        $defaultValue = $row->getDefaultValue();
        if ($defaultValue !== null) {
            $options['option_' . $this->getDefaultModeRenderer()->calcOptionHash($defaultValue)] = 'selected="selected"';
        }

        $cookieGroupId = $row->getCookieGroupId();
        if ($cookieGroupId !== null) {
            $options['option_' . $this->getCookieGroupRenderer()->calcOptionHash($cookieGroupId)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * @return \Magento\Framework\View\Element\BlockInterface|DefaultMode
     * @throws LocalizedException
     */
    private function getDefaultModeRenderer()
    {
        if (!$this->defaultModeRenderer) {
            $this->defaultModeRenderer = $this->getLayout()->createBlock(
                DefaultMode::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->defaultModeRenderer;
    }

    /**
     * @return \Magento\Framework\View\Element\BlockInterface|CookieGroup
     * @throws LocalizedException
     */
    private function getCookieGroupRenderer()
    {
        if (!$this->cookieGroupRenderer) {
            $this->cookieGroupRenderer = $this->getLayout()->createBlock(
                CookieGroup::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->cookieGroupRenderer;
    }
}
