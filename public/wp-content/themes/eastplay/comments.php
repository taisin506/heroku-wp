<?php
/*
* -------------------------------------------------------------------------------------
* @author: EasTheme Team
* @author URI: https://eastheme.com
* @copyright: (c) 2020 EasTheme. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 1.0.1
*
*/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( post_password_required() ) {
	return;
}
?>
<div class="comments-area">
	<div class="comments-padding">

		<?php if ( have_comments() ) : ?>
			<h2 class="comments-title">
				<?php
				if ( 1 === get_comments_number() ) {
					printf(

						__( 'One thought on &ldquo;%s&rdquo;', '' ),
						'<span>' . get_the_title() . '</span>'
					);
				} else {
					printf(

						_n( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), '' ),
						number_format_i18n( get_comments_number() ),
						'<span>' . get_the_title() . '</span>'
					);
				}
				?>
			</h2>

			<ol class="commentlist">
				<?php
				wp_list_comments(
					array(
						'style'    => 'ol',
					)
				);
				?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-below" class="navigation" role="navigation">
				<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', '' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', '' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', '' ) ); ?></div>
			</nav>
		<?php endif; ?>

		<?php
		if ( ! comments_open() && get_comments_number() ) :
			?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'twentytwelve' ); ?></p>
	<?php endif; ?>

<?php endif; ?>

<?php comment_form(); ?>
</div>
</div>
