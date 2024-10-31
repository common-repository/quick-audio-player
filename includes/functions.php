<?php

function qap_get_settings( $field, $default = '', $section = 'qap_general_settings' ) {
	$settings = get_option( $section );

	return $settings[ $field ] ?? $default;
}

function qap_get_meta( $post_id, $meta_key, $default = '' ) {
	$value = get_post_meta( $post_id, $meta_key, true );

	return ! empty( $value ) ? $value : $default;
}

function qap_get_player_css( $post_id = '') {
	$player_width           = qap_get_meta( $post_id, 'player_width' );
	$border_radius          = qap_get_meta( $post_id, 'border_radius' );
	$player_bg_color        = qap_get_meta( $post_id, 'player_bg_color' );
	$player_text_color      = qap_get_meta( $post_id, 'player_text_color' );
	$player_btn_color       = qap_get_meta( $post_id, 'player_btn_color' );
	$player_btn_hover_color = qap_get_meta( $post_id, 'player_btn_hover_color' );

	$css = '';
	if ( ! empty( $player_width ) ) {
		$css .= sprintf( '--qap-width: %1$spx;', $player_width );
	}

	if ( ! empty( $border_radius ) ) {
		$css .= sprintf( '--qap-border-radius: %1$spx;', $border_radius );
	}

	if ( ! empty( $player_bg_color ) ) {
		$css .= sprintf( '--qap-bg-color: %1$s;', $player_bg_color );
	}

	if ( ! empty( $player_text_color ) ) {
		$css .= sprintf( '--qap-text-color: %1$s;', $player_text_color );
	}

	if ( ! empty( $player_btn_color ) ) {
		$css .= sprintf( '--qap-btn-color: %1$s;', $player_btn_color );
	}

	if ( ! empty( $player_btn_hover_color ) ) {
		$css .= sprintf( '--qap-btn-color-hover: %1$s;}', $player_btn_hover_color );
	}

	if(!empty($css)) {
		echo "<style id='qap_custom_css'>.qap.player-$post_id{{$css}}</style>";
	}

}

function quick_audio_player_pro_skins() {
	return [ 5, 6 ];
}

function qap_get_audio_length( $audio_id ) {
	if ( empty( $audio_id ) ) {
		return 0;
	}

	$file = get_attached_file( $audio_id );

	if ( ! function_exists( 'wp_read_audio_metadata' ) ) {
		include_once ABSPATH . '/wp-admin/includes/media.php';
	}

	$metadata = wp_read_audio_metadata( $file );

	return $metadata['length_formatted'];
}

