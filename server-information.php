<?php
/*
	Plugin Name:    Server Information
	Plugin URI:     http://en.michaeluno.jp/admin-page-framework
	Description:    Adds an email report form in the admin area to send server information.
	Author:         Michael Uno
	Author URI:     http://michaeluno.jp
	Version:        1.1.1b03
	Requirements:   PHP 5.2.4 or above, WordPress 3.3 or above. Admin Page Framework 3.0.6 or above
*/

/**
 * The base class of the registry class which provides basic plugin information.
 * 
 * The minifier script and the inclusion script also refer to the constants. 
 * 
 * @since       0.0.1
 */
class ServerInformation_Registry_Base {

	const Version        = '1.1.1b03';    // <--- DON'T FORGET TO CHANGE THIS AS WELL!!
	const Name           = 'Server Information';
	const Description    = 'Adds an email report form to send server information in the admin area.';
	const URI            = 'http://en.michaeluno.jp/';
	const Author         = 'miunosoft (Michael Uno)';
	const AuthorURI      = 'http://en.michaeluno.jp/';
	const Copyright      = 'Copyright (c) 2014, Michael Uno';
	const License        = 'GPL v2 or later';
	const Contributors   = '';
	
}
/**
 * Provides plugin information.
 * @since       0.0.1
 */
final class ServerInformation_Registry extends ServerInformation_Registry_Base {
	        
	// The plugin itself uses these values.
	const OptionKey                 = 'server_information_options';
	const TransientPrefix           = 'SInfo_';    // Up to 8 characters as transient name allows 45 characters or less ( 40 for site transients ) so that md5 (32 characters) can be added
	const TextDomain                = 'server-information';
	const TextDomainPath            = './language';
    
	// const AdminPage_ = '...';
	// const AdminPage_Root            = 'ServerInformation_AdminPage';    // the root menu page slug
	// const AdminPage_Settings        = 'si_settings';    // the root menu page slug
	const AdminPage_Report          = 'si_report';    // the root menu page slug
    
    // const PostType_ = '';
	// const PostType_ImageGroup       = 'cfi_image_group';        // up to 20 characters
    
	// const Taxonomy_ = '';
	const RequiredPHPVersion        = '5.2.4';
	const RequiredWordPressVersion  = '3.5';
	    
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