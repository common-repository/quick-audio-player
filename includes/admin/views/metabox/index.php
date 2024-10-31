<div class="quick-audio-player-metabox">
    <div class="quick-audio-player-metabox-sidebar">
        <a href="javascript:;" data-target="general"><i class="dashicons dashicons-admin-generic"></i> General</a>
        <a href="javascript:;" data-target="skins"><i class="dashicons dashicons-format-video"></i> Skins</a>
        <a href="javascript:;" data-target="controls"><i class="dashicons dashicons-admin-settings"></i> Controls</a>
        <a href="javascript:;" data-target="style"><i class="dashicons dashicons-admin-appearance"></i> Style</a>
    </div>

    <div class="quick-audio-player-metabox-body">
        <div class="content-tab" id="general">
			<?php include QUICK_AUDIO_PLAYER_INCLUDES . '/admin/views/metabox/general.php'; ?>
        </div>

        <div class="content-tab" id="skins">
	        <?php include QUICK_AUDIO_PLAYER_INCLUDES . '/admin/views/metabox/skins.php'; ?>
        </div>

        <div class="content-tab" id="controls">
	        <?php include QUICK_AUDIO_PLAYER_INCLUDES . '/admin/views/metabox/controls.php'; ?>
        </div>

        <div class="content-tab" id="style">
	        <?php include QUICK_AUDIO_PLAYER_INCLUDES . '/admin/views/metabox/style.php'; ?>
        </div>

	    <?php
	    if ( ! qap_fs()->can_use_premium_code__premium_only() ) {
		    include_once QUICK_AUDIO_PLAYER_INCLUDES . '/admin/views/promo.php';
	    }
	    ?>

    </div>

</div>