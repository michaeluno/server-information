<?php
/**
 Admin Page Framework v3.7.6b03 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/server-information>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class ServerInformation_AdminPageFramework_Form_View___CSS_Loading extends ServerInformation_AdminPageFramework_Form_View___CSS_Base {
    protected function _get() {
        $_sSpinnerPath = $this->getWPAdminDirPath() . '/images/wpspin_light-2x.gif';
        if (!file_exists($_sSpinnerPath)) {
            return '';
        }
        $_sSpinnerURL = esc_url(admin_url('/images/wpspin_light-2x.gif'));
        return <<<CSSRULES
.server-information-form-loading {
    position: absolute;
    background-image: url({$_sSpinnerURL});
    background-repeat: no-repeat;
    background-size: 32px 32px;
    background-position: center;     
    display: block !important;
    width: 92%;
    height: 70%;
    opacity: 0.5;
}
CSSRULES;
        
    }
}