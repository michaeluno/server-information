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
 * Provides a method to retrieve PHP information.
 * @since   1.1.0
 */
class ServerInformation_PHP {

    static public function get(){
        
        $_aConstants = self::getDefinedConstants();
        unset( $_aConstants['user'] );
        return self::getPHPInfo()
            + array( 'Constants' => $_aConstants )
        ;
            
        
    }
    
    /**
     * Returns an array of constants.
     * 
     * @param       string      $sCategory      The category key name of the returning array.
     */
    static public function getDefinedConstants( $sCategory=null ) {
        
        $_aConstants = get_defined_constants( true );
        if ( ! $sCategory ) {
            return $_aConstants;
        }
        
        return isset( $_aConstants[ $sCategory ] )
            ? $_aConstants[ $sCategory ]
            : array();
        
    }
    
    static public function getPHPInfo() {

        ob_start();
        phpinfo( -1 );

        $_sOutput = preg_replace(
            array(
                '#^.*<body>(.*)</body>.*$#ms', '#<h2>PHP License</h2>.*$#ms',
                '#<h1>Configuration</h1>#',  "#\r?\n#", "#</(h1|h2|h3|tr)>#", '# +<#',
                "#[ \t]+#", '#&nbsp;#', '#  +#', '# class=".*?"#', '%&#039;%',
                '#<tr>(?:.*?)" src="(?:.*?)=(.*?)" alt="PHP Logo" /></a>'
                    .'<h1>PHP Version (.*?)</h1>(?:\n+?)</td></tr>#',
                '#<h1><a href="(?:.*?)\?=(.*?)">PHP Credits</a></h1>#',
                '#<tr>(?:.*?)" src="(?:.*?)=(.*?)"(?:.*?)Zend Engine (.*?),(?:.*?)</tr>#',
                "# +#",
                '#<tr>#',
                '#</tr>#'
            ),
            array(
                '$1', '', '', '', '</$1>' . "\n", '<', ' ', ' ', ' ', '', ' ',
                '<h2>PHP Configuration</h2>'."\n".'<tr><td>PHP Version</td><td>$2</td></tr>'.
                "\n".'<tr><td>PHP Egg</td><td>$1</td></tr>',
                '<tr><td>PHP Credits Egg</td><td>$1</td></tr>',
                '<tr><td>Zend Engine</td><td>$2</td></tr>' . "\n" . '<tr><td>Zend Egg</td><td>$1</td></tr>',
                ' ',
                '%S%',
                '%E%'
            ),
            ob_get_clean()
        );

        $_aSections = explode( '<h2>', strip_tags( $_sOutput, '<h2><th><td>' ) );
        unset( $_aSections[ 0 ] );

        $_aOutput = array();
        foreach( $_aSections as $_sSection ) {
            $_iIndex = substr( $_sSection, 0, strpos( $_sSection, '</h2>' ) );
            preg_match_all(
                '#%S%(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?%E%#',
                $_sSection, 
                $_aAskApache, 
                PREG_SET_ORDER
            );
            foreach( $_aAskApache as $_aMatches ) {
                if ( ! isset( $_aMatches[ 1 ], $_aMatches[ 2 ] ) ) {
                    array_slice( $_aMatches, 2 );
                    continue;
                }
                $_aOutput[ $_iIndex ][ $_aMatches[ 1 ] ] = ! isset( $_aMatches[ 3 ] ) || $_aMatches[ 2 ] == $_aMatches[ 3 ]
                    ? $_aMatches[ 2 ] 
                    : array_slice( $_aMatches, 2 );
            }
        }        
        
        return $_aOutput;   
        
    }

}