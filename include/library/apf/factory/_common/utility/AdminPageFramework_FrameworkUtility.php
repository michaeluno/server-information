<?php
/**
 Admin Page Framework v3.7.6b03 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/server-information>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class ServerInformation_AdminPageFramework_FrameworkUtility extends ServerInformation_AdminPageFramework_WPUtility {
    static public function sortAdminSubMenu() {
        if (self::hasBeenCalled(__METHOD__)) {
            return;
        }
        foreach (( array )$GLOBALS['_apf_sub_menus_to_sort'] as $_sIndex => $_sMenuSlug) {
            if (!isset($GLOBALS['submenu'][$_sMenuSlug])) {
                continue;
            }
            ksort($GLOBALS['submenu'][$_sMenuSlug]);
            unset($GLOBALS['_apf_sub_menus_to_sort'][$_sIndex]);
        }
    }
    static public function getFrameworkVersion($bTrimDevVer = false) {
        $_sVersion = ServerInformation_AdminPageFramework_Registry::getVersion();
        return $bTrimDevVer ? self::getSuffixRemoved($_sVersion, '.dev') : $_sVersion;
    }
    static public function getFrameworkName() {
        return ServerInformation_AdminPageFramework_Registry::NAME;
    }
}