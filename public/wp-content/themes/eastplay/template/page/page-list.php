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

?>
<div class="filtersearch">
   <form action="<?php the_permalink(); ?>" method="GET">
      <table width="100%">
         <tbody>
           <tr>
              <td class="filter_title">Search</td>
              <td class="filter_act">
              <?php EastPlay::form_search('title', 'Search...'); ?>
              </td>
           </tr>
            <tr>
               <td class="filter_title">Sort by</td>
               <td class="filter_act sortarea">
                  <ul class="filter-sort">
                    <?php
                       $array_order = array(
                         'favorite' => '<i class="fas fa-heart"></i> Most Favorite',
                         'update' => '<i class="fas fa-clock"></i> Latest Update',
                         'latest' => '<i class="fas fa-plus-circle"></i> Latest Added',
                         'popular' => '<i class="fas fa-fire"></i> Popular',
                         'rating' => '<i class="fas fa-star"></i> Rating',
                       );
                       EastPlay::form_radio($array_order,'order',1); ?>
                  </ul>
               </td>
            </tr>
            <div class="dual_form">
            <tr class="dual">
               <td class="filter_title">Status</td>
               <td class="filter_act">
                  <?php
                     $array_status = array(
                       'Currently Airing' => 'Currently Airing',
                       'Finished Airing' => 'Finished Airing'
                     );
                     EastPlay::form_radio($array_status,'status',0); ?>
                </td>
            </tr>
            <tr class="dual">
               <td class="filter_title">Type</td>
               <td class="filter_act">
                 <?php
                   $array_type = array(
                    'TV' => 'TV',
     								'OVA' => 'OVA',
     								'ONA' => 'ONA',
     								'Special' => 'Special',
     								'Movie' => 'Movie'
                   );
                   EastPlay::form_radio($array_type,'type',0); ?>
               </td>
            </tr>
          </div>

            <tr class="filter_tax">
               <td class="filter_title">Genre</td>
               <td class="filter_act">
                  <?php EastPlay::form_tax('genre','genre'); ?>
            </tr>
            <tr class="filter_tax">
               <td class="filter_title">Season</td>
               <td class="filter_act">
                  <?php EastPlay::form_tax('season','season'); ?>
               </td>
            </tr>
            <tr class="filter_tax">
               <td class="filter_title">Studio</td>
               <td class="filter_act">
                  <?php EastPlay::form_tax('studio','studio'); ?>
               </td>
            </tr>

         </tbody>
      </table>
      <div class="btnfilter"><button type="submit" class="filterbtn"><?php _d('Search'); ?></button></div>
   </form>
</div>
<?php if (!isset($_GET[ 'list'])) { EastPlay::filter_search(); } else { EastPlay::list('1000000'); } ?>

<script type="text/javascript">
          $(document).ready(function() {
              $(".letr").click(function() {
                var href = $(this).attr('href');
              var res = href.replace("#", "");
  $(".listbar[name='"+res+"']").addClass('flashit');

                  setTimeout(function(){
    $(".listbar[name='"+res+"']").removeClass("flashit");
},1000);

$('html, body').animate({
     scrollTop: $(".listbar[name='"+res+"']").offset().top - 70
 }, 100);
              });
          });
</script>
<style>
.widget_senction .widget-title{margin-bottom: 0px}.relat {margin-top: 10px;}
</style>
