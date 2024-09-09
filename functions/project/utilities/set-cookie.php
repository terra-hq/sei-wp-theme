<?php
/**
 * Set a cookie via AJAX.
 * 
 * This function sets a cookie named 'SEICookie' with a value of "1" that expires in 7 days.
 * It is accessible to both logged-in users and guests.
 * 
 * @author Eli
 */
add_action('wp_ajax_nopriv_set_cookie', 'set_cookie'); // For non-logged-in users.
add_action('wp_ajax_set_cookie', 'set_cookie'); // For logged-in users.

/**
 * Handles the setting of a cookie and returns a JSON response.
 * 
 * This function sets a cookie with the name 'SEICookie', a value of "1", and an expiration time of 7 days.
 * It sends a JSON response indicating the success of the operation.
 */
function set_cookie() {
    // Set the cookie to expire in 7 days.
    setcookie('SEICookie', "1", time() + (60 * 60 * 24 * 7), '/');
    
    // Prepare the response array.
    $response = array(
        'result' => true,
        'message' => 'Cookie was set successfully'
    );
    
    // Output the JSON-encoded response.
    echo json_encode($response);
    
    // Terminate the script to ensure no additional output.
    die();
}
?>
