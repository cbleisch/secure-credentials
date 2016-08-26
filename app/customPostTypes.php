<?php

/** @var  \Herbert\Framework\Application $container */

// use SecureCredentials\CustomPostTypes\SecureCredential;

// Register SecureCredential CPT
// (new SecureCredential)->register();
// 
// Register Custom Post Type
function event_cpt() {

    $labels = [
        'name'                => _x( 'SecureCredentials', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'SecureCredentials', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'SecureCredential', 'text_domain' ),
        'name_admin_bar'      => __( 'SecureCredential', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Event:', 'text_domain' ),
        'all_items'           => __( 'All SecureCredentials', 'text_domain' ),
        'add_new_item'        => __( 'Add New SecureCredentials', 'text_domain' ),
        'add_new'             => __( 'Add New', 'text_domain' ),
        'new_item'            => __( 'New SecureCredentials', 'text_domain' ),
        'edit_item'           => __( 'Edit SecureCredentials', 'text_domain' ),
        'update_item'         => __( 'Update SecureCredentials', 'text_domain' ),
        'view_item'           => __( 'View SecureCredentials', 'text_domain' ),
        'search_items'        => __( 'Search SecureCredentials', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    ];
    $rewrite = [
        'slug'                => 'securecredentials',
        'with_front'          => true,
        'pages'               => true,
        'feeds'               => true,
    ];
    $args = [
        'label'               => __( 'SecureCredentials', 'text_domain' ),
        'description'         => __( 'List of SecureCredentials', 'text_domain' ),
        'labels'              => $labels,
        'supports'            => array( ),
        'taxonomies'          => array( 'category', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'rewrite'             => $rewrite,
        'capability_type'     => 'page',
    ];
    register_post_type( 'SecureCredentials', $args );

}

// Hook into the 'init' action
add_action( 'init', 'event_cpt', 0 );