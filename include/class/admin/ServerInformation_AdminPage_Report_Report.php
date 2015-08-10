<?php
/**
 * Adds the Report tab to the Settings page of the plugin.
 * 
 * @package      Server Information
 * @copyright    Copyright (c) 2014, Michael Uno
 * @author       Michael Uno
 * @authorurl    http://michaeluno.jp
 * @since        0.0.1
 */
class ServerInformation_AdminPage_Report_Report {

    public $sPageSlug   = '';
    public $sTabSlug    = 'report';
    public $sSectionID  = 'report';

    /**
     * Sets up properties and hooks.
     * 
     * @since       0.0.1
     */
    public function __construct( $sPageSlug='', $sTabSlug='' ) {

        $this->sPageSlug    = $sPageSlug ? $sPageSlug : $this->sPageSlug;
        $this->sTabSlug     = $sTabSlug ? $sTabSlug : $this->sTabSlug;
        $this->sSectionID   = $this->sTabSlug;
 
        add_action( 
            "load_" . $this->sPageSlug . '_' . $this->sTabSlug, 
            array( $this, 'replyToLoadTab' ) 
        );
        
        add_action(
            "validation_" . $this->sPageSlug. '_' . $this->sTabSlug,
            array( $this, 'replyToValidateFormData' ),
            10,
            3
        );
       
    }
    
    /**
     * Triggered when the tab is loaded.
     * 
     * @since   0.0.1
     */
    public function replyToLoadTab( $oFactory ) {
        
        $_oCurrentUser  = wp_get_current_user();
        $_bIsConfirming = isset( $_GET['confirmation'] ) && 'email' === $_GET['confirmation'];
        
        $oFactory->addSettingSections(    
            $this->sPageSlug, // the target page slug
            array(
                'section_id'        => $this->sSectionID, // avoid hyphen(dash), dots, and white spaces
                'tab_slug'          => $this->sTabSlug,
                'title'             => __( 'Report', 'server-information' ),
            )
        );       
                
        $oFactory->addSettingFields(
            'report',
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
                'attributes'    => array(
                    'disabled'  => $_bIsConfirming
                        ? 'disabled' 
                        : null,
                ),
            ),
        // Start of System Information
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
                'if'            => ! $_bIsConfirming || $oFactory->getValue( 'report', 'select_iofo', '.client_info' )
                    ? true
                    : false,
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
                'if'            => ! $_bIsConfirming || $oFactory->getValue( 'report', 'select_iofo', '.wordpress_info' )
                    ? true
                    : false,
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
                'if'            => ! $_bIsConfirming || $oFactory->getValue( 'report', 'select_iofo', '.php_info' )
                    ? true
                    : false,
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
                'if'            => ! $_bIsConfirming || $oFactory->getValue( 'report', 'select_iofo', '.php_error_log' )
                    ? true
                    : false,
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
                'if'            => ! $_bIsConfirming || $oFactory->getValue( 'report', 'select_iofo', '.mysql_info' )
                    ? true
                    : false,
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
                'if'            => ! $_bIsConfirming || $oFactory->getValue( 'report', 'select_iofo', '.mysql_error_log' )
                    ? true
                    : false,                
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
                'if'            => ! $_bIsConfirming || $oFactory->getValue( 'report', 'select_iofo', '.web_server_info' )
                    ? true
                    : false,                
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
                'if'            => ! $_bIsConfirming || $oFactory->getValue( 'report', 'select_iofo', '.server_info_plugin_info' )
                    ? true
                    : false,                
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
                'if'            => ! $_bIsConfirming || $oFactory->getValue( 'report', 'select_iofo', '.framework_info' )
                    ? true
                    : false,                
                'class'         => array( 'fieldrow' => 'framework_info', ),                
                'hidden'        => true,
            ),                    
        // End of System Information
            array( 
                'field_id'          => 'has_confirmed',
                'type'              => 'hidden',
                'hidden'            => true,
                'value'             => $_bIsConfirming,
            ),               
            array( 
                'field_id'          => 'allow_sending_system_information',
                'title'             => __( 'Confirmation', 'server-information' ),
                'type'              => 'checkbox',
                'hidden'            => ! $_bIsConfirming,
                'value'             => false,
                'label'             => __( 'I agree that the site information such as PHP version and WordPress version and the plugin options will be sent to the developer along with the message to help trouble-shoot the problem.', 'server-information' ),
                'attributes'        => array(
                    'required'  => $_bIsConfirming
                        ? 'required'
                        : null,
                ),                
            ),          
            array( 
                'field_id'          => 'send',
                'type'              => 'submit',
                'label_min_width'   => 0,
                'value'             => $_bIsConfirming
                    ? __( 'Send', 'server-information' )
                    : __( 'Preview', 'server-information' ),
                'attributes'        => array(
                    'field' => array(
                        'style' => 'float:right; clear:none; display: inline;',
                    ),
                    'class' => $_bIsConfirming
                        ? null
                        : 'button-secondary',
                ),    
                'email'             => array(
                    // Each argument can accept a string or an array representing the dimensional array key.
                    // For example, if there is a field for the email title, and its section id is 'my_section'  and  the field id is 'my_field', pass an array, array( 'my_section', 'my_field' )
                    'to'            => '',
                    'subject'       => '',
                    'message'       => array( 'report' ), // the section name enclosed in an array. If it is a field, set it to the second element like array( 'seciton id', 'field id' ).
                    'headers'       => '',
                    'attachments'   => '', // the file path
                    'name'          => '', // The email sender name. If the 'name' argument is empty, the field named 'name' in this section will be applied
                    'from'          => '', // The sender email address. If the 'from' argument is empty, the field named 'from' in this section will be applied.
                    // 'is_html'       => true,
                ),
            ),     
            array()
        );        
    }
 
    /**
     * Validates the submitted data.
     * @since       0.0.1
     */
    public function replyToValidateFormData( $aInput, $aOldInput, $oFactory ) {
      
        // Local variables
        $_bIsValid = true;
        $_aErrors  = array();
        
        $_bHasConfirmed = isset( $aInput['report']['has_confirmed'] ) && $aInput['report']['has_confirmed'];
        
        if ( $_bHasConfirmed && ! $aInput['report']['allow_sending_system_information'] ) {
            $_bIsValid = false;
            $_aErrors['report']['allow_sending_system_information'] = __( 'We need necessary information to help you.', 'fetch-tweets' );
        }
        
        if ( ! $_bIsValid ) {
        
            $oFactory->setFieldErrors( $_aErrors );     
            $oFactory->setSettingNotice( __( 'Please help us to help you.', 'fetch-tweets' ) );        
            return $aOldInput;
            
        }     
        
        // Drop unchecked information.               
        foreach( ( array ) $aInput['report']['select_iofo'] as $_sInfoType => $_bChecked ) {
            if ( $_bChecked ) { continue; }
            $_sInfoType = ltrim( $_sInfoType, '.' );

            unset( $aInput['report'][ $_sInfoType ] );
        }
        
        // Otherwise, process the data.
        return $aInput;        
        
    }   
    

}

