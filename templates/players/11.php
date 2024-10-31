<?php

$tracks      = qap_get_tracks( $player_id );
$first_track = qap_get_tracks( $player_id, true );

?>

<div class="qap qap_playlist player-<?php echo $player_id; ?> skin-11">

    <div class="player_left">
        <div class="qap_playlist-current_item">

            <img class="qap_poster" src="<?php echo $first_track['poster'] ?>"/>

            <div class="qap_playlist-caption">
                <span class="qap_playlist-title">
                    <?php ! empty( $first_track['track_title'] )
                          && printf( '<i class="dashicons dashicons-format-audio"></i> %s', $first_track['track_title'] ); ?>
                </span>

                <span class="qap_playlist-album">
                    <?php ! empty( $first_track['album'] )
                          && printf( '<i class="dashicons dashicons-album"></i> %s', $first_track['album'] ); ?>
                </span>

                <span class="qap_playlist-artist">
                    <?php ! empty( $first_track['artist'] )
                          && printf( '<i class="dashicons dashicons-admin-users"></i> %s', $first_track['artist'] ); ?>
                </span>
            </div>

	        <?php qap_audio( $player_id ); ?>


        </div>

        <div class="player_status">

            <div class="player_status-track_info">
                <span class="track_info-current_no">1</span> / <span class="track_info-total_no"><?php echo count( $tracks ); ?></span>
            </div>

	        <?php qap_player_control( 'time', 11, $player_id ); ?>
        </div>

	    <?php qap_player_control( 'progress', 11, $player_id ); ?>

        <div class="player_controls">
	        <?php

	        $player_controls = [
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

    <div class="player_right">
        <div class="qap_playlist-tracks">

			<?php qap_render_playlist( $player_id ); ?>

        </div>
    </div>

</div>

</div>