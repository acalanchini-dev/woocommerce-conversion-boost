<?php

/**
* The public-facing functionality of the plugin.
*
* @link       ac.com
* @since      1.0.0
*
* @package    Wccb
* @subpackage Wccb/public
*/

/**
* The public-facing functionality of the plugin.
*
* Defines the plugin name, version, and two examples hooks for how to
* enqueue the public-facing stylesheet and JavaScript.
*
* @package    Wccb
* @subpackage Wccb/public
* @author     Alessio Calanchini <ac.calanchini@gmail.com>
*/

class Wccb_Public {

    /**
    * The ID of this plugin.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $plugin_name    The ID of this plugin.
    */
    private $plugin_name;

    /**
    * The version of this plugin.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $version    The current version of this plugin.
    */
    private $version;

    public static $options;

    /**
    * Initialize the class and set its properties.
    *
    * @since    1.0.0
    * @param      string    $plugin_name       The name of the plugin.
    * @param      string    $version    The version of this plugin.
    */

    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        self::$options = get_option( 'wccb_options' );

        if ( get_theme_mod( 'active_live_search' ) == 1 ) {
            add_action( 'wp_ajax_data_fetch', array( $this, 'data_fetch' ) );
            add_action( 'wp_ajax_nopriv_data_fetch', array( $this, 'data_fetch' ) );
            //add_action( 'get_product_search_form', array( $this, 'woo_custom_product_searchform' ) );

        }
        add_shortcode( 'live_search', array( $this, 'wccb_live_search_shortcode' ) );
    }

    /**
    * Register the stylesheets for the public-facing side of the site.
    *
    * @since    1.0.0
    */

    public function enqueue_styles() {

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wccb-public.css', array(), $this->version, 'all' );

    }

    /**
    * Register the JavaScript for the public-facing side of the site.
    *
    * @since    1.0.0
    */

    public function enqueue_scripts() {

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wccb-public.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( 'wccb-ajax-search', plugin_dir_url( __FILE__ ) . 'js/ajax-search.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( 'wccb-ajax-search', 'ajax_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }

    // To change add to cart text on product archives( Collection ) page

    function wccb_custom_shop_page_add_to_cart_text() {
        global $product;

        $simple_products =  self::$options[ 'wccb_simple_product_add_to_cart_button_text' ];
        $variable_products = self::$options[ 'wccb_variable_product_add_to_cart_button_text' ];
        $gruped_products = self::$options[ 'wccb_gruped_product_add_to_cart_button_text' ];

        if ( $product->is_type( 'simple' ) ) {
            if ( ! empty( $simple_products ) ) {
                $text = self::$options[ 'wccb_simple_product_add_to_cart_button_text' ];
            } else {
                $text = 'Add to cart';
            }
        }
        if ( $product->is_type( 'variable' ) ) {
            if ( ! empty( $variable_products ) ) {
                $text = self::$options[ 'wccb_variable_product_add_to_cart_button_text' ];
            } else {
                $text = 'Add to cart';
            }
        }

        if ( $product->is_type( 'grouped' ) ) {
            if ( ! empty( $gruped_products ) ) {
                $text = self::$options[ 'wccb_gruped_product_add_to_cart_button_text' ];
            } else {
                $text = 'Add to cart';
            }
        }

        return __( $text, 'woocommerce' );

    }

    public function wccb_custom_single_product_add_to_cart_text() {
        global $product;

        $simple_products =  self::$options[ 'wccb_simple_product_add_to_cart_button_text' ];
        $variable_products = self::$options[ 'wccb_variable_product_add_to_cart_button_text' ];
        $gruped_products = self::$options[ 'wccb_gruped_product_add_to_cart_button_text' ];
       

        if ( $product->is_type( 'simple' ) ) {
            if ( ! empty( $simple_products ) ) {
                $text = self::$options[ 'wccb_simple_product_add_to_cart_button_text' ];
            } else {
                $text = 'Add to cart';
            }
        }
        if ( $product->is_type( 'variable' ) ) {
            if ( ! empty( $variable_products ) ) {
                $text = self::$options[ 'wccb_variable_product_add_to_cart_button_text' ];
            } else {
                $text = 'Add to cart';
            }
        }

        if ( $product->is_type( 'grouped' ) ) {
            if ( ! empty( $gruped_products ) ) {
                $text = self::$options[ 'wccb_gruped_product_add_to_cart_button_text' ];
            } else {
                $text = 'Add to cart';
            }
        }

        return __( $text, 'woocommerce' );
    }

     public function wccb_custom_product_add_to_cart_text() {
        global $product;

        $simple_products = get_theme_mod('edit_simple_product_text_add_to_cart');
        $variable_products = get_theme_mod('edit_variable_product_text_add_to_cart');
        $gruped_products =  get_theme_mod('edit_grouped_product_text_add_to_cart');
       

        if ( $product->is_type( 'simple' ) ) {
            if ( ! empty( $simple_products ) ) {
                $text = $simple_products;
            } else {
                $text = 'Add to cart';
            }
        }
        if ( $product->is_type( 'variable' ) ) {
            if ( ! empty( $variable_products ) ) {
                $text =  $variable_products;
            } else {
                $text = 'Add to cart';
            }
        }

        if ( $product->is_type( 'grouped' ) ) {
            if ( ! empty( $gruped_products ) ) {
                $text = $gruped_products;
            } else {
                $text = 'Add to cart';
            }
        }

        return __( $text, 'woocommerce' );
    }

    /**
    * Apply the shop loop sale flash text customization.
    *
    * @since 1.0.0
    *
    * @param string $html add to cart flash HTML
    * @param \WP_Post $_ post object, unused
    * @param \WC_Product $product the prdouct object
    * @return string updated HTML
    */

    public function customize_woocommerce_sale_flash( $html, $_, $product ) {

        $text = '';

        if ( is_product() ) {

            $text = get_theme_mod( 'edit_text_sales_badge', 'sale' );

        } elseif ( ! is_product() ) {

            $text = get_theme_mod( 'edit_text_sales_badge', 'sale' );

        }

        // only get sales percentages when we should be replacing text
        // check 'false' specifically since the position could be 0
        if ( false !== strpos( $text, '{percent}' ) ) {

            $percent = $this->get_sale_percentage( $product );
            $text    = str_replace( '{percent}', "{$percent}%", $text );
        }

        return ! empty( $text ) ? "<span class='onsale'>{$text}</span>" : $html;
    }

    /**
    * Helper to get the percent discount for a product on sale.
    *
    * @since 2.5.0
    *
    * @param \WC_Product $product product instance
    * @return string percentage discount
    */

    private function get_sale_percentage( $product ) {

        $child_sale_percents = array();
        $percentage          = '0';

        if ( $product->is_type( 'grouped' ) || $product->is_type( 'variable' ) ) {

            foreach ( $product->get_children() as $child_id ) {

                $child = wc_get_product( $child_id );

                if ( $child->is_on_sale() ) {

                    $regular_price         = $child->get_regular_price();
                    $sale_price            = $child->get_sale_price();
                    $child_sale_percents[] = $this->calculate_sale_percentage( $regular_price, $sale_price );
                }
            }

            // filter out duplicate values
            $child_sale_percents = array_unique( $child_sale_percents );

            // only add 'up to' if there's > 1 percentage possible
			if ( ! empty ( $child_sale_percents ) ) {

				/* translators: Placeholder: %s - sale percentage */
				$percentage = count( $child_sale_percents ) > 1 ? sprintf( esc_html__( 'up to %s', 'woocommerce-customizer' ), max( $child_sale_percents ) ) : current( $child_sale_percents );
			}

		} else {

			$percentage = $this->calculate_sale_percentage( $product->get_regular_price(), $product->get_sale_price() );
		}

		return $percentage;
	}


/**
	 * Calculates a sales percentage difference given regular and sale prices for a product.
	 *
	 * @since 2.5.0
	 *
	 * @param string $regular_price product regular price
	 * @param string $sale_price product sale price
	 * @return float percentage difference
	 */
	private function calculate_sale_percentage( $regular_price, $sale_price ) {

		$percent = 0;
		$regular = (float) $regular_price;
		$sale    = (float) $sale_price;

		// in case of free products so we don't divide by 0
            if ( $regular ) {
                $percent = round( ( ( $regular - $sale ) / $regular ) * 100 );
            }

            return $percent;
        }

        public static function wccb_header_output() {

            require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/header-output-customizer.php';

        }

        public static function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {
            $return = '';
            $mod = get_theme_mod( $mod_name );
            if ( ! empty( $mod ) ) {
                $return = sprintf( '%s { %s:%s; }',
                $selector,
                $style,
                $prefix.$mod.$postfix
            );
            if ( $echo ) {
                echo $return;
            }
        }
        return $return;
    }

    function data_fetch() {
        $terms = get_terms( 'product_cat', array(
            'name__like' => esc_attr( $_POST[ 'keyword' ] ),
            'hide_empty' => true // Optional
        ) );

        if ( count( $terms ) > 0 ) {
            foreach ( $terms as $term ) {
                echo ' <a href="' . esc_url( get_term_link( $term ) ) . '" title="' . esc_attr( $term->name ) . '"><small>Categoria: </small>';
                echo esc_html( $term->name );
                echo '</a>';

            }
        }

        $the_query = new WP_Query( array( 'posts_per_page' => 5, 's' => esc_attr( $_POST[ 'keyword' ] ), 'post_type' => 'product' ) );
        if ( $the_query->have_posts() ) :
        while( $the_query->have_posts() ): $the_query->the_post();
        ?>

        <a href = '<?php echo esc_url( post_permalink() ); ?>' class = 'product-search-item'>	<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'search-thumbnail', 'alt' => get_the_title() ) );
        ?><?php the_title();
        ?></a>

        <?php endwhile;
        wp_reset_postdata();
        else:
        echo '<p class="product-not-found">No Results Found</p>';
        endif;

        die();
    }

 
    // Add Shortcode live search

    public function wccb_live_search_shortcode() {

        $form = '<form class="nav-search__form" role="search" method="get" action="'. esc_url( admin_url( 'admin-ajax.php' ) ) .'">
          <button class="nav-search__icon"> <span class="icon icon-search"></span></button>
          <input class="nav-search__input" id="searchInput" type="text" onkeyup="fetchResults();" name="s" autocomplete="off">
          <div id="datafetch"></div>
        </form>';
        if ( get_theme_mod( 'active_live_search' ) == 1 ) {
            return $form;
        } else {
            return;
        }
    }

}