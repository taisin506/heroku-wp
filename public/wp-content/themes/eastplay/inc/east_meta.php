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

function animeseries_metabox() {

wp_nonce_field( 'east_anime_meta', 'east_anime_meta_nonce' );

$meta = array(
					array(
							'name'   => 'Generate Data',
							'id'     => 'east_malid',
							'type'   => 'generator',
							'ldesc'   => __d('Generate data from myanimelist.net')
					),
					array(
							'name'   => 'Cover',
							'id'     => 'east_cover',
							'type'   => 'upload',
							'ldesc'   => __d('Input cover')
					),
					array(
							'name'   => 'Thumbnail',
							'id'     => 'east_thumbnail',
							'type'   => 'upload',
							'ldesc'   => __d('Input thumbnail')
					),
					array(
							'name'   => 'Japanese',
							'id'     => 'east_japanese',
							'type'   => 'text',
							'ldesc'   => __d('Input japanese title')
					),
					array(
							'name'   => 'Synonyms',
							'id'     => 'east_synonyms',
							'type'   => 'text',
							'ldesc'   => __d('Input synonyms title')
					),
					array(
							'name'   => 'English',
							'id'     => 'east_english',
							'type'   => 'text',
							'ldesc'   => __d('Input english title')
					),
					array(
							'name'   => 'Trailer',
							'id'     => 'east_trailer',
							'type'   => 'text',
							'ldesc'   => __d('Input trailer')
					),
					array(
							'name'   => 'Status',
							'id'     => 'east_status',
							'type'   => 'select',
							'ldesc'   => __d('Select status'),
							'option' => array(
								'Currently Airing' => 'Currently Airing',
								'Finished Airing' => 'Finished Airing'
							)
					),
					array(
							'name'   => 'Type',
							'id'     => 'east_type',
							'type'   => 'select',
							'ldesc'   => __d('Select type'),
							'option' => array(
								'TV' => 'TV',
								'OVA' => 'OVA',
								'ONA' => 'ONA',
								'Special' => 'Special',
								'Movie' => 'Movie'
							)
					),
					array(
							'name'   => 'Source',
							'id'     => 'east_source',
							'type'   => 'text',
							'ldesc'   => __d('Input source')
					),
					array(
							'name'   => 'Rating',
							'id'     => 'east_score',
							'id2'    => 'east_users',
							'type'   => 'dual_text',
							'ldesc'   => __d('Averages / votes')
					),
					array(
							'name'   => 'Duration',
							'id'     => 'east_duration',
							'type'   => 'text',
							'ldesc'   => __d('Input duration')
					),
					array(
							'name'   => 'Release Date',
							'id'     => 'east_date',
							'type'   => 'text',
							'ldesc'   => __d('Input release date')
					),
					array(
							'name'   => 'Total Episode',
							'id'     => 'east_totalepisode',
							'type'   => 'text',
							'ldesc'   => __d('Input total episode')
					),
					array(
							'name'   => 'Schedula Day',
							'id'     => 'east_schedule',
							'type'   => 'select',
							'ldesc'   => __d('Select day'),
							'option' => array(
								'Unscheduled' => 'Unscheduled',
								'Sunday' => 'Sunday',
								'Monday' => 'Monday',
								'Tuesday' => 'Tuesday',
								'Wednesday' => 'Wednesday',
								'Thursday' => 'Thursday',
								'Friday' => 'Friday',
								'Saturday' => 'Saturday',
							)
					),
					array(
							'name'   => 'Schedule Time',
							'id'     => 'east_time',
							'type'   => 'time',
							'ldesc'   => __d('Input time update')
					),
				);

				echo "<div class='eastheme-meta-info'>";
				echo "<div class='loadingmal' style='display:none'><i class='fa fa-spinner fa-spin'></i></div>";
				echo "<div class='metabox-holder east-meta-metabox-common-fields meta-info-series'>";

					  	new EastMetaField($meta);

				  echo '</div></div>';

		}

		function east_episode_meta_content() {

			wp_nonce_field( 'east_episode_meta', 'east_episode_meta_nonce' );

			$meta = array(

				array(
						'name'   => 'Episode',
						'id'     => 'east_episode',
						'type'   => 'text',
						'ldesc'   => __d('Input episode')
				),
				array(
						'name'   => 'Type',
						'id'     => 'east_typesbdb',
						'type'   => 'select',
						'ldesc'   => __d('Input type'),
						'option' => array(
							'sub' => 'SUB',
							'dub' => 'DUB'
						)
				),
				array(
						'name'   => 'Anime Series',
						'id'     => 'east_series',
						'type'   => 'select_query',
						'ldesc'   => __d('Select anime series'),
						'post_type' => 'anime'
				),
			);

			new EastMetaField($meta);

		}

?>