function qap_player_control( $control, $skin_id, $player_id ) {

	$player_type = qap_get_meta( $player_id, 'player_type', 'single' );
	$first_track = qap_get_tracks( $player_id, true );

	$saved_controls = qap_get_meta( $player_id, 'controls', [] );
	if ( empty( $saved_controls ) ) {
		$controls = qap_get_skin( $skin_id )['controls'];
	} else {
		$controls = array_filter( $saved_controls, function ( $control ) {
			return 'on' == $control;
		} );

		$controls = array_keys( (array) $controls );
	}

	if ( ! in_array( $control, $controls ) ) {
		return;
	}

	if ( 'single' == $player_type && in_array( $control, [ 'skipback', 'skipforward' ] ) ) {
		return;
	}

	//restart
	ob_start(); ?>
    <div class="qap_restart player_control" title="Restart">
		<i class="dashicons dashicons-image-rotate"></i>
	</div>
	<?php
	$controls['restart'] = ob_get_clean();

	//play
	ob_start(); ?>
    <div class="qap_play player_control" title="Play">
		<i class="dashicons dashicons-controls-play"></i>
	</div>

	<div class="qap_pause player_control">
		<i class="dashicons dashicons-controls-pause"></i>
	</div>
	<?php
	$controls['play'] = ob_get_clean();

	//rewind
	ob_start(); ?>
    <div class="qap_rewind player_control" title="Rewind">
		<i class="dashicons dashicons-controls-back"></i>
	</div>
	<?php
	$controls['rewind'] = ob_get_clean();

	//forward
	ob_start(); ?>
    <div class="qap_forward player_control" title="Fast Forward">
		<i class="dashicons dashicons-controls-forward"></i>
	</div>
	<?php
	$controls['forward'] = ob_get_clean();

	//skipback
	ob_start(); ?>
	<div class="qap_skipback player_control">
		<i class="dashicons dashicons-controls-skipback"></i>
	</div>
	<?php
	$controls['skipback'] = ob_get_clean();

	//skipforward
	ob_start(); ?>
    <div class="qap_skipforward player_control" title="Skip Forward">
		<i class="dashicons dashicons-controls-skipforward"></i>
	</div>
	<?php
	$controls['skipforward'] = ob_get_clean();

	//volume
	ob_start(); ?>
    <div class="qap_volume player_control" title="Volume">
		<div class="volume_icon">
			<i class="dashicons dashicons-controls-volumeon"></i>
			<i class="dashicons dashicons-controls-volumeoff"></i>
		</div>

		<div class="qap_volume_bar">
			<input class="qap_volume_bar-seek" type="range" min="0" max="1" step=".05" value="0">
			<progress class="qap_volume_bar-bar" max="1" value="0" role="progressbar"></progress>
		</div>
	</div>
	<?php
	$controls['volume'] = ob_get_clean();

	//progress
	ob_start(); ?>
    <div class="qap_progress player_control" title="Progress">
		<input class="qap_progress-seek" type="range" min="0" max="100" step="0.01" value="0">
		<progress class="qap_progress-bar" max="100" value="0" role="progressbar"></progress>
	</div>
	<?php
	$controls['progress'] = ob_get_clean();

	//time
	ob_start(); ?>
    <div class="player_status-track_time player_control" title="Time">
		<span class="track_time-current">00:00</span> /
        <span class="track_time-duration"><?php echo qap_get_audio_length( $first_track['audio_id'] ); ?></span>
	</div>

	<?php
	$controls['time'] = ob_get_clean();


	//settings
	ob_start(); ?>
    <div class="qap_settings player_control" title="Settings">
		<div class="qap_settings-menu">

			<div class="menu_item menu_item-home active">
				<div class="menu_item-label" data-target=".menu_item-speed">
					<span>Speed</span>
					<span class="menu_item-label-value">Normal</span>
				</div>
			</div>

			<div class="menu_item menu_item-speed">

				<label class="menu_item-label">
					<input type="radio" name="player_speed" value="2.00"> 2x
				</label>

				<label class="menu_item-label">
					<input type="radio" name="player_speed" value="1.75"> 1.75x
				</label>

				<label class="menu_item-label">
					<input type="radio" name="player_speed" value="1.5"> 1.50x
				</label>

				<label class="menu_item-label">
					<input type="radio" name="player_speed" value="1.00" checked> Normal
				</label>

				<label class="menu_item-label">
					<input type="radio" name="player_speed" value=".75"> 0.75x
				</label>

			</div>
		</div>

		<i class="dashicons dashicons-admin-generic"></i>
	</div>
	<?php
	$controls['settings'] = ob_get_clean();


	//download
	ob_start(); ?>
    <div class="qap_download player_control" title="Download">
        <a href="<?php echo $first_track['audio_file']; ?>" download><i class="dashicons dashicons-download"></i></a>
	</div>
	<?php
	$controls['download'] = ob_get_clean();


	//repeat
	ob_start(); ?>
    <div class="qap_repeat player_control" title="Repeat">
        <i class="dashicons dashicons-controls-repeat"></i>
    </div>
	<?php
	$controls['repeat'] = ob_get_clean();

	//suffle
	ob_start(); ?>
    <div class="qap_suffle player_control" title="Suffle">
        <i class="dashicons dashicons-randomize"></i>
    </div>
	<?php
	$controls['suffle'] = ob_get_clean();

	//repeat
	ob_start(); ?>
    <div class="qap_repeat player_control" title="Repeat">
        <i class="dashicons dashicons-controls-repeat"></i>
    </div>
	<?php
	$controls['repeat'] = ob_get_clean();

	//playlist_icon
    ob_start(); ?>
    <div class="playlist_icon player_control">
        <i class="dashicons dashicons-playlist-audio"></i>
    </div>
    <?php
    $controls['playlist_icon'] = ob_get_clean();


	echo $controls[ $control ];

}

