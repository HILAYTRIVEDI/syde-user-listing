<div class="table-responsive">
    <table class="syde-user-listing-table" aria-describedby="user-table-desc">
        <caption id="user-table-desc">
            A list of users with their ID, username, and email address.
        </caption>
        <thead>
            <?php

            declare(strict_types=1);

            // Prepare column headers dyamically from the response keys and only first 4 keys.
            $keys = array_slice(array_keys($users[0]), 0, 4);
            foreach ($keys as $key) {
                echo '<th scope="col" data-label="' . esc_html($key) . '">' . esc_html(strtoupper($key)) . '</th>';
            }

            ?>
        </thead>
        <tbody>
            <?php
            // Prepare the rows from the response.
            foreach ($users as $key => $user) { ?>
                <tr class="user-row" data-user-id="<?php echo esc_attr($user['id']) ?>">
                    <td class="user-<?php echo esc_attr($key) ?>" data-label="<?php echo esc_attr($key) ?>">
                        <a href="#" class="user-link" data-user-id="<?php echo esc_attr($user['id']) ?>">
                            <?php echo esc_attr($user['id']) ?>
                        </a>
                    </td>
                    <td class="user-<?php esc_attr($key) ?>" data-label="<?php echo esc_attr($key) ?>">
                        <a href="#" class="user-link" data-user-id="<?php echo esc_attr($user['id']) ?>">
                            <?php echo esc_html($user['name']) ?>
                        </a>
                    </td>
                    <td class="user-<?php esc_attr($key) ?>" data-label="<?php echo esc_attr($key) ?>">
                        <a href="#" class="user-link" data-user-id="<?php echo esc_attr($user['id']) ?>">
                            <?php echo esc_html($user['username']) ?>
                        </a>
                    </td>
                    <td class="user-<?php esc_attr($key) ?>" data-label="<?php echo esc_attr($key) ?>">
                        <a href="#" class="user-link" data-user-id="<?php echo esc_attr($user['id']) ?>">
                            <?php echo esc_html($user['email']) ?>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <div id="user-additional-data"></div>
</div>