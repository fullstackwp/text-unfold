<?php
/**
 * Widget Text Unfold For Elementor Helper Functions
 */

/** @param $tag  string                           
 *  @return string  
 */  
if( ! function_exists( 'FSWP_validate_heading_tag' ) ):
    function FSWP_validate_heading_tag($tag)
    {
        $allowed_html_tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
        $lowercased_tag = strtolower($tag);

        return in_array($lowercased_tag, $allowed_html_tags) ? $tag : 'h3';
    }
endif;
