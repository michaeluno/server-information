<?php
/**
 Admin Page Framework v3.7.6b03 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/server-information>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class ServerInformation_AdminPageFramework_Form_View___Generate_FieldInputID extends ServerInformation_AdminPageFramework_Form_View___Generate_FieldTagID {
    public $isIndex = '';
    public function __construct() {
        $_aParameters = func_get_args() + array($this->aArguments, $this->isIndex, $this->hfCallback,);
        $this->aArguments = $_aParameters[0];
        $this->isIndex = $_aParameters[1];
        $this->hfCallback = $_aParameters[2];
    }
    public function get() {
        return $this->_getFiltered($this->_getBaseFieldTagID() . '__' . $this->isIndex);
    }
}