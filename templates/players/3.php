<div class="qap qap_single player-<?php echo $player_id; ?> skin-3">

    <!--player controls-->
    <div class="player_controls">

	    <?php

	    $controls = [
		    'restart',
		    'skipback',
		    'play',
		    'skipforward',
		    'rewind',
		    'progress',
		    'forward',
		    'time',
		    'volume',
		    'repeat',
		    'suffle',
		    'settings',
		    'download',
	    ];

	    foreach ( $controls as $control ) {
		    qap_player_control( $control, 3, $player_id );
	    }

	    ?>

    </div>

	<?php qap_audio( $player_id ); ?>
	<?php qap_render_playlist( $player_id, true ); ?>

</div>


