<?php

$tracks      = qap_get_tracks( $player_id );
$first_track = qap_get_tracks( $player_id, true );

?>

<div class="qap qap_single skin-9 player-<?php echo $player_id; ?>">

    <div class="poster_wrap">
        <img class="qap_poster" src="<?php echo $first_track['poster'] ?>" alt="">
        <span class="poster_circle"></span>
    </div>

    <div class="qap_playlist-current_item">
        <div class="qap_playlist-caption">
            <span class="qap_playlist-album"><?php echo $first_track['album']; ?></span>
            <span class="qap_playlist-artist"><?php echo $first_track['artist']; ?></span>
            <marquee class="qap_playlist-title"><?php echo $first_track['track_title']; ?></marquee>
        </div>

        <div class="player_status">
            <div class="player_status-track_info">
                <span class="track_info-current_no">1</span> /
                <span class="track_info-total_no"><?php echo count( $tracks ); ?></span>
            </div>

	        <?php qap_player_control( 'time', 9, $player_id ); ?>

        </div>

	    <?php qap_player_control( 'progress', 9, $player_id ); ?>


    </div>

    <div class="player_controls">
	    <?php

	    $player_controls = [
		    'restart',
		    'skipback',
		    'rewind',
		    'play',
		    'forward',
		    'skipforward',
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

	<?php

	qap_audio( $player_id );
	qap_render_playlist( $player_id, true );
	?>


</div>
