<?php

$tracks      = qap_get_tracks( $player_id );
$first_track = qap_get_tracks( $player_id, true );

$player_controls = [
	'restart',
	'skipback',
	'play',
	'skipforward',
	'rewind',
	'progress',
	'forward',
	'time',
	'repeat',
	'suffle',
	'volume',
	'settings',
	'download',
];

?>

<div class="qap player-<?php echo $player_id; ?> skin-4">

    <div class="player_controls">
		<?php
		foreach ( $player_controls as $control ) {
			qap_player_control( $control, 4, $player_id );
		}
		?>
    </div>

    <div class="player_poster">
        <img class="qap_poster" src="<?php echo $first_track['poster']; ?>">
    </div>

	<?php qap_audio( $player_id ); ?>
	<?php qap_render_playlist( $player_id, true ); ?>

</div>
