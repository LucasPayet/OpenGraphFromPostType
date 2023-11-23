<?php
/*
* Plugin Name: OpenGraphFromPostType
* Plugin URI: #
* Description: This will include my custom codes
* Version: 0.1
* Author: PAYET Lucas
*/

// Hook into the wp_head action
add_action('wp_head', 'custom_post_head_info');

function custom_post_head_info() {
    function custom_post_head_info() {
        // Check if it's a single post and the post type is your custom post type
        if (is_single() && get_post_type() === 'album') {
            // Get the terms from the taxonomy
            $terms = get_the_terms(get_the_ID(), 'your_taxonomy');
    
            // Check if terms are available
            if ($terms && !is_wp_error($terms)) {
                // Loop through terms and add them to the <head> section
                foreach ($terms as $term) {
                    echo '<meta name="custom_taxonomy_info" content="' . esc_attr($term->name) . '">';
                }
            }
        }
    }
}