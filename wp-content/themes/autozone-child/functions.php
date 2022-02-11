<?php
/************* LOAD REQUIRED SCRIPTS AND STYLES *************/
function pixchild_loadCss(){
		wp_enqueue_style('style', get_stylesheet_uri() );
}
add_action('wp_enqueue_scripts', 'pixchild_loadCss'); //Load All Css

/************* 

RENAME AUTOS POST-TYPE SLUG

1. Rename 'auto'
2. Resave Permalink Settings in admin panel

*************/
/*
add_filter( 'register_post_type_args', 'rename_post_type_slug', 10, 2 );
function rename_post_type_slug( $args, $post_type ) {

    if ( 'pixad-autos' === $post_type ) {
        $args['rewrite']['slug'] = 'auto';  // <-- RENAME HERE
    }
    return $args;
}
*/
/* RENAME AUTO-MODEL TAXONOMY SLUG */


/*

function rename_taxonomy_type_slug( $taxonomy, $object_type, $args ){
    if( 'auto-model' == $taxonomy ){ // Instead of the "auto-model", add current slug, which you want to change.
        remove_action( current_action(), __FUNCTION__ );
        $args['rewrite'] = array( 'slug' => 'buy-a-car' ); // Instead of the "buy-a-car", add a new slug name.
        register_taxonomy( $taxonomy, $object_type, $args );
    }
}
add_action( 'registered_taxonomy', 'rename_taxonomy_type_slug', 10, 3 );

*/