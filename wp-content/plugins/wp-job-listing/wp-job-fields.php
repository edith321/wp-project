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

function dwwp_meta_callback() {
    ?>

    <div>
        <div class="meta-row">
            <div class="meta-th">
                <label for="job-id" class="dwwp-row-title">Job ID</label>
            </div>
            <div class="meta-td">
                <input type="text" name="job-id" id="job-id" value=""/>
            </div>
        </div>
        <div class="meta-row">
            <div class="meta-th">
                <label for="date_listed" class="dwwp-row-title">Date Listed</label>
            </div>
            <div class="meta-td">
                <input type="text" name="date_listed" id="date_listed" value=""/>
            </div>
        </div>
        <div class="meta-row">
            <div class="meta-th">
                <label for="application_deadline" class="dwwp-row-title">Application Deadline</label>
            </div>
            <div class="meta-td">
                <input type="text" name="application_deadline" id="application_deadline" value=""/>
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

