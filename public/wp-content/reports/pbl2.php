<?php

// Initializing the WordPress engine in a stanalone PHP file
include('../../wp/wp-blog-header.php');
require_once('../../wp/wp-load.php');

// is_user_logged_in() ||  auth_redirect();

header("HTTP/1.1 200 OK"); // Forcing the 200 OK header as WP can return 404 otherwise

// // Preparing a WP_query
// $the_query = new WP_Query(
// array(
// 'post_type' => 'page', // We only want pages
// // 'post_parent' => 244, // We only want children of a defined post ID
// 'post_count' => -1 // We do not want to limit the post count
// // We can define any additional arguments that we need - see Codex for the full list
// )
// );

$return_array = array(); // Initializing the array that will be used for the table

$args = array(
    'meta_query' => array(
        'relation' => 'OR',
        array(
            'key'     => 'qualifications',
            'value'   => 'safetyboat',
            'compare' => 'LIKE',
        ),
        array(
            'key'     => 'qualifications',
            'value'   => 'Powerboat',
            'compare' => 'LIKE',
        ),
        array(
            'meta_key' => 'last_name',
            'orderby' => 'meta_value',
            'order' => 'DESC'
        ),
    ),
);

$user_query = new WP_User_Query( $args );

// if ( ! empty( $user_query->get_results() ) ) {
// 	foreach ( $user_query->get_results() as $user ) {
        
//         echo '<p>' . $user->first_name . '</p>';
//         echo '<p>' . $user->last_name . '</p>';
//         echo '<p>' . $user->telephone . '</p>';
//         echo '<p>' . $user->mobile . '</p>';
//         echo '<p>' . $user->user_email . '</p>';
//         echo '<p>' . implode(", ", $user->qualifications) . '</p>';
// 	}
// } else {
// 	echo 'No users found.';
// }

if ( ! empty( $user_query->get_results() ) ) {
    foreach ( $user_query->get_results() as $user ) {
        $return_array[] = array(
            'Firstname' => $user->first_name,
            'Lastname' => $user->last_name,
            'Email' => $user->user_email,
            'Telephone' => $user->telephone,
            'Mobile' => $user->mobile,
            'Qualfications' => implode(", ", $user->qualifications)
        );
    }
}

// var_dump($results);
// foreach ($results as $row) {
//     $return_array[] = array(
//         'Firstname' => $row->Email);
// }

// while( $the_query->have_posts() ){

// // Fetch the post
// $the_query->the_post();

// // Filling in the new array entry
// $return_array[] = array(
// 'Id' => get_the_id(), // Set the ID
// 'Title' => get_the_title(), // Set the title
// 'Content preview with link' => get_permalink().'||'.strip_tags( strip_shortcodes( substr( get_the_content(), 0, 200 ) ) ).'...'
// // Get first 200 chars of the content and replace the shortcodes and tags
// );

// }

// Now the array is prepared, we just need to serialize and output it
echo serialize( $return_array );

?>