function qap_render_playlist( $player_id, $is_hidden = false ) {

	$tracks = qap_get_tracks( $player_id );

	ob_start();
	?>
    <div class="qap_playlist-tracks <?php echo $is_hidden ? 'hidden' : ''; ?>">

		<?php

		if ( ! empty( $tracks ) ) {
			$sl = 1;
			foreach ( $tracks as $track ) { ?>
                <div class="qap_playlist-item <?php echo 1 == $sl ? 'active' : ''; ?>" data-track='<?php echo json_encode( $track ); ?>'>

                    <span class="qap_playlist-item-sl">
                        <?php echo $sl; ?>.
                    </span>

                    <span class="qap_playlist-item-thumb">
                        <img src="<?php echo $track['poster']; ?>" alt="<?php echo $track['track_title']; ?>">
                    </span>

                    <div class="qap_playlist-caption">
                        <span class="qap_playlist-item-title"><?php echo $track['track_title']; ?></span>
                        <span class="qap_playlist-item-album"><?php echo $track['album'] ?> </span>
                        <span class="qap_playlist-item-artist">
                            <?php ! empty( $track['artist'] ) && printf( ' - ' . $track['artist'] ); ?>
                        </span>
                    </div>

                    <div class="qap_playlist-item-duration"><?php echo qap_get_audio_length( $track['audio_id'] ); ?></div>
                </div>
				<?php
				$sl ++;
			}
		}
		?>

    </div>
	<?php
	echo ob_get_clean();
}

function qap_audio( $player_id ) {
	$first_track = qap_get_tracks( $player_id, true );

	$autoplay = qap_get_meta( $player_id, 'autoplay', 'off' );
	$loop     = qap_get_meta( $player_id, 'loop', 'off' );
	$muted    = qap_get_meta( $player_id, 'muted', 'off' );

	$attributes = sprintf( ' %s %s %s', 'on' == $autoplay ? 'autoplay' : '', 'on' == $loop ? 'loop' : '', 'on' == $muted ? 'muted' : '' );


	printf( '<audio src="%1$s" class="qap_audio" %2$s ></audio>', $first_track['audio_file'], $attributes );
}

function qap_get_skin( $skin_id = false ) {
	$skins = [
		1 => [
			'controls' => [],
		],

		2 => [
			'controls' => [],
		],

		3 => [
			'controls' => [
				'play',
				'skipback',
				'skipforward',
				'rewind',
				'progress',
				'forward',
				'time',
				'suffle',
				'volume',
				'settings',
				'download',
			],
		],

		4 => [
			'controls' => [
				'play',
				'rewind',
				'progress',
				'forward',
			],
		],

		5 => [
			'controls' => [
				'rewind',
				'play',
				'forward',
				'progress',
				'volume',
			],
		],

		6 => [
			'controls' => [],
		],

		7 => [
			'controls' => [],
		],

		8 => [
			'controls' => [
				'progress',
				'skipback',
				'rewind',
				'play',
				'forward',
				'skipforward',
				'volume',
				'playlist_icon',
            ],
		],

		9 => [
			'controls' => [
				'progress',
				'skipback',
				'rewind',
				'play',
				'forward',
				'skipforward',
            ],
		],

		10 => [
			'controls' => [
				'progress',
				'skipback',
				'rewind',
				'play',
				'forward',
				'skipforward',
			],
		],

		11 => [
			'controls' => [
				'progress',
				'skipback',
				'rewind',
				'play',
				'forward',
				'skipforward',
			],
		],
	];

	if ( ! empty( $skin_id ) ) {
		return $skins[ $skin_id ];
	}

	return $skins;

}

function qap_get_tracks( $player_id, $first = false ) {

	$player_type = qap_get_meta( $player_id, 'player_type', 'single' );

	if ( 'single' == $player_type ) {
		$first_track = qap_get_meta( $player_id, 'track', [
			'audio_id'    => '',
			'audio_file'  => QUICK_AUDIO_PLAYER_ASSETS . '/vendor/default.mp3',
			'track_title' => '',
			'album'       => '',
			'artist'      => '',
			'poster'      => QUICK_AUDIO_PLAYER_ASSETS . '/images/icon-128x128.png',
		] );

		$tracks = [];
	} else {
		$tracks      = qap_get_meta( $player_id, 'playlist_item', [] );
		$first_track = reset( $tracks );
	}

	return $first ? $first_track : $tracks;

}