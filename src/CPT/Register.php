<?php
namespace Carawebs\WPCustomContent\CPT;

/**
* Class to register CPTs
*/
class Register {

    /**
    * Slug to register the CPT
    * @var string
    */
    private $slug;

    /**
    * Singular name, for labelling purposes - may contain spaces
    * @var string
    */
    private $singular_name;

    /**
    * Plural name, for labelling purposes - may contain spaces
    * @var string
    */
    private $plural_name;

    /**
    * Labels for this CPT
    * @var array
    */
    private $labels;

    public function __construct ( $slug, $singular_name, $plural_name ) {

        $this->slug = $slug;
        $this->singular_name = $singular_name;
        $this->plural = $plural_name;
        $this->set_labels();
        $this->custom_messages();

    }

    /**
    * Set labels for the CPT
    *
    * These will be dependent upon the chosen slug/name, so they probably don't need
    * to be overridden in the child class.
    */
    protected function set_labels () {

        $this->labels = [
            'name'                => _x( ucfirst( $this->plural ), 'Post Type General Name', 'CARAWEBS' ),
            'singular_name'       => _x( ucfirst( $this->singular_name ), 'Post Type Singular Name', 'CARAWEBS' ),
            'menu_name'           => __( ucfirst( $this->plural ), 'CARAWEBS' ),
            'name_admin_bar'      => __( ucfirst( $this->singular_name ), 'CARAWEBS' ),
            'parent_item_colon'   => __( 'Parent' . ucfirst( $this->singular_name ) . ':', 'CARAWEBS' ),
            'all_items'           => __( 'All ' . ucfirst( $this->plural ), 'CARAWEBS' ),
            'add_new_item'        => __( 'Add New ' . ucfirst( $this->singular_name ), 'CARAWEBS' ),
            'add_new'             => __( 'Add New', 'CARAWEBS' ),
            'new_item'            => __( 'New ' . ucfirst( $this->singular_name ), 'CARAWEBS' ),
            'edit_item'           => __( 'Edit ' . ucfirst( $this->singular_name ), 'CARAWEBS' ),
            'update_item'         => __( 'Update ' . ucfirst( $this->singular_name ), 'CARAWEBS' ),
            'view_item'           => __( 'View ' . ucfirst( $this->singular_name ), 'CARAWEBS' ),
            'search_items'        => __( 'Search ' . ucfirst( $this->plural ), 'CARAWEBS' ),
            'not_found'           => __( 'Not found', 'CARAWEBS' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'CARAWEBS' ),

        ];
    }

    /**
    * Register the CPT
    *
    * Arguments for `register_post_type()` can be overridden from the child class.
    *
    * @param  array $override Arguments for `register_post_type()` to override defaults
    * @return void
    */
    public function register( array $override = [] ) {

        $defaults = [
            'label'               => __( ucfirst( $this->singular_name ), 'CARAWEBS' ),
            'description'         => __( ucfirst( $this->singular_name ) . ' posts', 'CARAWEBS' ),
            'labels'              => $this->labels,
            'supports'            => ['title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'page-attributes'],
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_icon'           => 'dashicons-admin-post',
            'menu_position'       => 5,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        ];

        $args = is_array( $override ) ? array_merge( $defaults, $override ) : $default;

        register_post_type( $this->slug, $args );

    }

    /**
    * Custom messages for the Custom Post Type being registered
    *
    * These will be dependent upon the CPT slug/name, so don't need to be overridden
    * from the child class.
    *
    * @param  array $messages Default messages to override
    * @return array $messages Filtered messages
    */
    public function messages( $messages ) {

        global $post;

        $permalink = get_permalink( $post );
        $capname = ucfirst( $this->singular_name );

        $messages[$this->slug] = [

            0 => '', // Unused. Messages start at index 1.
            1 => sprintf( __('%s updated. <a target="_blank" href="%s">View %s</a>', 'CARAWEBS'),
                $capname,
                esc_url( $permalink ),
                $this->singular_name
            ),
            2 => __('Custom field updated.', 'CARAWEBS'),
            3 => __('Custom field deleted.', 'CARAWEBS'),
            4 => sprintf(__('%s updated.', 'CARAWEBS'), ucfirst($this->singular_name ) ),
            5 => isset( $_GET['revision'])
                ? sprintf( __('%s restored to revision from %s', 'CARAWEBS'),
                $capname,
                wp_post_revision_title( (int) $_GET['revision'], false )
                )
                : false,
            6 => sprintf( __('%s published. <a href="%s">View %s</a>', 'CARAWEBS'),
                $capname,
                esc_url( $permalink ),
                $this->singular_name
            ),
            7 => sprintf( __('%s saved.', 'CARAWEBS'),
                $capname
            ),
            8 => sprintf( __('%s submitted. <a target="_blank" href="%s">Preview %s</a>', 'CARAWEBS'),
                $capname,
                esc_url( add_query_arg( 'preview', 'true', $permalink ) ),
                $this->singular_name
            ),
            9 => sprintf( __('%s scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview zombie</a>', 'CARAWEBS'),
                $capname,
                date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), // translators: Publish box date format, see http://php.net/date
                esc_url( $permalink ),
                $this->singular_name
            ),
            10 => sprintf( __('%s draft updated. <a target="_blank" href="%s">Preview $s</a>', 'CARAWEBS'),
                $capname,
                esc_url( add_query_arg( 'preview', 'true', $permalink ) ),#
                $this->singular_name
            ),

        ];

        return $messages;

    }

    /**
    * Filter the CPT messages
    *
    * @return void
    *
    */
    public function custom_messages() {

        add_filter( 'post_updated_messages', [ $this, 'messages'] );

    }

}
