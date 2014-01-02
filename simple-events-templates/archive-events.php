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


					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


						<? // markup for post snippet, used in loops and queries ?>
						<article itemscope itemtype="http://schema.org/Event" <?php post_class(); ?>>

							<div class="row">

								<div class="col-md-2">
								  	<?php if(get_field('date')) : ?>
									    <?php the_field('date') ?>
  									<? endif; ?>
								</div>

								<div class="col-md-10">




									<header class="event-title">
										<h3 class="event-headline" itemprop="name"><a href="<?= get_permalink() ?>" title="<?php the_title(); ?>" class="post-permalink" itemprop="url"><?php the_title(); ?></a></h3>

										<h4><?php the_field('venue_name') ?>, <?php the_field('city') ?></h4>

									</header>

									<section class="event-excerpt">
										<p itemprop="description"><?= get_the_excerpt(); ?></p>
									</section>

									<footer class="event-footer">
										<?php get_template_part('parts/meta/readmore'); ?>
									</footer> <!-- end article footer -->

								</div><!-- end col md 10 -->


							</div><!-- end row -->

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
