<?php
/*
   Template Name: EasTheme - Anime List
*/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$list = isset($_GET['list']);
$reset = isset($_GET['title']);

get_header(); ?>
<div id="content" class="content-separate">
   <div id="primary" class="content-area">
      <main id="main" class="site-main post-body widget_senction" role="main">
         <div class="widget-title">
            <h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
            <span class="filterss"><i class="fa fa-sort mr5"></i> <?php _d('Filter'); ?></span>
            <?php if($reset){
            ?>
            <span class="reset"><a href="<?php the_permalink(); ?>"><i class="fa fa-redo-alt"></i> <?php _d('Reset'); ?></a></span>
          <?php } ?>
               <div class="mode_post">
                  <?php if(!$list){ ?>
                  <a href="<?php the_permalink(); ?>?list" class="enable"><i class="fa fa-list" aria-hidden="true"></i></a>
                  <a href="<?php the_permalink(); ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                  <?php } else { ?>
                  <a href="<?php the_permalink(); ?>?list"><i class="fa fa-list" aria-hidden="true"></i></a>
                  <a href="<?php the_permalink(); ?>" class="enable"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                  <?php } ?>
               </div>
         </div>
         <?php get_template_part('template/page/page','list'); ?>
      </main>
      </div>
   <?php sidebar_page(); ?>
</div>
<?php get_footer(); ?>
