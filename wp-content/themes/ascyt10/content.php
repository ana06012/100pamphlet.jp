<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>


	<?php if ( is_single() ) : ?>

	<div class="entry-meta">
		<?php the_time('Y年m月d日'); ?>
	</div><!-- .entry-meta -->
	<?php else : ?>
	<ul class="entry-title">
		<li><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></li>
	</ul>
	<?php endif; // is_single() ?>

	<?php if ( comments_open() ) : ?>
	<div class="comments-link">
		<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'twentytwelve' ) . '</span>', __( '1 Reply', 'twentytwelve' ), __( '% Replies', 'twentytwelve' ) ); ?>
	</div><!-- .comments-link -->
	<?php endif; // comments_open() ?>

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

