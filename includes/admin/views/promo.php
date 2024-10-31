<?php


$transient_key  = 'quick_audio_player_promo_time';
$countdown_time = get_transient( $transient_key );

if ( ! $countdown_time ) {

	$date = date( 'Y-m-d-H-i', strtotime( '+ 14 hours' ) );

	$date_parts = explode( '-', $date );

	$countdown_time = [
		'year'   => $date_parts[0],
		'month'  => $date_parts[1],
		'day'    => $date_parts[2],
		'hour'   => $date_parts[3],
		'minute' => $date_parts[4],
	];

	set_transient( $transient_key, $countdown_time, 14 * HOUR_IN_SECONDS );

}

$title = 'Unlock the PRO features';

?>

<style>
    .syotimer {
        text-align: center;
        margin: 30px auto 0;
        padding: 0 0 10px;
    }

    .syotimer-cell {
        display: inline-block;
        margin: 0 5px;
        width: 60px;
        background: url(<?php echo QUICK_AUDIO_PLAYER_ASSETS.'/images/timer.png'; ?>) no-repeat;
        background-size: contain;
    }

    .syotimer-cell__value {
        font-size: 30px;
        height: 60px;
        line-height: 2;
        margin: 0 0 5px;
        color: orangered;
        font-weight: bold;
    }

    .syotimer-cell__unit {
        font-family: Arial, serif;
        font-size: 12px;
        text-transform: uppercase;
        color: #F8D83B;
    }
</style>
<div class="quick-audio-player-promo hidden">
    <div class="quick-audio-player-promo-inner">
        <span class="close-promo">&times;</span>

        <img src="<?php echo QUICK_AUDIO_PLAYER_ASSETS . '/images/crown.svg'; ?>" class="promo-img">

        <h3><?php echo $title; ?></h3>
        <h3 class="discount-text">50% OFF</h3>
        <h3 style="font-size: 18px;">LIMITED TIME ONLY</h3>
        <div class="simple_timer"></div>
        <a href="<?php echo QUICK_AUDIO_PLAYER_PRICING; ?>">GET PRO</a>

    </div>
</div>

<script>
    (function ($) {
        $(document).ready(function () {

            $(document).on('click', '.pro_feature', function (e) {
                e.stopImmediatePropagation();
                e.preventDefault();
                $('.quick-audio-player-promo').removeClass('hidden');
            });

            $(document).on('click', '.close-promo', function () {
                $('.quick-audio-player-promo').addClass('hidden');
            });

            $('.quick-audio-player-promo').on('click', function (e) {
                if(e.target !== this){
                    return;
                }

                $('.quick-audio-player-promo').addClass('hidden');

            });

            if (typeof window.timer_set === 'undefined') {
                window.timer_set = $('.simple_timer').syotimer({
                    year: <?php echo $countdown_time['year']; ?>,
                    month: <?php echo $countdown_time['month']; ?>,
                    day: <?php echo $countdown_time['day']; ?>,
                    hour: <?php echo $countdown_time['hour']; ?>,
                    minute: <?php echo $countdown_time['minute']; ?>
                });
            }
        })
    })(jQuery);
</script>