<?php
global $post;
$player_width           = qap_get_meta( $post->ID, 'player_width' );
$border_radius          = qap_get_meta( $post->ID, 'border_radius' );
$player_bg_color        = qap_get_meta( $post->ID, 'player_bg_color' );
$player_text_color   = qap_get_meta( $post->ID, 'player_text_color' );
$player_btn_color       = qap_get_meta( $post->ID, 'player_btn_color' );
$player_btn_hover_color = qap_get_meta( $post->ID, 'player_btn_hover_color' );

$is_pro = ! qap_fs()->can_use_premium_code__premium_only() ? 'pro_feature' : '';

?>

<h3 class="tab_title">Style Settings</h3>

<table class="qap_metabox_table">
    <tbody>
    <tr class="metabox_field player_width">
        <th>
            <label for="player_width"> <i class="dashicons dashicons-ellipsis"></i> Player Width</label>
            <span>:</span>
        </th>
        <td>
            <div class="input_group">
                <div class="wpmilitary-slider" data-min="200" data-max="1200" data-value="<?php echo $player_width; ?>">
                    <input type="hidden" id="player_width" name="player_width" value="<?php echo $player_width; ?>"/>
                    <div class="wpmilitary-slider-handle ui-slider-handle"></div>
                </div>
                <span class="wpmilitary-slider-reset dashicons dashicons-image-rotate button-link-delete"
                        title="Reset"
                ></span>

            </div>
            <p class="description">Set the player width.</p>
        </td>
    </tr>

    <tr class="metabox_field border_radius <?php echo $is_pro; ?>">
        <th>
            <label for="border_radius"><i class="dashicons dashicons-button"></i> Border Radius</label>
            <span>:</span>
        </th>
        <td>
            <div class="input_group">
                <div class="wpmilitary-slider" data-min="0" data-max="50" data-value="<?php echo $border_radius; ?>">
                    <input type="hidden" id="border_radius" name="border_radius" value="<?php echo $border_radius; ?>"/>
                    <div class="wpmilitary-slider-handle ui-slider-handle"></div>
                </div>
                <span class="wpmilitary-slider-reset dashicons dashicons-image-rotate button-link-delete"
                        title="Reset"
                ></span>

            </div>
            <p class="description">Set the player border radius.</p>
        </td>
    </tr>

    <tr class="metabox_field player_bg_color <?php echo $is_pro; ?>">
        <th>
            <label for="player_bg_color"> <i class="dashicons dashicons-admin-customizer"></i> Background Color</label>
            <span>:</span>
        </th>
        <td>
            <div class="input_group">
                <input type="text" data-alpha-enabled="true" id="player_bg_color" name="player_bg_color" value="<?php echo $player_bg_color; ?>"/>
            </div>
            <p class="description">Customize the player background color.</p>
        </td>
    </tr>

    <tr class="metabox_field player_text_color <?php echo $is_pro; ?>">
        <th>
            <label for="player_text_color"> <i class="dashicons dashicons-admin-customizer"></i> Text Color</label>
            <span>:</span>
        </th>
        <td>
            <div class="input_group">
                <input type="text" class="color-picker" data-alpha-enabled="true" id="player_text_color" name="player_text_color" value="<?php echo $player_text_color; ?>"/>
            </div>
            <p class="description">The primary UI color of the Player.</p>
        </td>
    </tr>

    <tr class="metabox_field player_btn_color <?php echo $is_pro; ?>">
        <th>
            <label for="player_btn_color"> <i class="dashicons dashicons-admin-customizer"></i> Button Color</label>
            <span>:</span>
        </th>
        <td>
            <div class="input_group">
                <input type="text" class="color-picker" data-alpha-enabled="true" id="player_btn_color" name="player_btn_color" value="<?php echo $player_btn_color; ?>"/>
            </div>
            <p class="description">The button color of the Player.</p>
        </td>
    </tr>

    <tr class="metabox_field player_btn_hover_color <?php echo $is_pro; ?>">
        <th>
            <label for="player_btn_hover_color"> <i class="dashicons dashicons-admin-customizer"></i> Button Hover Color</label>
            <span>:</span>
        </th>
        <td>
            <div class="input_group">
                <input type="text" class="color-picker" data-alpha-enabled="true" id="player_btn_hover_color" name="player_btn_hover_color" value="<?php echo $player_btn_hover_color; ?>"/>
            </div>
            <p class="description">The button hover color of the Player.</p>
        </td>
    </tr>

    </tbody>
</table>