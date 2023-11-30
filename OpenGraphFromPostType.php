<?php
/*
* Plugin Name: Myjob Custom OG Tags
* Plugin URI: #
* Description: Add OpenGraph Meta tags
* Version: 0.1
* Author: PAYET Lucas
*/

function corrected_employer_name($employer_name){
    if (is_string($employer_name)){
        $search = array('@', ' Nord', ' INSERTION', ' SUD', ' Search', ' Santé');
        $correct_name = str_replace($search, '', $employer_name);

        // Check if the resulting string is not empty
        if (!empty($correct_name)) {
            return $correct_name;
        } else {
            return 'empty string after correction';
        }
    } else {
        $correct_name = 'not a string';
        return $correct_name;
    }
}

function custom_post_type_og() {
    global $post;
    if ($post->post_type === 'job') {
        $post_id = $post->ID;
        // og image
        $post_thumbnail_id = jobsearch_job_get_profile_image($post_id);
        $post_thumbnail_image = wp_get_attachment_image_src($post_thumbnail_id, 'jobsearch-job-medium');
        $post_thumbnail_src = isset($post_thumbnail_image[0]) && esc_url($post_thumbnail_image[0]) != '' ? $post_thumbnail_image[0] : '';
        $post_thumbnail_src = $post_thumbnail_src == '' ? jobsearch_no_image_placeholder() : $post_thumbnail_src;
        $post_thumbnail_src = apply_filters('jobsearch_jobemp_image_src', $post_thumbnail_src, $job_id);
        //og title
        $job_title = jobsearch_esc_html(force_balance_tags(get_the_title()));
        //og company
        $company_name = jobsearch_job_get_company_name($post_id, '@');
        // //og Zone
        // $get_job_location = get_post_meta($post_id, 'jobsearch_field_location_address', true)
        //og url
        global $wp;
        $current_url = home_url( add_query_arg( array(), $wp->request ) );
        echo '<!-- Custom OpenGraph Meta by Lucas start -->';
        echo '<meta property="og:title" content="' . apply_filters('jobsearch_jobdetail_title_text', $job_title, $job_id, 'detail_view1') . '">';
        echo '<meta property="og:image" content="' . esc_url($post_thumbnail_src) . '">';
        echo '<meta property="og:url" content="' . esc_url($current_url) . '">';
        echo '<meta property="og:description" content="Offre d\'emploi proposée par ' . corrected_employer_name(jobsearch_esc_html(force_balance_tags($company_name))) . ' !">';
        echo '<!-- Custom OpenGraph Meta by Lucas end -->';
    }
}
// Hook into the wp_head action
add_action('wp_head', 'custom_post_type_og');