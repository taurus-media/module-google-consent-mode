define([
    'mage/utils/wrapper'
], function (wrapper) {
    'use strict';

    return function (cookieModel) {
        cookieModel.triggerSave = wrapper.wrapSuper(cookieModel.triggerSave, function () {
            document.body.dispatchEvent(new Event('amcookie_save'));
        });

        cookieModel.triggerAllow = wrapper.wrapSuper(cookieModel.triggerAllow, function () {
            document.body.dispatchEvent(new Event('amcookie_allow'));
        });

        return cookieModel;
    };
});
