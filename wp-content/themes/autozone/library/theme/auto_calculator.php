<?php

add_action('wp_enqueue_scripts', 'autozone_load_calculator_scripts');

function autozone_load_calculator_scripts()
{
    wp_enqueue_script('autozone-calculator', get_template_directory_uri() . '/js/calculator.js', array('jquery') , '1.0', true);
}