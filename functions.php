

































































// Meta box code


function my_custom_meta_box() {
    add_meta_box(
        'my_meta_box_id',         // Unique ID for the meta box
        'Author Name',      // Title of the meta box
        'my_meta_box_callback',    // Callback function to display the content of the meta box
        'page',                    // Post type where the meta box should appear (e.g., 'post', 'page')
        'side',                    // Context ('normal', 'side', or 'advanced')
        'high'                     // Priority ('default', 'high', 'low')
    );
}

add_action('add_meta_boxes', 'my_custom_meta_box');

function my_meta_box_callback( $post ) {
    // Retrieve an existing value from the post meta (optional)
    $meta_value = get_post_meta( $post->ID, 'author_name_key', true );
    
    // Output a nonce field for security
    wp_nonce_field( 'my_author_box_nonce', 'my_author_nonce_field' );

    // Output the form field
    ?>
    <label for="author_name">Enter Author Name:</label>
    <input type="text" name="author_name" id="my_meta_box_field" value="<?php echo esc_attr( $meta_value ); ?>" />
    <?php
}


function save_my_meta_box_data( $post_id ) {
    // Check for nonce security
    if ( ! isset( $_POST['my_author_nonce_field'] ) ||
         ! wp_verify_nonce( $_POST['my_author_nonce_field'], 'my_author_box_nonce' ) ) {
        return $post_id;
    }
    // Save the meta field value
    if ( isset( $_POST['author_name'] ) ) {
        $meta_value = sanitize_text_field( $_POST['author_name'] );
        update_post_meta( $post_id, 'author_name_key', $meta_value );
    }
}


add_action( 'save_post', 'save_my_meta_box_data' );

// End Meta box code
