<div class="single-user-data">
    <h2>User Details</h2>
    <ul class="user-data">
        <?php
            foreach ($user_details as $key => $value) {
               if( is_array($value) ){
                   foreach ($value as $key2 => $value2) {
                       echo '<li><h3>'.esc_html($key).'</h3><p>'.esc_html($value2).'</p></li>';
                   }
               } else {
                   echo '<li><h3>'.esc_html($key).'</h3><p>'.esc_html($value).'</p></li>';
               }
            }
        ?>
    </ul>
</div>