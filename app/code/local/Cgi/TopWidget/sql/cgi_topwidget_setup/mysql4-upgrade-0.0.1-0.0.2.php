<?php
$widgetParameters = array(
    'product_count' => '3',
    'title' => 'Top products:',
    'template' => 'topwidget/top_list.phtml'
);

$instance = Mage::getModel('widget/widget_instance')->setData(array(
    'type' => 'topwidget/top3product',
    'package_theme' => 'naro/my_theme', // has to match the concrete theme containing the template
    'title' => 'Top3 product',
    'store_ids' => '0', // or comma separated list of ids
    'widget_parameters' => serialize($widgetParameters)
    )
)->save();