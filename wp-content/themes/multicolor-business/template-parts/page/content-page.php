<?php
/**
 * Template part for displaying page content in page.php
 * @package WordPress
 * @subpackage multicolor-business
 * @since 1.0
 * @version 0.1
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header role="banner" class="entry-header">
		<?php esc_html(the_title( '<h1 class="entry-title">', '</h1>' )); ?>
		<?php multicolor_business_edit_link( get_the_ID() ); ?>
	</header>
	<div class="entry-content">
		<?php the_post_thumbnail(); ?>
		<?php			
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'multicolor-business' ),
				'after'  => '</div>',
			) );
		?>
	</div>
</article>