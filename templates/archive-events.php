<?php 
/*
 * 
 * Simple Events archive view
*/
?>


<?php get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<div class="wrapper-main" role="main">

	<div class="<?= CONTAINER_CLASSES; ?>">
	
		<? get_template_part('parts/breadcrumb'); // load breadcrumb ?>
	
		<div class="<?= ROW_CLASSES ?>">

			<div class="<?= MAIN_SIZE ?>">

				<header class="page-header archive-header" itemprop="name">
					
					<h1 class="archive-title h1">Upcoming Events</h1>
					
				</header>
				
				<p class="lead">This is the events archive view found in simple-events/templates</p>
								
				<?php get_template_part('parts/loop-posts') // load the posts loop ?>

			</div><!-- MAIN_SIZE -->

			<? get_template_part('parts/sidebar'); // right sidebar ?>

		</div><!-- /ROW_CLASSES -->	

	</div><!-- /CONTAINER_CLASSES -->

</div><!-- /main -->	

<?php get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>