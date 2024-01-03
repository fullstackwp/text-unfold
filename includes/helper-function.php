<?php
function fswp_validate_heading_tag( $tag )
{
    $allowed_html_tags = [
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
    ];
    return ( in_array( strtolower( $tag ), $allowed_html_tags ) ? $tag : 'h3' );
}