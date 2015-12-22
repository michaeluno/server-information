<?php
/**
 * Server Information
 * 
 * @package      Server Information
 * @copyright    Copyright (c) 2014-2015, Michael Uno
 * @author       Michael Uno
 * @authorurl    http://michaeluno.jp
 */

/**
 * Returns form fields.
 * 
 * @since        1.2.0
 */
class ServerInformation_Formfields_ServerInformation {
    
    /**
     * @since       1.2.0
     * @return      array
     */
    public function get() {
        
        return array(
   
            array(
                'field_id'      => 'client_info',
                'type'          => 'system',     
                'title'         => __( 'Client', 'server-information' ),
                'data'          => array(
                    'Admin Page Framework'   => '',
                    'WordPress'              => '',
                    'Server'                 => '',
                    'PHP'                    => '',
                    'PHP Error Log'          => '',
                    'MySQL'                  => '',
                    'MySQL Error Log'        => '',
                    'Client'                 => ServerInformation_Client::get(),
                    // 'Browser'                => '',
                ),
                'attributes'    => array( 
                    'rows'      =>  10, 
                    'readonly'  => 'readonly',
                ),
                'class'         => array( 'fieldrow' => 'client_info', ),                
                'hidden'        => true,
            ),                   
            array(
                'field_id'      => 'wordpress_info',
                'type'          => 'system',     
                'title'         => 'WordPress',
                'data'          => array(
                    'Admin Page Framework'  => '',
                    'Server'                => '',
                    'PHP'                   => '',
                    'PHP Error Log'         => '',
                    'MySQL'                 => '',
                    'MySQL Error Log'       => '',
                    'Browser'               => '',
                ),
                'attributes'    => array( 
                    'rows'      =>  10, 
                ),
                'class'         => array( 'fieldrow' => 'wordpress_info', ),                
                'hidden'        => true,
            ),        
            array(
                'field_id'      => 'php_info', 
                'type'          => 'system',     
                'title'         => 'PHP',
                'data'          => array(
                    'WordPress'             => '',
                    'Admin Page Framework'  => '',
                    'Server'                => '',
                    // 'PHP'                   => '',                    
                    'PHP Error Log'         => '',
                    'MySQL'                 => '',
                    'MySQL Error Log'       => '',
                    'Browser'               => '',
                ),
                'attributes'    => array( 
                    'rows'      =>  10, 
                    'readonly'  => 'readonly',
                ),
                'class'         => array( 'fieldrow' => 'php_info', ),                
                'hidden'        => true,
            ),      
            array(
                'field_id'      => 'php_error_log',  
                'type'          => 'system',     
                'title'         => __( 'PHP Error Log', 'server-information' ),
                'data'          => array(
                    'WordPress'             => '',
                    'Admin Page Framework'  => '',
                    'Server'                => '',
                    'PHP'                   => '',                       
                    'MySQL'                 => '',
                    'MySQL Error Log'       => '',                    
                    'Browser'               => '',
                ),
                'attributes'    => array( 
                    'rows'      =>  10, 
                    'readonly'  => 'readonly',
                ),
                'class'         => array( 'fieldrow' => 'php_error_log', ),                
                'hidden'        => true,
            ),             
            array(
                'field_id'      => 'mysql_info',
                'type'          => 'system',     
                'title'         => 'MySQL',
                'data'          => array(
                    'WordPress'             => '',
                    'Admin Page Framework'  => '',
                    'Server'                => '',
                    'PHP'                   => '',
                    'PHP Error Log'         => '',
                    'MySQL Error Log'       => '',                    
                    'Browser'               => '',
                ),
                'attributes'    => array( 
                    'rows'      =>  10, 
                    'readonly'  => 'readonly',
                ),
                'class'         => array( 'fieldrow' => 'mysql_info', ),                
                'hidden'        => true,
            ),  
            array(
                'field_id'      => 'mysql_error_log',
                'type'          => 'system',     
                'title'         => __( 'MySQL Error Log', 'server-information' ),
                'data'          => array(
                    'WordPress'             => '',
                    'Admin Page Framework'  => '',
                    'Server'                => '',
                    'PHP'                   => '',
                    'PHP Error Log'         => '',
                    'MySQL'                 => '',                    
                    'Browser'               => '',
                ),
                'attributes'    => array( 
                    'rows'      =>  10, 
                ),             
                'class'         => array( 'fieldrow' => 'mysql_error_log', ),                
                'hidden'        => true,
            ),                
            array(
                'field_id'      => 'web_server_info',
                'type'          => 'system',     
                'title'         => __( 'Web Server', 'server-information' ),
                'data'          => array(
                    'WordPress'             => '',
                    'Admin Page Framework'  => '',
                    'PHP'                   => '',
                    'PHP Error Log'         => '',
                    'MySQL'                 => '',
                    'MySQL Error Log'       => '',       
                    'Browser'               => '',                    
                ),
                'attributes'    => array( 
                    'rows'      =>  10, 
                ),             
                'class'         => array( 'fieldrow' => 'web_server_info', ),                
                'hidden'        => true,
            ),            
            array(
                'field_id'      => 'server_info_plugin_info',
                'type'          => 'system',     
                'title'         => __( 'Plugin', 'server-information' ),
                'data'          => array(
                    'WordPress'             => '',
                    'Admin Page Framework'  => '',
                    'Server'                => '',
                    'PHP'                   => '',
                    'PHP Error Log'         => '',
                    'MySQL'                 => '',
                    'MySQL Error Log'       => '',                    
                    __( 'Plugin', 'server-information' ) . ': ' . ServerInformation_Registry::NAME => ServerInformation_Registry::getInfo(),
                    'Browser'               => '',
                ),
                'attributes'    => array( 
                    'rows'      =>  10, 
                ),
                // 'if'            => ! $_bIsConfirming || $oFactory->getValue( 'report', 'select_iofo', '.server_info_plugin_info' )
                    // ? true
                    // : false,                
                'class'         => array( 'fieldrow' => 'server_info_plugin_info', ),                
                'hidden'        => true,
            ),       
            array(
                'field_id'      => 'framework_info',
                'type'          => 'system',     
                'title'         => __( 'Admin Page Framework', 'server-information' ),
                'data'          => array(                   
                    'WordPress'             => '',
                    'Server'                => '',
                    'PHP'                   => '',
                    'PHP Error Log'         => '',                    
                    'MySQL'                 => '',
                    'MySQL Error Log'       => '',
                    'Browser'               => '',
                ),
                'attributes'    => array( 
                    'rows'      =>  10, 
                ),           
                'class'         => array( 'fieldrow' => 'framework_info', ),                
                'hidden'        => true,
            ),                        
        );
    
    }
    
}
