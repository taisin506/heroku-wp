<?php
/**
 * @since 2.4.2
 * @version 2.0
 */
CSF::createSection(DOO_OPTIONS,
    array(
        'title'  => __d('TV Shows'),
        'parent' => 'homepage',
        'icon'   => 'fa fa-minus',
        'fields' => array(
            array(
                'id'      => 'tvtitle',
                'type'    => 'text',
                'title'   => __d('Module Title'),
                'default' => __d('TV Shows'),
                'subtitle'    => __d('Add title to show')
            ),
            array(
                'id'      => 'tvitems',
                'type'    => 'text',
                'title'   => __d('Items number'),
                'subtitle' => __d('Number of items to show'),
                'default' => '10',
                'attributes' => array(
                    'type' => 'number',
                    'style' => 'width:100px'
                )
            ),
            array(
                'id'    => 'tvmodcontrol',
                'type'  => 'checkbox',
                'title' => __d('Slider control'),
                'subtitle'  => __d('Check to enable option.'),
                'options' => array(
                    'slider' => __d('Activate Slider'),
                    'autopl' => __d('Auto play Slider')
                ),
                'default'=> array('slider')
            ),
            array(
                'id'      => 'tvmodorderby',
                'type'    => 'select',
                'title'   => __d('Order by'),
                'subtitle' => __d('Order items for this module'),
                'default' => 'date',
                'options' => array(
                    'date'     => __d('Post date'),
                    'title'    => __d('Post title'),
                    'modified' => __d('Last modified'),
                    'rand'     => __d('Random entry'),
                )
            ),
            array(
                'id'    => 'tvmodorder',
                'type'  => 'radio',
                'title' => __d('Order'),
                'options' => array(
                    'DESC' => __d('Descending'),
                    'ASC'  => __d('Ascending')
                ),
                'dependency' => array('tvmodorderby','!=','rand'),
                'default' => 'DESC'
            )
        )
    )
);
