<div class="wrap">
    <h1><?php

    declare(strict_types=1);

    echo esc_html__('API Endpoint Settings', 'text-domain'); ?></h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('api_endpoint_settings');
        do_settings_sections('api_endpoint_settings');
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php esc_html_e('API Endpoint URL', 'text-domain'); ?></th>
                <td>
                    <input type="url" name="api_endpoint_url" value="<?php echo esc_attr(get_option('api_endpoint_url')); ?>" class="regular-text">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e('API Endpoint Name', 'text-domain'); ?></th>
                <td>
                    <input type="text" name="api_endpoint_name" value="<?php echo esc_attr(get_option('api_endpoint_name')); ?>" class="regular-text">
                </td>
            </tr>
            <?php
                // additional_api_endpoint_fields hook to add additional fields.
                do_action('additional_api_endpoint_fields');
            ?>
        </table>
        <?php submit_button(); ?>
    </form>
</div>