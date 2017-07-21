<?php
function dwwp_add_submenu_page() {
    add_submenu_page(
        'edit.php?post_type=job',// $parent_slug -  asking which parent top menu level we want it to be
        'Reorder Jobs',
        'Reorder Jobs', //$menu_title,
        'manage_options', //$capability -who can access this
        'reorder_jobs',
        'reorder_admin_jobs_callback' // function- that displays everything
    );
}
add_action('admin_menu', 'dwwp_add_submenu_page');

function reorder_admin_jobs_callback(){
    $args = array(
        'post_type' => 'job',
        'orderby'   => 'menu_order',
        'order'     => 'ASC', // ascending order
        'post_status' => 'publish', // shows only active posts
        'no_found_rows' => true, // WP runs 5 queries by default. when you create a new query, wp makes a secondary to count all the posts, so that he can do the pagination, we won't need it here, so we are going to cut this process off
        'update_post_term_cache' => false, // because we are not going to be using any taxonomy data
        'post_per_page' => 50, //limit the amount of posts   good advice https://10up.github.io/Engineering-Best-Practices/php/#performance

    ); // here we put all the parameters we want to query

    $job_listing = new WP_Query($args); // WP_Query -takes information from DB according to the arguments set
    ?>
     <div id="job-sort" class="wrap">  <!--wrap - wp class-->
         <div id="icon-job-admin" class="icon32"><br/></div>
         <h2><?php _e('Sort Jobs Positions', 'wp-job-listing') ?><img src="<?php echo esc_url(admin_url() . '/images/loading.gif')?>" id="loading-animation"></h2>   <!--_e() - localization function translation ready text, esc_url - securyti thing-->
            <?php if($job_listing->have_posts()) : ?>  <!--checks is there are any posts-->
                <p><?php _e('<strong>Note:</strong> this only affects the Jobs listed using the shortcode functions')?></p>
                <ul id="custom-type-list">
                    <?php while($job_listing->have_posts()) : $job_listing->the_post(); ?>
                        <li id="<?php esc_attr(the_id()); ?>"><?php esc_html(the_title()); ?></li>  <!--the_id() - gives the id of the post, the_title() - gives the title of the post-->
                    <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p><?php _e('You have no Jobs to sort', 'wp-job-listing') ?></p>
        <?php endif; ?>
        </div>
    <?php

}

function dwwp_save_reorder()
{

    if (!check_ajax_referer('wp-job-order', 'security')) {// first we have to pass the nonce name, that we created in wp-job-listing.php (wp-job-order)
// the second thing we need to pass is the variable name, with which we defined the nonce in reorder.js ajax (security)
        return wp_send_json_error('Invalid Nonce'); // if the nonce is not valid show error message
    }
    if (!current_user_can('manage_options')) {// current_user_can() - check if the person, that is trying to do smthing has access for that, manage_options - is the capability that administrator has, so we are checking if the user has the ability to manage options
        return wp_send_json_error('You are not allowed to do this.');
    }
    $order = $_POST['order']; // we are saving ajax element order (with array of id's) in $order variable
    $counter = 0;

    foreach($order as $item_id) {
        $post = array(
            'ID' => (int)$item_id, // (int) - makes the id that is being passed an integer
            'menu_order' => $counter
        );
        wp_update_post($post);
        $counter++; // every loop it adds +1 to counter
    }
    wp_send_json_success('Post Saved.');
}
add_action('wp_ajax_save_sort', 'dwwp_save_reorder'); // we are using a dynamic hook: always starts with wp_ajax and adds the string that is defined ir reorder.js ajax function at action (save_sort)