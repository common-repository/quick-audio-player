<?php

global $post;

$is_pro = ! qap_fs()->can_use_premium_code__premium_only() ? 'pro_feature' : '';

$player_type = qap_get_meta( $post->ID, 'player_type', 'single' );
$track       = qap_get_meta( $post->ID, 'track', [
	'audio_id'    => '',
	'audio_file'  => QUICK_AUDIO_PLAYER_ASSETS . '/vendor/default.mp3',
	'track_title' => '',
	'album'       => '',
	'artist'      => '',
	'poster'      => QUICK_AUDIO_PLAYER_ASSETS . '/images/icon-128x128.png',
] );

$playlist_items = qap_get_meta( $post->ID, 'playlist_item', [] );

?>

<h3 class="tab_title">General Settings</h3>

<table class="qap_metabox_table">
    <tbody>

    <!-- player type -->
    <tr class="metabox_field player_type">
        <th>
            <label for="player_type"> <i class="dashicons dashicons-controls-play"></i>Player Type</label>
            <span>:</span>
        </th>
        <td>
            <div class="input_group">
                <div class="input_field">
                    <input type="radio" id="player_type_single" name="player_type" value="single" <?php checked( 'single',
					    $player_type ); ?>>
                    <label for="player_type_single">
                        <i class="dashicons dashicons-format-audio"></i>
                        Single Track</label>
                </div>

                <div class="input_field">
                    <input type="radio" id="player_type_playlist" name="player_type" value="playlist" <?php checked( 'playlist',
					    $player_type ); ?>>
                    <label for="player_type_playlist">
                        <i class="dashicons dashicons-playlist-audio"></i>
                        Playlist</label>
                </div>
            </div>
            <p class="description">Select the player type single or playlist track.</p>
        </td>
    </tr>

    </tbody>
</table>

<!--single type-->
<div class="single_type <?php echo 'single' == $player_type ? '' : 'hidden'; ?>">
    <h3 class="single_type_heading">
        <i class="dashicons dashicons-format-audio"></i>
        Audio Track
    </h3>

    <table class="qap_metabox_table">
        <tbody>

        <!-- audio track -->
        <tr class="metabox_field audio-file">
            <th>
                <label for="audio_file"> <i class="dashicons dashicons-media-audio"></i>Audio Track</label>
                <span>:</span>
            </th>
            <td>
                <div class="input_group">
                    <input type="hidden" class="audio_id_input" id="audio_id" name="track[audio_id]" value="<?php echo $track['audio_id']; ?>">
                    <input type="text" class="audio_file_input" id="audio_file" name="track[audio_file]" value="<?php echo $track['audio_file']; ?>" placeholder="Enter the audio URL or select an audio by clicking the browse button">

                    <a href="#" class="button button-primary select_audio"><i class="dashicons dashicons-plus-alt"></i> Browse</a>
                    <a href="#" class="button button-link-delete delete_audio <?php echo ! empty( $track['audio_id'] ) ? '' : 'hidden'; ?>">
                        <i class="dashicons dashicons-trash"></i></a>
                </div>
                <p class="description">Enter the audio URL or select an audio by clicking the browse button</p>
            </td>
        </tr>

        <!-- track title -->
        <tr class="metabox_field track_title">
            <th>
                <label for="track_title"> <i class="dashicons dashicons-embed-audio"></i> Track Title</label>
                <span>:</span>
            </th>
            <td>
                <div class="input_group">
                    <input type="text" class="track_title_input" id="track_title" name="track[track_title]" value="<?php echo $track['track_title']; ?>" placeholder="Enter the audio title">
                </div>
                <p class="description">Enter the audio title</p>
            </td>
        </tr>

        <!-- artist -->
        <tr class="metabox_field artist">
            <th>
                <label for="artist"> <i class="dashicons dashicons-admin-users"></i> Artist</label>
                <span>:</span>
            </th>
            <td>
                <div class="input_group">
                    <input type="text" class="artist_input" id="artist" name="track[artist]" value="<?php echo $track['artist']; ?>" placeholder="Enter the audio artist">
                </div>
                <p class="description">Enter the audio artist</p>
            </td>
        </tr>

        <!-- album -->
        <tr class="metabox_field album">
            <th>
                <label for="album"> <i class="dashicons dashicons-album"></i> Album</label>
                <span>:</span>
            </th>
            <td>
                <div class="input_group">
                    <input type="text" class="album_input" id="album" name="track[album]" value="<?php echo $track['album']; ?>" placeholder="Enter the audio album">
                </div>
                <p class="description">Enter the audio album</p>
            </td>
        </tr>

        <!-- album art -->
        <tr class="metabox_field poster <?php echo $is_pro; ?>">
            <th>
                <label for="poster"> <i class="dashicons dashicons-format-image"></i> Album Art</label>
                <span>:</span>
            </th>
            <td>
                <div class="input_group">
                    <input type="text" class="poster_input" id="poster" name="track[poster]" value="<?php echo $track['poster']; ?>" placeholder="Enter the image URL or select an audio by clicking the browse button">

                    <a href="#" class="button button-primary select_poster"><i class="dashicons dashicons-plus-alt"></i> Browse</a>
                    <a href="#" class="button button-link-delete delete_poster <?php echo ! empty( $track['poster'] ) ? '' : 'hidden'; ?>">
                        <i class="dashicons dashicons-trash"></i></a>
                </div>

                <div class="poster_preview">
                    <img src="<?php echo $track['poster']; ?>">
                </div>

                <p class="description">Enter the image URL or select an image by clicking the browse button for the player poster image.</p>
            </td>
        </tr>

        </tbody>
    </table>
