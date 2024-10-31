<div class="qap player-<?php echo $player_id; ?> skin-5">

    <div class="player_controls">
        <?php
        $controls = [
	        'restart',
	        'skipback',
	        'rewind',
	        'play',
	        'forward',
	        'skipforward',
	        'progress',
	        'time',
	        'repeat',
	        'suffle',
	        'volume',
	        'settings',
	        'download',
        ];

        foreach ( $controls as $control ) {
	        qap_player_control( $control, 5, $player_id );
        }

        ?>
    </div>

    <?php qap_audio($player_id); ?>
    <?php qap_render_playlist($player_id, true); ?>
</div>


