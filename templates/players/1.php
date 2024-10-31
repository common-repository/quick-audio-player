<div class="player-<?php echo $player_id; ?> skin-1">
	<?php

	$first_track = qap_get_tracks( $player_id, true );

	$autoplay = qap_get_meta( $player_id, 'autoplay', 'off' );
	$loop     = qap_get_meta( $player_id, 'loop', 'off' );
	$muted    = qap_get_meta( $player_id, 'muted', 'off' );

	$attributes = sprintf( ' %s %s %s', 'on' == $autoplay ? 'autoplay' : '', 'on' == $loop ? 'loop' : '', 'on' == $muted ? 'muted' : '' );

	?>

    <audio src="<?php echo $first_track['audio_file']; ?>" controls <?php echo $autoplay; ?>></audio>
</div>