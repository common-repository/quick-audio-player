<?php

global $post;

$player_skin = qap_get_meta( $post->ID, 'skin', 1);
$player_type = qap_get_meta( $post->ID, 'player_type', 'single' );

$controls = qap_get_meta( $post->ID, 'controls', [] );
$player_controls = array_keys( (array) array_filter( $controls, function ( $control ) {
	return 'on' == $control;
} ) );

?>

<h3 class="tab_title">Skins Settings</h3>

<!--skins-->
<div class="player-skins-wrap" data-controls='<?php echo json_encode( (object) $player_controls); ?>'>
    <div class="modal-header">
        <h4>Choose The Player Skin</h4>
    </div>

    <input type="hidden" id="skin" name="skin" value="<?php echo $player_skin; ?>">

    <div class="modal-body player-skins">

		<?php

		foreach ( qap_get_skin() as $key => $skin ) {

			$controls = ! empty( $player_controls ) && $key == $player_skin ? $player_controls : $skin['controls'];

			$img = QUICK_AUDIO_PLAYER_ASSETS . "/images/players/$key.png";

			$is_active = $key == $player_skin ? 'active' : '';
			$is_pro    = ! qap_fs()->can_use_premium_code__premium_only() && in_array( $key, quick_audio_player_pro_skins() ) ? 'pro_feature' : '';

			$bg = [ 'bg_green', 'bg_purple', 'bg_pink' ];
			$bg = $bg[ array_rand( $bg ) ]

			?>
            <div class='skins__item <?php echo "$is_active $bg $is_pro"; ?> <?php echo $skin['type'] ?? ''; ?> '
                    data-controls='<?php echo json_encode( (object) $controls ); ?>'
                    data-skin="<?php echo $key; ?>"
            >

                <span class="skin__label"><?php echo $key; ?></span>

                <div class="skin__player">
                    <img src="<?php echo $img ?>">
                </div>

                <div class="skin__action">

                    <a href="#" class="skin__action-select button-primary">
                        <i class="dashicons dashicons-yes-alt"></i>
                        <span class="select_text">Select</span>
                        <span class="selected_text">Selected</span>
                    </a>

                </div>
            </div>
		<?php } ?>
    </div>

</div>