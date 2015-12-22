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
class ServerInformation_Formfields_User {
    
    /**
     * @since       1.2.0
     * @return      array
     */
    public function get() {
        
        $_oCurrentUser  = wp_get_current_user();
        return array(
            array( 
                'field_id'          => 'name',
                'title'             => __( 'Your Name', 'server-information' ),
                'type'              => 'text',
                'default'           => $_oCurrentUser->user_firstname || $_oCurrentUser->user_firstname 
                    ? $_oCurrentUser->user_lastname . ' ' .  $_oCurrentUser->user_lastname 
                    : '',
                'attributes'        => array(
                    'required'      => 'required',
                    'placeholder'   => __( 'Type your name.', 'admin-page-framewrok-demo' ),
                ),
            ),    
            array( 
                'field_id'          => 'from',
                'title'             => __( 'Your Email Address', 'server-information' ),
                'type'              => 'text',
                'default'           => $_oCurrentUser->user_email,
                'attributes'        => array(
                    'required'      => 'required',
                    'placeholder'   =>  __( 'Type your email that the developer replies backt to.', 'server-information' )
                ),
            ),     
            array( 
                'field_id'          => 'to',
                'title'             => __( 'Email Address to Send', 'server-information' ),
                'type'              => 'text',
                'attributes'        => array(
                    'required'      => 'required',
                    'placeholder'   =>  __( 'Type the email to send.', 'server-information' ),
                ),
            ),    
            array( 
                'field_id'          => 'subject',
                'title'             => __( 'Subject', 'server-information' ),
                'type'              => 'text',
                'attributes'        => array(
                    'placeholder'   =>  __( 'Type the title.', 'server-information' ),
                ),
            ),               
            array( 
                'field_id'          => 'expected_result',
                'title'             => __( 'Expected Behavior', 'server-information' ),
                'type'              => 'textarea',
                'description'       => __( 'Tell how your program should work.', 'server-information' ),
                'attributes'        => array(
                    'required'  => 'required',
                ),
            ),  
            array( 
                'field_id'          => 'actual_result',
                'title'             => __( 'Actual Behavior', 'server-information' ),
                'type'              => 'textarea',
                'description'      => __( 'Describe the behavior of your program.', 'server-information' ),
                'attributes'        => array(
                    'required'  => 'required',
                ),                
            ),     
            array(
                'field_id'          => 'attachments',
                'title'             => __( 'Screenshots', 'server-information' ),
                'type'              => 'image',
                'repeatable'        => true,
                'attributes'        => array(
                    'size'  => 40,
                    'preview' => array(
                        'style' => 'max-width: 200px;'
                    ),
                ),                                
            ),               
            array(
                'field_id'      => 'select_iofo',
                'type'          => 'revealer',
                'title'         => __( 'Select Information Types', 'server-information' ),
                'select_type'   => 'checkbox',
                'label'         => array(
                    '.client_info'              => __( 'Client', 'server-information' ),
                    '.wordpress_info'           => 'WordPress',
                    '.php_info'                 => 'PHP',
                    '.php_error_log'            => __( 'PHP Errors', 'server-information' ),
                    '.mysql_info'               => 'MySQL',
                    '.mysql_error_log'          => __( 'MySQL Errors', 'server-information' ),
                    '.web_server_info'          => __( 'Web Server', 'server-information' ),
                    '.server_info_plugin_info'  => __( 'Plugin', 'server-information' ) . ': '. ServerInformation_Registry::NAME,
                    '.framework_info'           => 'Admin Page Framework',
                ),
                'default'       => array(
                    '.client_info'              => true,
                    '.wordpress_info'           => true,
                    '.php_info'                 => true,
                    '.php_error_log'            => true,
                    '.mysql_info'               => true,
                    '.mysql_error_log'          => true,
                    '.web_server_info'          => true,
                    '.server_info_plugin_info'  => true,
                    '.framework_info'           => true,
                ),
            ),
        );
    
    }
    
}
