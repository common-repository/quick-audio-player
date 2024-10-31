<div class="qap skin-6 player-<?php echo $player_id; ?>">

    <div class="record">
        <div class="label"></div>
        <div class="spindle"></div>
    </div>

    <div class="arm-container">
        <div class="knob weight bottom"></div>
        <div class="arm"></div>

        <div class="knob weight top">
            <button type="button" class="play">
	            <?php
	            qap_player_control( 'play', 6, $player_id );
	            ?>
            </button>
        </div>

    </div>

    <div class="speaker">
        <div class="hole"></div>
        <div class="hole"></div>
        <div class="hole"></div>
        <div class="hole"></div>
        <div class="hole"></div>
        <div class="hole"></div>
        <div class="hole"></div>
        <div class="hole"></div>
    </div>

    <div class="knob volume bottom">
        <div class="volume_down down">
            <i class="dashicons dashicons-minus"></i>
        </div>
        <div class="volume_up up">
            <i class="dashicons dashicons-plus"></i>
        </div>
    </div>

    <div class="knob volume top">
        <span class="volume_number">80</span>
    </div>

    <?php qap_audio($player_id); ?>

</div>


<script>
    (function ($) {

        $(document).ready(function () {
            const parent = $('.skin-6');

            $('.play i', parent).css('font-size', $('.play', parent).outerWidth());


            $(document).on('click', '.volume_up, .volume_down', volumeUp);

            function volumeUp() {
                const player_id = $(this).parents('.qap').find('.mejs-container').attr('id');
                const player = mejs.players[player_id];

                const volumeContainer = $('.volume_number');

                let newVolume = player.volume;
                newVolume = parseFloat(newVolume.toFixed(2));

                if ($(this).hasClass('volume_up')) {
                    if (newVolume <= .95) {
                        newVolume += .05;
                    }
                } else {
                    if (newVolume >= .05 ) {
                        newVolume -= .05;
                    }
                }

                volumeContainer.text(parseInt(newVolume * 100));
                player.volume = newVolume;

            }

        });
    })(jQuery);
</script>
