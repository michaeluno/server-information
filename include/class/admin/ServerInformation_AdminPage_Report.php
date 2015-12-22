<?php
/**
 * Adds the Settings page of the plugin.
 * 
 * @package      Server Information
 * @copyright    Copyright (c) 2014-2015, Michael Uno
 * @author       Michael Uno
 * @authorurl    http://michaeluno.jp
 * @since        0.0.1
 */
class ServerInformation_AdminPage_Report {

    public $sPageSlug = '';
    
    /**
     * Sets up hooks and properties.
     * @since       0.0.1
     */
    public function __construct() {

        $this->sPageSlug =  ServerInformation_Registry::ADMIN_PAGE_REPORT;
        
        add_action( "load_" . $this->sPageSlug, array( $this, '_replyToLoadPage' ) );
     
    }
    
    /**
     * Called when the page loads.
     * 
     * @since       0.0.1
     */
    public function _replyToLoadPage( $oAdminPage ) {

        $oAdminPage->addInPageTabs( 
            $this->sPageSlug,  // the target page slug
            array(
                'tab_slug'  => 'report',
                'title'     => __( 'Server Information', 'server-information' ),
            ),  
            array()
        );           

        // Register custom field types
        new ServerInformation_RevealerCustomFieldType( $oAdminPage->oProp->sClassName );
        
        // Define the general tab.
        new ServerInformation_AdminPage_Report_Report;
        
    }

}