<ol class="syde-user-listing-table" aria-describedby="user-table-desc">
    <caption id="user-table-desc">
        <?php echo esc_html__('Additional Data', 'syde-user-listing') ?>
    </caption>
    <?php
    array_walk_recursive($user_details, function ($value, $key) { ?>
        <li class="user-<?php esc_attr($key) ?>" data-label="<?php echo esc_attr($key) ?>" data-value="<?php echo esc_attr($value) ?>">
            <span><?php echo esc_attr(strtoupper($key)) ?>:</span>
            <span><?php echo esc_attr($value) ?></span>
        </li>
    <?php
    });
    ?>
</ol>