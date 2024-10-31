<?php

$tracks      = qap_get_tracks( $player_id );
$first_track = qap_get_tracks( $player_id, true );

?>

<div class="qap qap_single skin-10 player-<?php echo $player_id; ?>">
    <div class="player_left">
        <img class="qap_poster" src="<?php echo $first_track['poster'] ?>" alt="">
    </div>

    <div class="player_right">
        <div class="qap_playlist-current_item">
            <div class="qap_playlist-caption">
                <span class="qap_playlist-album">
	                <?php echo $first_track['album']; ?>
	            </span>

                <span class="qap_playlist-artist">
	                <?php echo $first_track['artist']; ?>
	            </span>

                <marquee class="qap_playlist-title">
	                <?php echo $first_track['track_title']; ?>
	            </marquee>
            </div>
        </div>

        <div class="player_controls">
	        <?php

	        $player_controls = [
		        'progress',
		        'restart',
		        'skipback',
		        'rewind',
		        'play',
		        'forward',
		        'skipforward',
		        'time',
		        'volume',
		        'repeat',
		        'suffle',
		        'settings',
		        'download',
	        ];

	        foreach ( $player_controls as $control ) {
		        qap_player_control( $control, 9, $player_id );
	        }

	        ?>

        </div>

    </div>

	<?php
	qap_audio( $player_id );
	qap_render_playlist( $player_id, true );
	?>

</div>