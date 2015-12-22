<?php
/**
 * Adds the Report tab to the Settings page of the plugin.
 * 
 * @package      Server Information
 * @copyright    Copyright (c) 2014-2015, Michael Uno
 * @author       Michael Uno
 * @authorurl    http://michaeluno.jp
 * @since        0.0.1
 */
class ServerInformation_AdminPage_Report_Report {

    public $sPageSlug   = '';
    public $sTabSlug    = 'report';
    public $sSectionID  = 'report';

    /**
     * Sets up properties and hooks.
     * 
     * @since       0.0.1
     */
    public function __construct() {

        $this->sPageSlug    = ServerInformation_Registry::ADMIN_PAGE_REPORT;
        $this->sTabSlug     = 'report';
        $this->sSectionID   = $this->sTabSlug;
 
        add_action( 
            "load_" . $this->sPageSlug . '_' . $this->sTabSlug, 
            array( $this, 'replyToLoadTab' ) 
        );
               
    }
    
    /**
     * Triggered when the tab is loaded.
     * 
     * @since   0.0.1
     */
    public function replyToLoadTab( $oFactory ) {
        
        add_action(
            "validation_" . $oFactory->oProp->sClassName. '_' . $this->sSectionID,
            array( $this, 'replyToValidateFormData' ),
            10,
            4
        );        
        
        $_oCurrentUser  = wp_get_current_user();
        $_bIsConfirming = isset( $_GET['confirmation'] ) && 'email' === $_GET['confirmation'];
        
        $oFactory->addSettingSections(    
            $this->sPageSlug, // the target page slug
            array(
                'section_id'        => $this->sSectionID, // avoid hyphen(dash), dots, and white spaces
                'tab_slug'          => $this->sTabSlug,
                'title'             => __( 'Report', 'server-information' ),
            )
        );       
                
        $_aClassNames = array(
            'ServerInformation_Formfields_User',
            'ServerInformation_Formfields_ServerInformation',
            'ServerInformation_Formfields_Email',
        );        
                
        
        foreach( $_aClassNames as $_sClassName ) {
            $_oField = new $_sClassName;
            foreach( $_oField->get() as $_aField ) {                
                $oFactory->addSettingFields(
                    $this->sSectionID,   // target section id
                    $_aField
                );
            }
        }
        
    }
 
    /**
     * Validates the submitted data.
     * 
     * @since       0.0.1
     */
    public function replyToValidateFormData( $aInputs, $aOldInputs, $oFactory, $aSubmitInfo ) {

        // Local variables
        $_bIsValid = true;
        $_aErrors  = array();
   
        if ( ! $aInputs[ 'allow_sending_system_information' ] ) {
            $_bIsValid = false;
            $_aErrors[ $this->sSectionID ][ 'allow_sending_system_information' ] = __( 'We need necessary information to help you.', 'server-information' );
        }
        
        if ( ! $_bIsValid ) {
        
            $oFactory->setFieldErrors( $_aErrors );     
            $oFactory->setSettingNotice( __( 'Please help us to help you.', 'server-information' ) );
            return $aOldInputs;
            
        }     
        
        // Drop unchecked information.               
        foreach( ( array ) $aInputs[ 'select_iofo' ] as $_sInfoType => $_bChecked ) {
            if ( $_bChecked ) { 
                continue; 
            }
            $_sInfoType = ltrim( $_sInfoType, '.' );

            unset( $aInputs[ $_sInfoType ] );
        }
        
        // Otherwise, process the data.
        return $aInputs;        
        
    }   
    

}

