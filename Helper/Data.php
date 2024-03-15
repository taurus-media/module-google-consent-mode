<?php
/**
 * Copyright (c) 2024. Taurus. All rights reserved
 * @author Alexander Tolochko
 */

namespace Taurus\GoogleConsentMode\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_CONSENT_MODE_MAP = 'taurus_googleconsentmode/mapping/map';

    /**
     * @return array
     */
    public function getConsentModeMap()
    {
        $map = $this->scopeConfig->getValue(self::XML_PATH_CONSENT_MODE_MAP, ScopeInterface::SCOPE_STORE) ?? '';
        if (is_string($map)) {
            $map = json_decode($map, true);
        }

        return $map;
    }

    /**
     * @return array
     */
    public function getDefaultConsentModes()
    {
        $defaultModes = [];
        foreach ($this->getConsentModeSettings() as $dataTypeCode => $dataType) {
            $defaultModes[$dataTypeCode] = $dataType['default_value'];
        }

        return $defaultModes;
    }

    /**
     * @return array
     */
    public function getConsentModeSettings()
    {
        $settings = [];

        $map = $this->getConsentModeMap();
        foreach ($map as $item) {
            $settings[$item['consent_name']] = [
                'default_value' => $item['default_value'],
                'cookie_group_id' => $item['cookie_group_id']
            ];
        }

        return $settings;
    }
}
