<?php
if ( !function_exists('rsw_select_html') ) {

    /**
     * @param  $name name and id property of the select element
     * @param  $data associative array of option values and text
     * @param  $instance
     * @return string
     */
    function rsw_select_html($name, $data, $instance){

        $options = array();
        foreach ( $data as $value => $text ) {
            $options[] = sprintf('<option value="%s" %s>%s</option>', $value, selected( $instance[$name], $value, false ), __($text, 'reuters-stock-widgets'));
        }

        return sprintf('<select id="%s" name="%s">%s</select>',$name, $name, join($options, "\n"));

    }

}
 
