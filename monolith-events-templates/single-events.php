<?php
/*
 *
 * Simple Events single view
 *
 */

$event_venue = get_field('venue_name');
$event_address = get_field('venue_name') . ', ' . get_field('address_one') . ', ' . get_field('city') . ', ' . get_field('post_code');
$event_address = get_field('address_one') . ', ' . get_field('city') . ', ' . get_field('post_code');
?>

<?php get_header() ?>

<div class="wrapper-main" role="document">

	<div class="<?= CONTAINER_CLASSES; ?>">

		<? get_template_part('parts/breadcrumb'); // load the breadcrumbs ?>

		<div class="<?= ROW_CLASSES ?>">

			<div class="<?= MAIN_SIZE ?>" role="main" itemscope itemtype="http://schema.org/ItemPage">
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<? get_template_part('parts/title'); // load the page header ?>

				<div class="event-image">
					<?php the_post_thumbnail() ?>
				</div>

				<article itemscope itemtype="http://schema.org/Event" <?php post_class(); ?>>

					<?php if ($post->post_excerpt != '') { // show the excerpt if it exists ?>
					<section class="event-excerpt lead" itemprop="description">
						<?php the_excerpt(); ?>
					</section>
					<? } ?>

					<section class="event-content" itemprop="articleBody">
						<?php the_content(); ?>
					</section>



					<section class="event-detail">

						<? // See if we have dates to play with and if we do make them the correct date format ?>
						<?php if(get_field('start_date')) : ?>
							<? $start_date = DateTime::createFromFormat('Ymd', get_field('start_date')); ?>
						<?php endif; ?>
						
						<?php if(get_field('date')) : ?>
							<? $date = DateTime::createFromFormat('Ymd', get_field('date')); ?>
						<?php endif; ?>
						
						<? // if the event start and end date is the same or there is no start date just render the end date ?>
						<?php if($start_date == $date || $start_date == 0) : ?>
							<p class="event-date-detail"><?php echo $date->format('D, d F Y'); ?></p>
							
						<? // else if we have a start and end date (this is a multi day event) then render both dates ?>	
						<?php else : ?>
							<p class="event-date-detail"><?php echo $start_date->format('D, d F Y'); ?> - <?php echo $date->format('D, d F Y'); ?></p>
						<? endif; ?>
						
					  	<?php if(get_field('time')) : ?>
						    <p><strong>Time</strong></p>
						    <p><?php the_field('time') ?></p>
						<? endif; ?>
						
					  	<?php if(get_field('venue_name')) : ?>
						    <p><strong>Venue</strong></p>
						    <p><?php the_field('venue_name') ?></p>
						<? endif; ?>
						
					  	<?php if(get_field('address_one')) : ?>
						    <p><strong>Address One</strong></p>
						    <p><?php the_field('address_one') ?></p>
						<? endif; ?>
						
					  	<?php if(get_field('address_two')) : ?>
						    <p><strong>Address Two</strong></p>
						    <p><?php the_field('address_two') ?></p>
						<? endif; ?>
						
					  	<?php if(get_field('address_three')) : ?>
						    <p><strong>Address Three</strong></p>
						    <p><?php the_field('address_three') ?></p>
						<? endif; ?>
						
					  	<?php if(get_field('city')) : ?>
						    <p><strong>City</strong></p>
						    <p><?php the_field('city') ?></p>
					    <? endif; ?>
					    
					  	<?php if(get_field('post_code')) : ?>
						    <p><strong>Post Code</strong></p>
						    <p><?php the_field('post_code') ?></p>
					    <? endif; ?>
					    
					  	<?php if(get_field('country')) : ?>
						    <p><strong>Country</strong></p>
						    <p><?php the_field('country') ?></p>
					    <? endif; ?>
					    
					  	<?php if(get_field('cost')) : ?>
						    <p><strong>Cost</strong></p>
						    <p><?php the_field('cost') ?></p>
					    <? endif; ?>
					    
					  	<?php if(get_field('facebook_link')) : ?>
						    <p><strong>Facebook</strong></p>
						    <p><?php the_field('facebook_link') ?></p>
					    <? endif; ?>

					  	<?php if(get_field('website_link')) : ?>
						    <p><strong>Website</strong></p>
						    <p><?php the_field('website_link') ?></p>
					    <? endif; ?>

					</section>

					<section class="event-content" itemprop="articleBody">
						<?php the_content(); ?>
						<div id="map_container"></div>
					</section>

				</article>
				<?php endwhile; ?>
			</div><!-- /MAIN_SIZES -->

			<? get_template_part('parts/sidebar'); // load the right sidebar ?>

		</div><!-- /ROW_CLASSES -->

	</div><!-- /CONTAINER_CLASSES -->

</div><!-- /wrapper-main -->

<?php get_footer(); ?>

<script type="text/javascript">

var map;
jQuery(document).ready(function($){

	var geocoder = new google.maps.Geocoder();
	var address = '<?= $event_address ?>';

	// get the long / lat
	geocoder.geocode({
		'address': address
	}, function(results, status) {

		if (status == google.maps.GeocoderStatus.OK) {
			var latitude = results[0].geometry.location.lat();
			var longitude = results[0].geometry.location.lng();

	    	// generate the map
			map = new GMaps({
				div: '#map_container',
				width: '100%',
				height: '400px',
				lat: latitude,
				lng: longitude,
				zoom: 12,
				zoomControl : true,
				zoomControlOpt: {
					style : 'SMALL',
					position: 'TOP_LEFT'
	    		},

				panControl : false,
				scrollwheel: false
			});

			map.addMarker({
				lat: latitude,
				lng: longitude,
				title: '<?= $event_venue ?>',
				infoWindow: {
					content: '<div style="height: auto;"><b><?= $event_venue ?></b><br /><?= str_replace(', ', '<br />', $event_address) ?></div>'
				}
			});

			google.maps.event.trigger(map.markers[0], 'click');
		}
	});
});

</script>

