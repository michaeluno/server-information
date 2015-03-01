<?php
/**
 * Handles the initial set-up for the plugin.
 *    
 * @package      Server Information
 * @copyright    Copyright (c) 2015, <Michael Uno>
 * @author       Michael Uno
 * @authorurl    http://michaeluno.jp
 * @since        0.0.1
 * 
 */

/**
 * Loads the plugin.
 * 
 * @action      do      server_information_action_after_loading_plugin
 * @since       0.0.1
 */
final class ServerInformation_Bootstrap {
    
    /**
     * Indicates whether the bootstrap has been loaded or not so that multiple instances of this class won't be created.      
     */
    static public $_bLoaded = false;
        
    /**
     * Sets up properties and hooks.
     * 
     */
    public function __construct( $sPluginFilePath ) {
        
        // Do not allow multiple instances per page load.
        if ( self::$_bLoaded ) {
            return;
        }
        self::$_bLoaded = true;
        
        // Set up properties
        $this->_sFilePath = $sPluginFilePath;
        $this->_bIsAdmin = is_admin();
        
        // 1. Define constants.
        // $this->_defineConstants();
        
        // 2. Set global variables.
        // $this->_setGlobalVariables();
            
        // 3. Set up auto-load classes.
        $this->_loadClasses( $this->_sFilePath );

        // 4. Set up activation hook.
        // register_activation_hook( $this->_sFilePath, array( $this, '_replyToDoWhenPluginActivates' ) );
        
        // 5. Set up deactivation hook.
        // register_deactivation_hook( $this->_sFilePath, array( $this, '_replyToDoWhenPluginDeactivates' ) );
                
        // 7. Check requirements.
        register_activation_hook( $this->_sFilePath, array( $this, '_replyToCheckRequirements' ) );
        
        // 8. Schedule to load plugin specific components.
        add_action( 'plugins_loaded', array( $this, '_replyToLoadPluginComponents' ) );
                        
    }    
    
    /**
     * Sets up constants.
     */
    // private function _defineConstants() {}
    
    /**
     * Sets up global variables.
     */
    // private function _setGlobalVariables() {}
    
    /**
     * Register classes to be auto-loaded.
     * 
     */
    private function _loadClasses( $sFilePath ) {
        
        $_sPluginDir =  dirname( $sFilePath );
                    
        // Include necessary files.
        include( $_sPluginDir . '/include/class/boot/ServerInformation_AutoLoad.php' );
        if ( $this->_bIsAdmin ) {
            include( $_sPluginDir . '/include/library/admin-page-framework/admin-page-framework.php' );
        }
                    
        // Include the include lists. The including file reassigns the list(array) to the $_aClassFiles variable.
        $_aClassFiles        = array();
        include( $_sPluginDir . '/include/server-information-include-class-file-list.php' );

        // Register them
        new ServerInformation_AutoLoad( 
            array(),        // scanning dirs
            array(),        // autoloader options
            $_aClassFiles   // pre-generated class list
        );
                
    }

    /**
     * 
     * @since            0.0.1
     */
    public function _replyToCheckRequirements() {

        $_oRequirementCheck = new ServerInformation_AdminPageFramework_Requirement(
            array(
                'php'       => array(
                    'version'    => ServerInformation_Registry::REQUIRED_PHP_VERSION,
                    'error'      => __( 'The plugin requires the PHP version %1$s or higher.', 'uploader-anywheere' ),
                ),
                'wordpress' => array(
                    'version'    => ServerInformation_Registry::REQUIRED_WORDPRESSS_VERSION,
                    'error'      => __( 'The plugin requires the WordPress version %1$s or higher.', 'uploader-anywheere' ),
                ),
                'mysql'     => '',  // disabled
                // array(
                    // 'version'    =>    '5.5.24',
                    // 'error' => __( 'The plugin requires the MySQL version %1$s or higher.', 'uploader-anywheere' ),
                // ),
                'functions' => array(
                    // '_test'          => 'This is a test',
                    'curl_version' => sprintf( __( 'The plugin requires the %1$s to be installed.', 'uploader-anywheere' ), 'the cURL library' ),
                ),
                'classes'       => '',  // disabled
                // 'classes' => array(
                    // 'DOMDocument' => sprintf( __( 'The plugin requires the <a href="%1$s">libxml</a> extension to be activated.', 'pseudo-image' ), 'http://www.php.net/manual/en/book.libxml.php' ),
                // ),
                'constants'    => '',   // disabled
            ),
            ServerInformation_Registry::NAME
        );
        
        // If there is an error,
        if ( $_oRequirementCheck->check() ) {            

            $_oRequirementCheck->deactivatePlugin( 
                $this->_sFilePath, 
                __( 'Deactivating the plugin', 'server-information' ),  // additional message
                true    // is in the activation hook. 
            );
            exit;
            
        }        
         
    }

    /**
     * The plugin activation callback method.
     */    
    public function _replyToDoWhenPluginActivates() {}

    /**
     * The plugin deactivation callback method.
     */
    public function _replyToDoWhenPluginDeactivates() {}
    
    /**
     * Load localization files.
     *
     */
    private function _localize() {
        
        // This plugin does not have messages to be displayed in the front end.
        if ( ! $this->_bIsAdmin ) { return; }
        
        load_plugin_textdomain( 
            ServerInformation_Registry::TEXT_DOMAIN, 
            false, 
            dirname( plugin_basename( $this->_sFilePath ) ) . '/language/'
        );
            
        load_plugin_textdomain( 
            'admin-page-framework', 
            false, 
            dirname( plugin_basename( $this->_sFilePath ) ) . '/language/'
        );        
        
    }        
    
    /**
     * Loads the plugin specific components. 
     * 
     * @remark        All the necessary classes should have been already loaded.
     */
    public function _replyToLoadPluginComponents() {

        // 1. Set up localization.
        $this->_localize();
    
        // 3. Admin pages
        if ( $this->_bIsAdmin ) {
            
            // 3.1. Create admin pages - just the example link in the submenu.
            new ServerInformation_AdminPage( 
                '',
                $this->_sFilePath   // caller script path
            );
                    
        }            
        
        // Modules should use this hook.
        do_action( 'server_information_action_after_loading_plugin' );
        
    }

        
}