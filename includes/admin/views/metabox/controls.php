<h3 class="tab_title">Controls Settings</h3>
<p class="description">Controls settings are varies based on the player skins.</p>

<table class="qap_metabox_table">
    <tbody>

	<?php

    global $post;

	$attrs = [
		'autoplay' => [
			'label' => 'Autoplay',
			'icon'  => 'update',
			'desc'  => 'On/ Off the audio autoplay.',
			'value' => qap_get_meta( $post->ID, 'autoplay' ),
		],
		'loop'   => [
			'label' => 'Repeat',
			'icon'  => 'controls-repeat',
			'desc'  => 'On/ Off the audio play repeat.',
			'value' => qap_get_meta( $post->ID, 'loop' ),
		],
		'muted'     => [
			'label' => 'Muted',
			'icon'  => 'controls-volumeoff',
			'desc'  => 'On/ Off the audio mute.',
			'value' => qap_get_meta( $post->ID, 'muted', '' ),
		],
	];

	$controls = qap_get_meta( $post->ID, 'controls', [] );

	$controls_settings = [
		'restart'  => [
			'label'  => 'Restart Button',
			'icon'   => 'image-rotate',
			'desc'   => 'Show/ Hide the restart button in the player.',
			'value'  => $controls['restart'] ?? 'off',
		],
		'play'     => [
			'label' => 'Play Button',
			'icon'  => 'controls-play',
			'desc'  => 'Show/ Hide the audio play button in the player.',
			'value' => $controls['play'] ?? 'on',
		],

		'skipback' => [
			'label' => 'Skip Back',
			'icon'  => 'controls-skipback',
			'desc'  => 'Show/ Hide the skip back button in the player.',
			'value' => $controls['skipback'] ?? 'on',
		],

		'skipforward' => [
			'label' => 'Skip Forward',
			'icon'  => 'controls-skipforward',
			'desc'  => 'Show/ Hide the skip forward button in the player.',
			'value' => $controls['skipforward'] ?? 'on',
		],

		'rewind'   => [
			'label' => 'Rewind Button',
			'icon'  => 'controls-back',
			'desc'  => 'Show/ Hide the Rewind button in the player.',
			'value' => $controls['rewind'] ?? 'on',
		],
		'progress' => [
			'label' => 'Progress Bar',
			'icon'  => 'ellipsis',
			'desc'  => 'Show/ Hide the audio progress bar in the player.',
			'value' => $controls['progress'] ?? 'on',
		],
		'forward'  => [
			'label' => 'Fast Forward Button',
			'icon'  => 'controls-forward',
			'desc'  => 'Show/ Hide the Fast Forward & Rewind button in the player.',
			'value' => $controls['fast-forward'] ?? 'on',

		],
		'time'     => [
			'label' => ' Time',
			'icon'  => 'clock',
			'desc'  => 'Show/ Hide the player duration &current time in the player.',
			'value' => $controls['current-time'] ?? 'on',

		],
		'repeat'   => [
			'label' => 'Repeat Button',
			'icon'  => 'controls-repeat',
			'desc'  => 'Show/ Hide the repeat button.',
			'value' => qap_get_meta( $post->ID, 'repeat' ),
		],
		'suffle'   => [
			'label' => 'Suffle Button',
			'icon'  => 'randomize',
			'desc'  => 'Show/ Hide the suffle button in the player.',
			'value' => $controls['download'] ?? 'off',
		],

		'volume'   => [
			'label' => 'Volume Control',
			'icon'  => 'controls-volumeon',
			'desc'  => 'Show/ Hide the volume control in the player.',
			'value' => $controls['volume'] ?? 'on',

		],
		'settings' => [
			'label'  => 'Settings Button',
			'icon'   => 'admin-generic',
			'desc'   => 'Show/ Hide the setting button in the player to control the audio speed.',
			'value'  => $controls['settings'] ?? 'off',
		],
		'download' => [
			'label'  => 'Download Button',
			'icon'   => 'download',
			'desc'   => 'Show/ Hide the audio download button in the player.',
			'value'  => $controls['download'] ?? 'off',
		],
	];


	foreach ( $controls_settings as $key => $control ) {
		$is_pro     = ! qap_fs()->can_use_premium_code__premium_only() && ! empty( $control['is_pro'] ) ? 'pro_feature' : '';
		$is_checked = checked( 'on', $control['value'], false );

		printf( '
	    <tr class="metabox_field %1$s %6$s" data-key="%1$s">
        <th>
            <label for="controls[%1$s]"> <i class="dashicons dashicons-%5$s"></i> %2$s</label>
            <span>:</span>
        </th>

        <td>
            <div class="input_group">
                <div class="switch">
                    <div class="wp-military-switch">
                        <input type="hidden" name="controls[%1$s]" value="off"/>
                        <input
                                type="checkbox"
                                name="controls[%1$s]"
                                id="controls[%1$s]"
                                %3$s
                                value="on"/>
                        <div>
                            <label for="controls[%1$s]"></label>
                        </div>
                    </div>
                </div>
            </div>
            <p class="description">%4$s</p>
        </td>
    </tr>
	    ', $key, $control['label'], $is_checked, $control['desc'], $control['icon'], $is_pro );
	}

	foreach ( $attrs as $key => $attr ) {

		printf( '
	    <tr class="metabox_field %1$s">
        <th>
            <label for="%1$s"> <i class="dashicons dashicons-%5$s"></i> %2$s</label>
            <span>:</span>
        </th>

        <td>
            <div class="input_group">
                <div class="switch">
                    <div class="wp-military-switch">
                        <input type="hidden" name="%1$s" value="off"/>
                        <input
                                type="checkbox"
                                name="%1$s"
                                id="%1$s"
                                %3$s
                                value="on"/>
                        <div>
                            <label for="%1$s"></label>
                        </div>
                    </div>
                </div>
            </div>
            <p class="description">%4$s</p>
        </td>
    </tr>
	    ', $key, $attr['label'], checked( 'on', $attr['value'], false ), $attr['desc'], $attr['icon'] );
	}

	?>

    </tbody>
</table>