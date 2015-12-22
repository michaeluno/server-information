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
class ServerInformation_Formfields_Email {
    
    /**
     * @since       1.2.0
     * @return      array
     */
    public function get() {

        return array(
            array( 
                'field_id'          => 'allow_sending_system_information',
                'title'             => __( 'Confirmation', 'server-information' ),
                'type'              => 'checkbox',
                'value'             => false,
                'label'             => __( 'I agree that the site information such as PHP version and WordPress version and the plugin options will be sent to the developer along with the message to help trouble-shoot the problem.', 'server-information' ),
                'attributes'        => array(
                    'required'  => 'required',
                ),                
            ),          
            array( 
                'field_id'          => 'send',
                'type'              => 'submit',
                'label_min_width'   => 0,
                'value'             => __( 'Send', 'server-information' ),
                'attributes'        => array(
                    'field' => array(
                        'style' => 'float:right; clear:none; display: inline;',
                    ),
                ),    
                'skip_confirmation' => true,
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
    
        );
    
    }
    
}
