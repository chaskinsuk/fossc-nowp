<?php

// Initializing the WordPress engine in a stanalone PHP file
include('../../wp/wp-blog-header.php');
require_once('../../wp/wp-load.php');

// is_user_logged_in() ||  auth_redirect();

// $array = array(
//     'boat1' => array(
//         'sail_number' => '12345',
//         'boat_name' => 'name',
//         'boat_class' => 'class',
//         'berth' => 'k28',
//     ),
//     'boat2' => array(
//         'sail_number' => '6789',
//         'boat_name' => 'name',
//         'boat_class' => 'class',
//         'berth' => 'k27',
//     )
// );
// echo serialize( $array );
// die;
header("HTTP/1.1 200 OK"); // Forcing the 200 OK header as WP can return 404 otherwise

// Preparing a WP_query
$return_array = array(); // Initializing the array that will be used for the table

$args = array(
    'meta_query' => array(
//         'relation' => 'OR',
//         array(
//             'key'     => 'qualifications',
//             'value'   => 'safetyboat',
//             'compare' => 'LIKE',
//         ),
//         array(
//             'key'     => 'qualifications',
//             'value'   => 'Powerboat',
//             'compare' => 'LIKE',
//         ),
        array(
            'meta_key' => 'last_name',
            'orderby' => 'meta_value',
            'order' => 'DESC'
        ),
    ),
);

$user_query = new WP_User_Query( $args );
if ( ! empty( $user_query->get_results() ) ) {
    foreach ( $user_query->get_results() as $user ) {
        if (is_array($user->boats)) {
            $boats = $user->boats;
            foreach ($boats as $boat) {
                $return_array[] = array(
                    'Firstname' => $user->first_name,
                    'Lastname' => $user->last_name,
                    'Email' => $user->user_email,
                    'Telephone' => $user->telephone,
                    'Mobile' => $user->mobile,
                    'Sail_No.' => $boat['sail_number'],
                    'Boat_Name' => $boat['boat_name'],
                    'Boat_Class' => $boat['boat_class'],
                    'Berth' => $boat['berth']

                );
            }
        } else {
            $return_array[] = array(
                'Firstname' => $user->first_name,
                'Lastname' => $user->last_name,
                'Email' => $user->user_email,
                'Telephone' => $user->telephone,
                'Mobile' => $user->mobile,
                'Sail_No.' => '',
                'Boat_Name' => '',
                'Boat_Class' => '',
                'Berth' => ''
            );
        }
    }
}

// Now the array is prepared, we just need to serialize and output it
echo serialize( $return_array );

?>
