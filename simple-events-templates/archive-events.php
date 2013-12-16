<?php 
/*
 * 
 * Simple Events archive view
*/
?>


<?php get_header() ?>

<div class="wrapper-main" role="main">

	<div class="<?= CONTAINER_CLASSES; ?>">
	
		<? get_template_part('parts/breadcrumb'); // load breadcrumb ?>
	
		<div class="<?= ROW_CLASSES ?>">

			<div class="<?= MAIN_SIZE ?>">

				<header class="page-header archive-header" itemprop="name">
					
					<h1 class="archive-title h1">Upcoming Events</h1>
					
				</header>
				
				<p class="lead">This is the events archive view found in simple-events/templates</p>
								
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


						<? // markup for post snippet, used in loops and queries ?>
						<article itemscope itemtype="http://schema.org/Event" <?php post_class(); ?>>
						
							<header class="event-title">
								<h2 class="event-headline" itemprop="name"><a href="<?= get_permalink() ?>" title="<?php the_title(); ?>" class="post-permalink" itemprop="url"><?php the_title(); ?></a></h2>
							</header>
							
							<section class="event-excerpt">
								<p itemprop="description"><?= get_the_excerpt(); ?></p>
							</section>	
							
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
								  	<?php if(get_field('city')) : ?>
								    <tr>
									    <td>City</td>
									    <td><?php the_field('city') ?></td>
								    </tr>
								  <? endif; ?>
								  	<?php if(get_field('country')) : ?>
								    <tr>
									    <td>Country</td>
									    <td><?php the_field('country') ?></td>
								    </tr>
								  <? endif; ?>

								  </table>
								</div>
							</section>
							
							<footer class="event-footer">
								<?php get_template_part('parts/meta/readmore'); ?>
							</footer> <!-- end article footer -->
						
						</article>
						<hr/>


					<?php endwhile; ?>
					
					<? elseif ( is_search() ) : // display an error if no search results are found ?>
						<div class="alert">No results found for '<?php echo get_search_query(); ?>'</div>
					<? else : ?>
						<div class="alert">There are no posts to display.</div>
					<?php endif; ?>
					
					<?php get_template_part('parts/pagination') // load the pagination part ?>
					
			</div><!-- MAIN_SIZE -->

			<? get_template_part('parts/sidebar'); // right sidebar ?>

		</div><!-- /ROW_CLASSES -->	

	</div><!-- /CONTAINER_CLASSES -->

</div><!-- /main -->	

<?php get_footer() ?>