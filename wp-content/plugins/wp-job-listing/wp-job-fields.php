<?php

function dwwp_add_custom_metabox() {
    add_meta_box(
        'dwwp_meta',
        'Job Listing',
        'dwwp_meta_callback', // what should fill the metabox
        null, // screens on which to show the box
        'normal', // where should metabox be (center or side)
        'core'// how high should the metabox be
    );
}
add_action('add_meta_boxes', 'dwwp_add_custom_metabox');

function dwwp_meta_callback($post) {
    wp_nonce_field(basename(__FILE__), 'dwwp_jobs_nonce'); // nonce - number used once, security for data being saved in db (ensures, that data is coming from the site and not somewhere else)
    $dwwp_stored_meta = get_post_meta($post->ID);

    ?>

    <div>
        <div class="meta-row">
            <div class="meta-th">
                <label for="job_id" class="dwwp-row-title">Job ID</label>
            </div>
            <div class="meta-td">
                <input type="text" name="job_id" id="job_id" value="<?php if(!empty($dwwp_stored_meta['job_id'])) echo esc_attr($dwwp_stored_meta['job_id'][0]); ?>"/>  <!--if this is not empty, insert from db-->
            </div>
        </div>
        <div class="meta-row">
            <div class="meta-th">
                <label for="date_listed" class="dwwp-row-title">Date Listed</label>
            </div>
            <div class="meta-td">
                <input type="text" name="date_listed" id="date_listed" value="<?php if(!empty($dwwp_stored_meta['date_listed'])) echo esc_attr($dwwp_stored_meta['date_listed'][0]); ?>"/>
            </div>
        </div>
        <div class="meta-row">
            <div class="meta-th">
                <label for="application_deadline" class="dwwp-row-title">Application Deadline</label>
            </div>
            <div class="meta-td">
                <input type="text" name="application_deadline" id="application_deadline" value="<?php if(!empty($dwwp_stored_meta['application_deadline'])) echo esc_attr($dwwp_stored_meta['application_deadline'][0]); ?>"/>
            </div>
        </div>
        <div class="meta">
            <div class="meta-th">
                <span>Principle Duties</span>
            </div>
        </div>
        <div class="meta-editor"></div>
    <?php
    $content = get_post_meta(get_the_ID(), 'principle_duties', true);
    $editor = 'principle_duties';
    $settings = array(
        'textarea_rows' => 8,
        'media_buttons' => true,
    );
    wp_editor($content, $editor, $settings);

    ?>
    </div>
    <div class="meta-row">
        <div class="meta-th">
            <label for="minimum-requirements" class="wpdt-row-title"><?php _e( 'Minimum Requirements', 'hrm-textdomain' )?></label>
        </div>
        <div class="meta-td">
            <textarea name="minimum-requirements" class ="hrm-textarea" id="minimum-requirements"><?php if ( isset ( $hrm_stored_meta['minimum-requirements'] ) ) echo esc_attr( $hrm_stored_meta['minimum-requirements'][0] ); ?></textarea>
        </div>
    </div>
    <div class="meta-row">
        <div class="meta-th">
            <label for="preferred-requirements" class="wpdt-row-title"><?php _e( 'Preferred Requirements', 'hrm-textdomain' )?></label>
        </div>
        <div class="meta-td">
            <textarea name="preferred-requirements" class ="hrm-textarea" id="preferred-requirements"><?php if ( isset ( $hrm_stored_meta['preferred-requirements'] ) ) echo esc_attr( $hrm_stored_meta['preferred-requirements'][0] ); ?></textarea>
        </div>
    </div>
    <div class="meta-row">
        <div class="meta-th">
            <label for="relocation-assistance" class="prfx-row-title"><?php _e( 'Relocation Assistance', 'hrm-textdomain' )?></label>
        </div>
        <div class="meta-td">
            <select name="relocation-assistance" id="relocation-assistance">
                <option value="select-yes">Yes</option>';
                <option value="select-no">No</option>';
            </select>
        </div>
    </div>
    <?php
}
function dwwp_meta_save($post_id) {

    $is_autosave = wp_is_post_autosave($post_id); // checks if a post is autosave
    $is_revision = wp_is_post_revision($post_id); //Determines if the specified post is a revision.
    $is_valid_nonce = (isset($_POST['dwwp_jobs_nonce']) && wp_verify_nonce($_POST['dwwp_jobs_nonce'], basename(__FILE__))) ? 'true' : 'false';


    if($is_autosave || $is_revision || !$is_valid_nonce) {
        return; // if any of the conditions are true, don't do anything
    }
    if (isset($_POST['job_id'])) { // if there is something in job_id, update it to database
        update_post_meta($post_id, 'job_id', sanitize_text_field($_POST['job_id'])); // - safety matter - santize_text_field - Checks for invalid UTF-8, Converts single < characters to entities, Strips all tags, Removes line breaks, tabs, and extra whitespace, Strips octets
    }
    if (isset($_POST['date_listed'])) {
        update_post_meta($post_id, 'date_listed', sanitize_text_field($_POST['date_listed']));
    }
    if (isset($_POST['application_deadline'])) {
        update_post_meta($post_id, 'application_deadline', sanitize_text_field($_POST['application_deadline']));
    }
    if (isset($_POST['principle_duties'])) {
        update_post_meta($post_id, 'principle_duties', sanitize_text_field($_POST['principle_duties']));
    }
}
add_action('save_post', 'dwwp_meta_save');

