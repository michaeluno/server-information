<?php
/**
 Admin Page Framework v3.7.6b03 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/server-information>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class ServerInformation_AdminPageFramework_Form_Model___Format_FieldsetOutput extends ServerInformation_AdminPageFramework_Form_Model___Format_Fieldset {
    static public $aStructure = array('_section_index' => null, 'tag_id' => null, '_tag_id_model' => '', '_field_name' => '', '_field_name_model' => '', '_field_name_flat' => '', '_field_name_flat_model' => '', '_field_address' => '', '_field_address_model' => '', '_parent_field_object' => null,);
    public $aFieldset = array();
    public $iSectionIndex = null;
    public $aFieldTypeDefinitions = array();
    public function __construct() {
        $_aParameters = func_get_args() + array($this->aFieldset, $this->iSectionIndex, $this->aFieldTypeDefinitions,);
        $this->aFieldset = $_aParameters[0];
        $this->iSectionIndex = $_aParameters[1];
        $this->aFieldTypeDefinitions = $_aParameters[2];
    }
    public function get() {
        $_aFieldset = $this->aFieldset + self::$aStructure;
        $_aFieldset['_section_index'] = $this->iSectionIndex;
        $_oFieldTagIDGenerator = new ServerInformation_AdminPageFramework_Form_View___Generate_FieldTagID($_aFieldset, $_aFieldset['_caller_object']->aCallbacks['hfTagID']);
        $_aFieldset['tag_id'] = $_oFieldTagIDGenerator->get();
        $_aFieldset['_tag_id_model'] = $_oFieldTagIDGenerator->getModel();
        $_oFieldNameGenerator = new ServerInformation_AdminPageFramework_Form_View___Generate_FieldName($_aFieldset, $_aFieldset['_caller_object']->aCallbacks['hfName']);
        $_aFieldset['_field_name'] = $_oFieldNameGenerator->get();
        $_aFieldset['_field_name_model'] = $_oFieldNameGenerator->getModel();
        $_oFieldFlatNameGenerator = new ServerInformation_AdminPageFramework_Form_View___Generate_FlatFieldName($_aFieldset, $_aFieldset['_caller_object']->aCallbacks['hfNameFlat']);
        $_aFieldset['_field_name_flat'] = $_oFieldFlatNameGenerator->get();
        $_aFieldset['_field_name_flat_model'] = $_oFieldFlatNameGenerator->getModel();
        $_oFieldAddressGenerator = new ServerInformation_AdminPageFramework_Form_View___Generate_FieldAddress($_aFieldset);
        $_aFieldset['_field_address'] = $_oFieldAddressGenerator->get();
        $_aFieldset['_field_address_model'] = $_oFieldAddressGenerator->getModel();
        $_aFieldset = $this->_getMergedFieldTypeDefault($_aFieldset, $this->aFieldTypeDefinitions);
        return $_aFieldset;
    }
    private function _getMergedFieldTypeDefault(array $aFieldset, array $aFieldTypeDefinitions) {
        return $this->uniteArrays($aFieldset, $this->getElementAsArray($aFieldTypeDefinitions, array($aFieldset['type'], 'aDefaultKeys'), array()));
    }
}