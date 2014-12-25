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
        
        $_oCurrentUser = wp_get_current_user();
        
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
                'description'       => __( 'Tell how the framework should work.', 'server-information' ),
                'attributes'        => array(
                    'required'  => 'required',
                ),
            ),  
            array( 
                'field_id'          => 'actual_result',
                'title'             => __( 'Actual Behavior', 'server-information' ),
                'type'              => 'textarea',
                'description'      => __( 'Describe the behavior of the framework.', 'server-information' ),
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
                'field_id'      => 'system_information',
                'type'          => 'system',     
                'title'         => __( 'System Information', 'server-information' ),
                'data'          => array(
                    // __( 'Custom Data', 'server-information' )    => __( 'This is custom data inserted with the data argument.', 'server-information' ),
                    // __( 'Current Time', 'admin-page-framework' )        => '', // Removes the Current Time Section.
                    __( 'Plugin', 'server-information' ) . ': ' . ServerInformation_Registry::Name => ServerInformation_Registry::getInfo(),
                    'PHPInfo'   => $this->_getPHPInfo(),
                )
                ,
                'attributes'    => array(
                    'rows'          =>  10,
                ),
                // 'hidden'        => true,
            ),           
            array( 
                'field_id'          => 'has_confirmed',
                'type'              => 'hidden',
                'hidden'            => true,
                'value'             => isset( $_GET['confirmation'] ),
            ),               
            array( 
                'field_id'          => 'allow_sending_system_information',
                'title'             => __( 'Confirmation', 'server-information' ),
                'type'              => 'checkbox',
                'hidden'            => ! isset( $_GET['confirmation'] ),
                'value'             => false,
                'label'             => __( 'I agree that the site information such as PHP version and WordPress version and the plugin options will be sent to the developer along with the message to help trouble-shoot the problem.', 'server-information' ),
                'attributes'        => array(
                    'required'  => isset( $_GET['confirmation'] ) ? 
                        'required'
                        : null,
                ),                
            ),          
            array( 
                'field_id'          => 'send',
                'type'              => 'submit',
                'label_min_width'   => 0,
                'value'             => isset( $_GET['confirmation'] )
                    ? __( 'Send', 'server-information' )
                    : __( 'Preview', 'server-information' ),
                'attributes'        => array(
                    'field' => array(
                        'style' => 'float:right; clear:none; display: inline;',
                    ),
                    'class' => isset( $_GET['confirmation'] )
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
     
        // Otherwise, process the data.
        return $aInput;        
        
    }   
    
    /**
     * Returns the PHP info as an array.
     */
    private function _getPHPInfo( $return=true ){
        
        /* Andale!  Andale!  Yee-Hah! */
        ob_start();
        phpinfo(-1);

        $pi = preg_replace(
        array('#^.*<body>(.*)</body>.*$#ms', '#<h2>PHP License</h2>.*$#ms',
        '#<h1>Configuration</h1>#',  "#\r?\n#", "#</(h1|h2|h3|tr)>#", '# +<#',
        "#[ \t]+#", '#&nbsp;#', '#  +#', '# class=".*?"#', '%&#039;%',
          '#<tr>(?:.*?)" src="(?:.*?)=(.*?)" alt="PHP Logo" /></a>'
          .'<h1>PHP Version (.*?)</h1>(?:\n+?)</td></tr>#',
          '#<h1><a href="(?:.*?)\?=(.*?)">PHP Credits</a></h1>#',
          '#<tr>(?:.*?)" src="(?:.*?)=(.*?)"(?:.*?)Zend Engine (.*?),(?:.*?)</tr>#',
          "# +#", '#<tr>#', '#</tr>#'),
        array('$1', '', '', '', '</$1>' . "\n", '<', ' ', ' ', ' ', '', ' ',
          '<h2>PHP Configuration</h2>'."\n".'<tr><td>PHP Version</td><td>$2</td></tr>'.
          "\n".'<tr><td>PHP Egg</td><td>$1</td></tr>',
          '<tr><td>PHP Credits Egg</td><td>$1</td></tr>',
          '<tr><td>Zend Engine</td><td>$2</td></tr>' . "\n" .
          '<tr><td>Zend Egg</td><td>$1</td></tr>', ' ', '%S%', '%E%'),
        ob_get_clean());

        $sections = explode('<h2>', strip_tags($pi, '<h2><th><td>'));
        unset($sections[0]);

        $pi = array();
        foreach($sections as $section){
           $n = substr($section, 0, strpos($section, '</h2>'));
           preg_match_all(
           '#%S%(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?%E%#',
             $section, $askapache, PREG_SET_ORDER);
           foreach($askapache as $m)
               $pi[$n][$m[1]]=(!isset($m[3])||$m[2]==$m[3])?$m[2]:array_slice($m,2);
        }

        return ($return === false) ? print_r($pi) : $pi;
        
    }
 
}

