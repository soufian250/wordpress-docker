<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

class The7_Query_Builder {

	/**
	 * @var array
	 */
	protected $query_args = array();

	/**
	 * @var array
	 */
	protected $tax_query = array();

	/**
	 * @var string
	 */
	protected $query_taxonomy = '';

	/**
	 * The7_Query_Builder constructor.
	 *
	 * @param array $query_args
	 */
	public function __construct( $query_args ) {
		$this->query_args = wp_parse_args(
			$query_args,
			[
				'posts_offset'                 => 0,
				'post_type'                    => 'post',
				'order'                        => 'desc',
				'orderby'                      => 'date',
				'post_status'                  => 'publish',
				'paged'                        => 1,
				'posts_per_page'               => 10,
				'suppress_filters'             => false,
				'tax_query'                    => [],
				// Tribes Events Calendar compatibility fix.
				'tribe_suppress_query_filters' => true,
			]
		);
	}

	public function from_terms( $taxonomy, $terms = array(), $field = 'term_id' ) {
		$this->query_taxonomy = $taxonomy;

		if ( $terms && $taxonomy ) {
			$this->tax_query = compact( 'taxonomy', 'terms', 'field' );
		}

		return $this;
	}

	public function with_categorizaition( The7_Categorization_Request $request ) {
		if ( $request->not_empty() ) {
			$this->query_args['order']   = $request->order;
			$this->query_args['orderby'] = $request->orderby === 'name' ? 'title' : $request->orderby;
			$request_term                = $request->get_first_term();

			if ( $request_term && $request->taxonomy ) {

				// If there is a request filter with the taxonomy specified
				if ( is_object_in_taxonomy( $this->query_args['post_type'], $request->taxonomy ) ) {
					// - in case new taxonomy: add it to the tax_query

					$request_tax_query = [
						'taxonomy' => $request->taxonomy,
						'field'    => is_numeric( $request_term ) ? 'term_id' : 'slug',
						'terms'    => [ $request_term ],
					];

					if ( $this->tax_query ) {
						$this->tax_query = [
							'relation' => 'AND',
							$this->tax_query,
							$request_tax_query,
						];
					} else {
						$this->tax_query = $request_tax_query;
					}
				}
			} elseif ( $request_term && $this->query_taxonomy ) {
				// If there is a request without taxonimy:
				// - filter with taxonomy from the settings
				$this->tax_query = [
					'taxonomy' => $this->query_taxonomy,
					'field'    => is_numeric( $request_term ) ? 'term_id' : 'slug',
					'terms'    => [ $request_term ],
				];
			}
		}

		return $this;
	}

	public function set_page( $page ) {
		$this->query_args['paged'] = $page;

		return $this;
	}

	public function get_query_args() {
		$query_args = $this->query_args;

		if ( ! empty( $this->tax_query ) ) {
			if ( ! empty( $query_args['tax_query'] ) ) {
				$query_args['tax_query']['relation'] = 'AND';
			}

			$query_args['tax_query'][] = $this->tax_query;
		}

		return $query_args;
	}

	/**
	 * @return WP_Query
	 */
	public function query() {
		add_action( 'pre_get_posts', array( $this, 'add_offset' ), 1 );
		add_filter( 'found_posts', array( $this, 'fix_pagination' ), 1, 2 );

		$query = new WP_Query( $this->get_query_args() );

		remove_action( 'pre_get_posts', array( $this, 'add_offset' ), 1 );
		remove_filter( 'found_posts', array( $this, 'fix_pagination' ), 1 );

		return $query;
	}

	/**
	 * Add offset to the posts query.
	 *
	 * @param WP_Query $query
	 *
	 * @since 1.15.0
	 */
	public function add_offset( $query ) {
		$offset  = (int) $this->query_args['posts_offset'];
		$ppp     = (int) $query->query_vars['posts_per_page'];
		$current = (int) $query->query_vars['paged'];

		if ( $query->is_paged ) {
			$page_offset = $offset + ( $ppp * ( $current - 1 ) );
			$query->set( 'offset', $page_offset );
		} else {
			$query->set( 'offset', $offset );
		}
	}

	/**
	 * Fix pagination accordingly with posts offset.
	 *
	 * @param int $found_posts
	 *
	 * @return int
	 */
	public function fix_pagination( $found_posts ) {
		return $found_posts - (int) $this->query_args['posts_offset'];
	}
}
