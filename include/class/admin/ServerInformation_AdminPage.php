<?php
/**
 * One of the abstract class of the plugin admin page class.
 * 
 * @package      Server Information
 * @copyright    Copyright (c) 2014-2015, Michael Uno
 * @author       Michael Uno
 * @authorurl    http://michaeluno.jp
 * @since        0.0.1
 */
/* if ( ! class_exists( 'AdminPageFramework ' ) ) {
    include( dirname( ServerInformation_Registry::$sDirPath ) . '/admin-page-framework/development/admin-page-framework.php' );
    // include( dirname( ServerInformation_Registry::$sDirPath ) . '/admin-page-framework/library/admin-page-framework.min.php' );
}
class ServerInformation_AdminPage extends AdminPageFramework { */
class ServerInformation_AdminPage extends ServerInformation_AdminPageFramework {
    
    /**
     * Sets up admin pages.
     * 
     * @since       0.0.1
     */
    public function setUp() {

        // Register custom field types
        // new ServerInformation_MultipleTextFieldType( $this->oProp->sClassName );
    
        /* ( required ) Set the root page */
        $this->setRootMenuPage( 'Tools' ); 

       $this->addSubMenuItems( 
            array(
                'title'         => __( 'Server Information', 'server-information' ),
                'page_slug'     => ServerInformation_Registry::ADMIN_PAGE_REPORT,    // page slug                
            )
        );
         
        $this->setPageHeadingTabsVisibility( false ); // disables the page heading tabs by passing false.
        $this->setInPageTabTag( 'h2' ); // sets the tag used for in-page tabs     
        $this->setPageTitleVisibility( false ); // disable the page title of a specific page.
        $this->setPluginSettingsLinkLabel( __( 'Report', 'server-information' ) ); // pass an empty string.
                 
        // Define the Report page.
        new ServerInformation_AdminPage_Report;
        
    }
    

}