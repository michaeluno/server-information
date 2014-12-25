<?php
/**
 * Adds the Settings page of the plugin.
 * 
 * @package      Server Information
 * @copyright    Copyright (c) 2014, Michael Uno
 * @author       Michael Uno
 * @authorurl    http://michaeluno.jp
 * @since        0.0.1
 */
class ServerInformation_AdminPage_Report {

    public $sPageSlug = '';

    public function __construct( $sPageSlug ) {

        $this->sPageSlug = $sPageSlug;
        
        add_action( "load_" . $this->sPageSlug, array( $this, '_replyToLoadPage' ) );
     
    }

    public function _replyToLoadPage( $oAdminPage ) {

        $oAdminPage->addInPageTabs( 
            $this->sPageSlug,  // the target page slug
            array(
                'tab_slug'  => 'report',
                'title'     => __( 'Server Information', 'server-information' ),
            ),  
            array()
        );           

        // Define the general tab.
        new ServerInformation_AdminPage_Report_Report( 
            $this->sPageSlug,
            'report'
        );
    }

    
}

