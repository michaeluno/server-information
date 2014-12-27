<?php
/**
 * A class that provides method to retrieve server information.
 * 
 * @package      Server Information
 * @copyright    Copyright (c) 2014, Michael Uno
 * @author       Michael Uno
 * @authorurl    http://michaeluno.jp
 * @since        1.1.0
 */
/**
 * Provides a method to retrieve the user browser (client) information.
 * @since   1.1.0
 */
class ServerInformation_Client {

    static public function get(){
        
        if ( ! class_exists( 'Browser' )  ) {
            include( ServerInformation_Registry::$sDirPath . '/include/library/server-information-browser.php' );
        }
        $_oBrowser = new Browser;
        $_aInfo = array(
            'User Agent'        => $_oBrowser->getUserAgent(),
            'Platform'          => $_oBrowser->getPlatform(),
            'Browser'           => $_oBrowser->getBrowser(),
            'Browser Version'   => $_oBrowser->getVersion(),
        );
        return $_aInfo;
        
    }
     
}