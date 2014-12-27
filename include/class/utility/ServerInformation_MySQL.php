<?php
/**
 * A class that provides method to retrieve server infromation.
 * 
 * @package      Server Information
 * @copyright    Copyright (c) 2014, Michael Uno
 * @author       Michael Uno
 * @authorurl    http://michaeluno.jp
 * @since        1.1.0
 */
/**
 * Provides a method to retrieve MySQL information.
 * @since   1.1.0
 */
class ServerInformation_MySQL {

    static public function get(){

        global $wpdb;
        $_aVariables = array();
        $_aRows = $wpdb->get_results( "SHOW VARIABLES", ARRAY_A );

        $_aOutput = array();
        foreach( ( array ) $_aRows as $_iIndex => $_aItem ) {
            
            $_aItem     = array_values( $_aItem );
            $_sKey      = array_shift( $_aItem );
            $_sValue    = array_shift( $_aItem );
            $_aOutput[ $_sKey ] = $_sValue;
            
        }
        return $_aOutput;
        
    }

}