<?php
/*
* -------------------------------------------------------------------------------------
* @author: EasTheme
* @author URI: https://eastheme.com
* @copyright: (c) 2019 EasTheme. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 1.0.1
*
*/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$related = get_option('relatedblog');
$logodesktop = get_option('logo');
?>
<div id="infoarea">
   <div class="post-body">
      <div class="widget_senction">
         <div class="thumb-blog">
            <?php the_post_thumbnail(); ?>
         </div>
         <div class="blogbody">
            <?php  if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID();?>" <?php post_class();?> itemscope="itemscope" itemtype="http://schema.org/Article">
               <link itemprop="mainEntityOfPage" href="<?php the_permalink(); ?>" />
               <time itemprop="dateModified" datetime="<?php the_modified_date('c'); ?>"></time>
               <div class="thumb" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                  <meta itemprop="url" content="<?php echo get_the_post_thumbnail_url(); ?>">
                  <meta itemprop="width" content="190">
                  <meta itemprop="height" content="260">
               </div>
               <span style="display: none;" itemprop="publisher" itemscope="" itemtype="https://schema.org/Organization">
                  <span style="display: none;" itemprop="logo" itemscope="" itemtype="https://schema.org/ImageObject">
                     <meta itemprop="url" content="<?php echo $logodesktop; ?>">
                  </span>
                  <meta itemprop="name" content="<?php bloginfo('name'); ?>">
               </span>
               <?php  $blog_cat = term_sep(get_the_ID(),'blog-category'); if($blog_cat) { ?>
               <div class="post_taxs">
                  <?php echo $blog_cat;   $post_tags = get_the_tags();
                     if ($post_tags) {
                         foreach ($post_tags as $tag) {
                            echo strtolower(' <a href="' . get_tag_link($tag->term_id) . '" rel="tag" class="posts_tags">' . $tag->name . '</a>');
                        }
                     } ?>
               </div>
               <?php } ?>
               <div class="sttle">
                  <?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>
                  <div class="authdet">
                     <i class="fa fa-user-circle"></i>
                     <span itemprop="author" itemscope itemtype="https://schema.org/Person" class="author vcard"><span itemprop="name"><?php the_author();?></span></span> - <span class="date"><time itemprop="datePublished" class="entry-date published" datetime="<?php the_time('c'); ?>"><?php the_date(); ?></time></span>
                  </div>
               </div>
               <div class="entry-content content-post">
                  <?php the_content(); endwhile; endif; ?>
               </div>
               <div class="sds">
                  <div class="sharesection">
                     <center>
                        <b><?php _d('Share to your friends!');?></b>
                        <?php east_social_share(get_the_ID());?>
                     </center>
                  </div>
               </div>
            </article>
         </div>
      </div>
      <?php
         east_breadcrumbs_blog(get_the_ID());
         if($related) { get_template_part('template/single/related_blog'); }
         get_template_part('template/single/comments'); ?>
   </div>
   <?php get_template_part('sidebar','blog'); ?>
</div>
<?php get_footer(); ?>
