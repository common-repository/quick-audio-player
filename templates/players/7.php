<?php

$player_type = qap_get_meta( $player_id, 'player_type', true );

if ( 'single' == $player_type ) {
	$tracks = [qap_get_tracks( $player_id, true )];
} else {
	$tracks = qap_get_tracks( $player_id );
}

$track_ids = array_map( function ( $item ) {
	return $item['audio_id']??null;
}, $tracks );

$track_ids = implode(',', $track_ids);

?>

<div class="qap skin-7 player-<?php echo $player_id; ?>">
	<?php echo do_shortcode( "[playlist ids='$track_ids' style=dark]" ); ?>
</div>
