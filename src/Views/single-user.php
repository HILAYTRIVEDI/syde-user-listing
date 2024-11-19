<div class="table-responsive">
    <table class="syde-user-listing-table" aria-describedby="user-table-desc">
        <caption id="user-table-desc">
            <?php echo esc_html__('Additional Data', 'syde-user-listing') ?>
        </caption>
        <thead>
            <?php
                $keys = array_keys($user_details);
                foreach ($keys as $key) {
                    echo '<th scope="col" data-label="' . esc_html($key) . '">' . esc_html(strtoupper($key)) . '</th>';
                }

            ?>
        </thead>
        <tbody>
            <tr class="user-row" data-user-id="<?php echo esc_attr($value) ?>">
                <?php
                    array_walk_recursive($user_details, function ($value, $key) { ?>
                        <td class="user-<?php esc_attr($key) ?>" data-label="<?php echo esc_attr($key) ?>">
                            <?php echo esc_html($value) ?>
                        </td>
                    <?php
                    });
                ?>
            </tr>
        </tbody>
    </table>
</div>