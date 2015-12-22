<?php
/**
 Admin Page Framework v3.7.6b03 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/server-information>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
abstract class ServerInformation_AdminPageFramework_Form_Utility extends ServerInformation_AdminPageFramework_FrameworkUtility {
    static public function getElementPathAsArray($asPath) {
        if (is_array($asPath)) {
            return;
        }
        return explode('|', $asPath);
    }
    static public function getFormElementPath($asID) {
        return implode('|', self::getAsArray($asID));
    }
    static public function getIDSanitized($asID) {
        return is_scalar($asID) ? self::sanitizeSlug($asID) : self::getAsArray($asID);
    }
}