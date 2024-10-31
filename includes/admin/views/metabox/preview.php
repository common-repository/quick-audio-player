<?php
global $post;

$autoplay = qap_get_meta( $post->ID, 'disable_autoplay', 'off' );
?>

<div class="player_preview_metabox">

    <div class="preview-settings">
        <div class="prev_settings">
            <i class="dashicons dashicons-admin-generic"></i>
            <label>Preview Settings:</label>
        </div>
        <div class="disable_autoplay">
            <input type="hidden" name="disable_autoplay" value="off"/>
            <input type="checkbox" name="disable_autoplay" id="disable_autoplay" <?php checked( $autoplay, 'on' ); ?> value="on"/>
            <label class="disable_autoplay_switch" for="disable_autoplay">Disable Autoplay</label>
        </div>
        <div class="player_shortcode">
            <label for="preview_shortcode" class="label"><i class="dashicons dashicons-shortcode"></i></label>
            <input id="preview_shortcode" class="shortcode" type="text" readonly value="[audio_player id=<?php echo $post->ID; ?>]">
        </div>
    </div>


    <div id="audio_player_preview">
        <?php

        $html = do_shortcode( '[audio_player id=' . $post->ID . ']' );

        if ( 'on' == $autoplay ) {
	        $html = str_replace( 'autoplay', '', $html );
        }

        echo $html;

        ?>
    </div>
</div>