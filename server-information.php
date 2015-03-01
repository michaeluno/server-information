<?php
/*
	Plugin Name:    Server Information
	Plugin URI:     http://en.michaeluno.jp/admin-page-framework
	Description:    Adds an email report form in the admin area to send server information.
	Author:         Michael Uno
	Author URI:     http://michaeluno.jp
	Version:        1.1.3b
	Requirements:   PHP 5.2.4 or above, WordPress 3.3 or above. Admin Page Framework 3.0.6 or above
*/

/**
 * The base class of the registry class which provides basic plugin information.
 * 
 * Te inclusion script also refer to the constants. 
 * 
 * @since       0.0.1
 */
class ServerInformation_Registry_Base {

	const VERSION        = '1.1.3b';    // <--- DON'T FORGET TO CHANGE THIS AS WELL!!
	const NAME           = 'Server Information';
	const DESCRIPTION    = 'Adds an email report form to send server information in the admin area.';
	const URI            = 'http://en.michaeluno.jp/';
	const AUTHOR         = 'miunosoft (Michael Uno)';
	const AUTHOR_URI     = 'http://en.michaeluno.jp/';
	const COPYRIGHT      = 'Copyright (c) 2014, Michael Uno';
	const LICENSE        = 'GPL v2 or later';
	const CONTRIBUTORS   = '';
	
}
/**
 * Provides plugin information.
 * @since       0.0.1
 */
final class ServerInformation_Registry extends ServerInformation_Registry_Base {
	        
	// The plugin itself uses these values.
	const TEXT_DOMAIN                = 'server-information';
	const ADMIN_PAGE_REPORT          = 'si_report';    // the root menu page slug

	const REQUIRED_PHP_VERSION        = '5.2.4';
	const REQUIRED_WORDPRESSS_VERSION = '3.5';
	    
	// These properties will be defined in the setUp() method.
	static public $sFilePath = '';
	static public $sDirPath  = '';
	
	/**
	 * Sets up static properties.
	 */
	static function setUp( $sPluginFilePath=null ) {
	                    
		self::$sFilePath = $sPluginFilePath ? $sPluginFilePath : __FILE__;
		self::$sDirPath  = dirname( self::$sFilePath );
	    
	}    
	
	/**
	 * Returns the URL with the given relative path to the plugin path.
	 * 
	 * Example:  ServerInformation_Registry::getPluginURL( 'asset/css/meta_box.css' );
     * @since       0.0.1
	 */
	public static function getPluginURL( $sRelativePath='' ) {
		return plugins_url( $sRelativePath, self::$sFilePath );
	}
    
    /**
     * Returns the information of this class.
     * 
     * @since       0.0.1
     */
    static public function getInfo() {
        $_oReflection = new ReflectionClass( __CLASS__ );
        return $_oReflection->getConstants()
            + $_oReflection->getStaticProperties()
        ;
    }    
    

}
/* Initial checks. */
if ( ! defined( 'ABSPATH' ) ) { return; }

if ( ! is_admin() ) { return; }

/* Registry set up. */
ServerInformation_Registry::setUp( __FILE__ );

/* Run the bootstrap. */
include( dirname( __FILE__ ) . '/include/class/boot/ServerInformation_Bootstrap.php' );
new ServerInformation_Bootstrap( __FILE__ );