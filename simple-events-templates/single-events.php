<?php 
/*
 * 
 * Simple Events single view
 *
 */

$event_venue = get_field('venue_name');
$event_address = get_field('address_one') . ', ' . get_field('city') . ', ' . get_field('post_code');
//dump($event_address); die; 
?>

<?php get_header() ?>

<div class="wrapper-main" role="document">
	
	<div class="<?= CONTAINER_CLASSES; ?>">

		<? get_template_part('parts/breadcrumb'); // load the breadcrumbs ?>
		
		<div class="<?= ROW_CLASSES ?>">
			
			<div class="<?= MAIN_SIZE ?>" role="main" itemscope itemtype="http://schema.org/ItemPage">			
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<? get_template_part('parts/page-header'); // load the page header ?>
				
				<div class="event-image">
					<?php the_post_thumbnail() ?>
				</div>
				
				<article itemscope itemtype="http://schema.org/Event" <?php post_class(); ?>>	
					
					<?php if ($post->post_excerpt != '') { // show the excerpt if it exists ?>
					<section class="event-excerpt lead" itemprop="description">		
						<?php the_excerpt(); ?>		
					</section>
					<? } ?>
					
					<section class="event-detail">
					
						<div class="table-responsive">
						  <table class="table">
						  
						  	<?php if(get_field('date')) : ?>
						    <tr>
							    <td>Date</td>
							    <td><?php the_field('date') ?></td>
						    </tr>
								<? endif; ?>
						  	<?php if(get_field('time')) : ?>
						    <tr>
							    <td>Time</td>
							    <td><?php the_field('time') ?></td>
						    </tr>						    
						  <? endif; ?>
						  	<?php if(get_field('venue_name')) : ?>
						    <tr>
							    <td>Venue</td>
							    <td><?php the_field('venue_name') ?></td>
						    </tr>
						  <? endif; ?>
						  	<?php if(get_field('address_one')) : ?>
						    <tr>
							    <td>Address One</td>
							    <td><?php the_field('address_one') ?></td>
						    </tr>
						  <? endif; ?>
						  	<?php if(get_field('address_two')) : ?>
						    <tr>
							    <td>Address Two</td>
							    <td><?php the_field('address_two') ?></td>
						    </tr>
						  <? endif; ?>
						  	<?php if(get_field('address_three')) : ?>
						    <tr>
							    <td>Address Three</td>
							    <td><?php the_field('address_three') ?></td>
						    </tr>
						  <? endif; ?>
						  	<?php if(get_field('city')) : ?>
						    <tr>
							    <td>City</td>
							    <td><?php the_field('city') ?></td>
						    </tr>
						  <? endif; ?>
						  	<?php if(get_field('post_code')) : ?>
						    <tr>
							    <td>Post Code</td>
							    <td><?php the_field('post_code') ?></td>
						    </tr>
						  <? endif; ?>
						  	<?php if(get_field('country')) : ?>
						    <tr>
							    <td>Country</td>
							    <td><?php the_field('country') ?></td>
						    </tr>
						  <? endif; ?>
						  	<?php if(get_field('cost')) : ?>
						    <tr>
							    <td>Cost</td>
							    <td><?php the_field('cost') ?></td>
						    </tr>
						  <? endif; ?>
						  	<?php if(get_field('facebook_link')) : ?>
						    <tr>
							    <td>Facebook</td>
							    <td><?php the_field('facebook_link') ?></td>
						    </tr>
						  <? endif; ?>

						  	<?php if(get_field('website_link')) : ?>
						    <tr>
							    <td>Website</td>
							    <td><?php the_field('website_link') ?></td>
						    </tr>
						  <? endif; ?>

						  </table>
						</div>
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

<?php get_footer() ?>