</div>

<!--playlist type-->
<div class="playlist_type <?php echo 'playlist' == $player_type ? '' : 'hidden'; ?>">

    <h3 class="playlist_type_heading">
        <i class="dashicons dashicons-playlist-audio"></i>
        Playlist Tracks
    </h3>

    <div class="playlist_tracks">
		<?php

		if ( empty( $playlist_items ) ) {
			$playlist_items = [
				[
					'audio_id'    => '',
					'audio_file'  => '',
					'track_title' => 'Untitled',
					'artist'      => '',
					'album'       => '',
					'poster_id'   => '',
					'poster'      => '',
				],
			];
		}

		$i = 0;
		foreach ( $playlist_items as $item ) { ?>
            <div class="playlist_track" data-id="<?php echo $i; ?>">

                <div class="playlist_track_header">
                    <span class="track_sl"><?php echo $i + 1; ?>.</span>
                    <span class="header_track_title"><?php echo $item['track_title']; ?></span>

                    <div class="track_action">
                        <i class="edit_track dashicons dashicons-edit" title="Edit"></i>
                        <i class="duplicate_track dashicons dashicons-admin-page" title="Duplicate"></i>
                        <i class="delete_track dashicons dashicons-trash" title="Delete"></i>
                        <i class="move_track dashicons dashicons-move" title="Move"></i>
                    </div>
                </div>

                <div class="playlist_track_body" style="display: none;">
                    <table class="qap_metabox_table">
                        <tbody>

                        <!-- audio_file -->
                        <tr class="metabox_field audio_file">
                            <th>
                                <label for="audio_file__<?php echo $i; ?>">
                                    <i class="dashicons dashicons-media-audio"></i>Audio Track</label>
                                <span>:</span>
                            </th>
                            <td>
                                <div class="input_group">
                                    <input type="hidden" class="audio_id_input" id="audio_id__<?php echo $i; ?>" name="playlist_item[<?php echo $i; ?>][audio_id]" value="<?php echo $item['audio_id']; ?>">
                                    <input type="text" class="audio_file_input" id="audio_file__<?php echo $i; ?>" name="playlist_item[<?php echo $i; ?>][audio_file]" value="<?php echo $item['audio_file']; ?>" placeholder="Enter the audio URL or select an audio by clicking the browse button">

                                    <a href="#" class="button button-primary select_audio"><i class="dashicons dashicons-plus-alt"></i> Browse</a>
                                    <a href="#" class="button button-link-delete delete_audio <?php echo ! empty( $item['audio_file'] ) ? ''
										: 'hidden'; ?>">
                                        <i class="dashicons dashicons-trash"></i></a>
                                </div>
                            </td>
                        </tr>

                        <!-- track_title -->
                        <tr class="metabox_field track_title">
                            <th>
                                <label for="track_title__<?php echo $i; ?>">
                                    <i class="dashicons dashicons-embed-audio"></i> Track Title</label>
                                <span>:</span>
                            </th>
                            <td>
                                <input type="text" class="track_title_input" id="track_title__<?php echo $i; ?>" name="playlist_item[<?php echo $i; ?>][track_title]" value="<?php echo $item['track_title']; ?>" placeholder="Enter the audio title">
                            </td>
                        </tr>

                        <!-- artist -->
                        <tr class="metabox_field artist">
                            <th>
                                <label for="artist__<?php echo $i; ?>"> <i class="dashicons dashicons-admin-users"></i> Artist</label>
                                <span>:</span>
                            </th>
                            <td>
                                <input type="text" class="artist_input" id="artist__<?php echo $i; ?>" name="playlist_item[<?php echo $i; ?>][artist]" value="<?php echo $item['artist']; ?>" placeholder="Enter the audio artist">
                            </td>
                        </tr>

                        <!-- album -->
                        <tr class="metabox_field album">
                            <th>
                                <label for="album__<?php echo $i; ?>"> <i class="dashicons dashicons-album"></i> Album</label>
                                <span>:</span>
                            </th>
                            <td>
                                <input type="text" class="album_input" id="album__<?php echo $i; ?>" name="playlist_item[<?php echo $i; ?>][album]" value="<?php echo $item['album']; ?>" placeholder="Enter the audio album">
                            </td>
                        </tr>

                        <!-- poster -->
                        <tr class="metabox_field poster">
                            <th>
                                <label for="poster__<?php echo $i; ?>"> <i class="dashicons dashicons-format-image"></i> Album Art</label>
                                <span>:</span>
                            </th>
                            <td>
                                <div class="input_group">
                                    <input type="text" class="poster_input" id="poster__<?php echo $i; ?>" name="playlist_item[<?php echo $i; ?>][poster]" value="<?php echo $item['poster']; ?>" placeholder="Enter the image URL or select an audio by clicking the browse button">

                                    <a href="#" class="button button-primary select_poster"><i class="dashicons dashicons-plus-alt"></i> Browse</a>
                                    <a href="#" class="button button-link-delete delete_poster <?php echo ! empty( $item['poster'] ) ? ''
										: 'hidden'; ?>">
                                        <i class="dashicons dashicons-trash"></i></a>
                                </div>

                                <div class="poster_preview">
                                    <img src="<?php echo $item['poster']; ?>">
                                </div>

                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>

            </div>
			<?php
			$i ++;
		} ?>

        <button id="add_new_track" class="add_new_track button" type="button"><i class="dashicons dashicons-plus-alt"></i> Add New Track
        </button>

    </div>
</div>