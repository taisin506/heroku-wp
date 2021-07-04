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

$cms = get_option('commentssystem');

echo '<div class="whites comments widget_senction">';
echo '<div class="commentarea" id="comments">';

echo '<div class="widget-title">';
echo '<h3>'.__d('Comments').'</h3>';
echo '</div>';

if($cms == 'dq'){
  echo '<div id="disqus_thread"></div>';
}
else{
  comments_template('', true);
}

echo '</div>';
echo '</div>';
