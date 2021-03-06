<?php
/**
 Admin Page Framework v3.7.6b03 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/server-information>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class ServerInformation_AdminPageFramework_Model__FormSubmission__Validator extends ServerInformation_AdminPageFramework_Model__FormSubmission__Validator_Base {
    public $oFactory;
    public $aInputs = array();
    public $aRawInputs = array();
    public $aOptions = array();
    public function __construct($oFactory) {
        $this->oFactory = $oFactory;
        add_filter("validation_pre_" . $this->oFactory->oProp->sClassName, array($this, '_replyToValiateUserFormInputs'), 10, 4);
    }
    public function _replyToValiateUserFormInputs($aInputs, $aRawInputs, $aOptions, $oFactory) {
        $_sTabSlug = $this->getElement($_POST, 'tab_slug', '');
        $_sPageSlug = $this->getElement($_POST, 'page_slug', '');
        $_aSubmits = $this->getElementAsArray($_POST, '__submit', array());
        $_sPressedInputName = $this->_getPressedSubmitButtonData($_aSubmits, 'name');
        $_sSubmitSectionID = $this->_getPressedSubmitButtonData($_aSubmits, 'section_id');
        $_aSubmitsInformation = array('page_slug' => $_sPageSlug, 'tab_slug' => $_sTabSlug, 'input_id' => $this->_getPressedSubmitButtonData($_aSubmits, 'input_id'), 'section_id' => $_sSubmitSectionID, 'field_id' => $this->_getPressedSubmitButtonData($_aSubmits, 'field_id'), 'input_name' => $_sPressedInputName,);
        $_aClassNames = array('ServerInformation_AdminPageFramework_Model__FormSubmission__Validator__Link', 'ServerInformation_AdminPageFramework_Model__FormSubmission__Validator__Redirect', 'ServerInformation_AdminPageFramework_Model__FormSubmission__Validator__Import', 'ServerInformation_AdminPageFramework_Model__FormSubmission__Validator__Export', 'ServerInformation_AdminPageFramework_Model__FormSubmission__Validator__Reset', 'ServerInformation_AdminPageFramework_Model__FormSubmission__Validator__ResetConfirm', 'ServerInformation_AdminPageFramework_Model__FormSubmission__Validator__ContactForm', 'ServerInformation_AdminPageFramework_Model__FormSubmission__Validator__ContactFormConfirm',);
        foreach ($_aClassNames as $_sClassName) {
            new $_sClassName($this->oFactory);
        }
        try {
            $this->addAndDoActions($this->oFactory, 'try_validation_before_' . $this->oFactory->oProp->sClassName, $aInputs, $aRawInputs, $_aSubmits, $_aSubmitsInformation, $this->oFactory);
            $_oFormSubmissionFilter = new ServerInformation_AdminPageFramework_Model__FormSubmission__Validator__Filter($this->oFactory, $aInputs, $aRawInputs, $aOptions, $_aSubmitsInformation);
            $aInputs = $_oFormSubmissionFilter->get();
            $this->addAndDoActions($this->oFactory, 'try_validation_after_' . $this->oFactory->oProp->sClassName, $aInputs, $aRawInputs, $_aSubmits, $_aSubmitsInformation, $this->oFactory);
        }
        catch(Exception $_oException) {
            $_sPropertyName = $_oException->getMessage();
            if (isset($_oException->$_sPropertyName)) {
                $this->_setSettingNoticeAfterValidation(empty($_oException->{$_sPropertyName}));
                return $_oException->{$_sPropertyName};
            }
            return array();
        }
        $this->_setSettingNoticeAfterValidation(empty($aInputs));
        return $aInputs;
    }
}