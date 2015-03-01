<?php
/**
 Admin Page Framework v3.5.4b06 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class ServerInformation_AdminPageFramework_Script_Sortable extends ServerInformation_AdminPageFramework_Script_Base {
    protected function construct() {
        wp_enqueue_script('jquery-ui-sortable');
    }
    static public function getScript() {
        return <<<JAVASCRIPTS
(function($) {
    $.fn.enableAPFSortable = function( sFieldsContainerID ) {

        var _oTarget    = typeof sFieldsContainerID === 'string' 
            ? $( '#' + sFieldsContainerID + '.sortable' )
            : this;
        
        _oTarget.unbind( 'sortupdate' );
        _oTarget.unbind( 'sortstop' );
        var _oSortable  = _oTarget.sortable(
            { items: '> div:not( .disabled )', } // the options for the sortable plugin
        );
        _oSortable.bind( 'sortstop', function() {
         
            /* Callback the registered functions */
            $( this ).callBackStoppedSortingFields( 
                $( this ).data( 'type' ),
                $( this ).attr( 'id' ),
                0  // call type 0: fields, 1: sections
            );  
            
        });
        _oSortable.bind( 'sortupdate', function() {

            // Reverse is needed for radio buttons since they loose the selections when updating the IDs
            var _oFields = $( this ).children( 'div' ).reverse();
            _oFields.each( function( iIterationIndex ) { 

                var _iIndex = _oFields.length - iIterationIndex - 1;

                $( this ).setIndexIDAttribute( 'id', _iIndex );
                $( this ).find( 'label' ).setIndexIDAttribute( 'for', _iIndex );
                $( this ).find( 'input,textarea,select' ).setIndexIDAttribute( 'id', _iIndex );
                $( this ).find( 'input:not(.apf_checkbox),textarea,select' ).setIndexNameAttribute( 'name', _iIndex );
                $( this ).find( 'input.apf_checkbox' ).setIndexNameAttribute( 'name', _iIndex, -2 ); // for checkboxes, set the second found digit from the end                                       
                
                /* Radio buttons loose their selections when IDs and names are updated, so reassign them */
                $( this ).find( 'input[type=radio]' ).each( function() {    
                    var sAttr = $( this ).prop( 'checked' );
                    if ( 'undefined' !== typeof sAttr && false !== sAttr ) {
                        $( this ).attr( 'checked', 'checked' );
                    } 
                });
                    
            });
            
            /* It seems radio buttons need to be taken cared of again. Otherwise, the checked items will be gone. */
            $( this ).find( 'input[type=radio][checked=checked]' ).attr( 'checked', 'checked' );    
            
            /* Callback the registered functions */
            $( this ).callBackSortedFields( 
                $( this ).data( 'type' ),
                $( this ).attr( 'id' ),
                0  // call type 0: fields, 1: sections
            );
            
        });                 
    
    };
}( jQuery ));
JAVASCRIPTS;
        
    }
}