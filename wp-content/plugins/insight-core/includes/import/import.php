<?php
define( 'INSIGHT_CORE_IMPORT_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
define( 'INSIGHT_CORE_IMPORT_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

class InsightCore_Import {

	public $demos = array();
	public $dummies = array();
	public $style = array();
	public $support = array();
	public $generate_thumb = false;
	public $importer_version = '2';

	private $response = array();
	private $process = array();
	private $importer;
	private $file_path;
	private $_cpath;

	public function __construct() {

		$this->response  = array( 'status' => 'fail', 'message' => '' );
		$this->file_path = INSIGHT_CORE_THEME_DIR . INSIGHT_CORE_DS . 'assets' . INSIGHT_CORE_DS . 'import' . INSIGHT_CORE_DS;
		$this->_cpath    = WP_CONTENT_DIR . INSIGHT_CORE_DS;

		add_action( 'admin_menu', array( $this, 'register_menu' ) );
		add_action( 'init', array( $this, 'init' ) );

		// AJAX Import
		add_action( 'wp_ajax_import_dummy', array( $this, 'import_dummy' ) );
	}

	public function init() {
		$this->demos            = apply_filters( 'insight_core_import_demos', array() );
		$this->dummies          = apply_filters( 'insight_core_import_dummies', array() );
		$this->generate_thumb   = apply_filters( 'insight_core_import_generate_thumb', false );
		$this->importer_version = apply_filters( 'insight_core_importer_version', '2' );
	}

	public function register_menu() {
		add_submenu_page( 'insight-core', 'Import', 'Import', 'manage_options', 'insight-core-import', array(
			&$this,
			'register_page',
		), 'dashicons-download' );
	}

	public function register_page() {
		$demos            = $this->demos;
		$dummies          = $this->dummies;
		$generate_thumb   = $this->generate_thumb;
		$importer_version = $this->importer_version;

		require_once( INSIGHT_CORE_IMPORT_PATH . INSIGHT_CORE_DS . 'import-page.php' );
	}

	public function import_dummy() {

		if ( ! empty( $_GET['dummy'] ) ) {

			$this->dummy = sanitize_key( $_GET['dummy'] );

			if ( ! $this->is_valid_dummy_slug( $this->dummy ) ) {
				$this->send_fail_msg( esc_html__( 'Wrong dummy name', 'insight-core' ) );
			}

			$this->process = explode( ',', $this->dummies[ $this->dummy ]['process'] );

			$this->load_importers();

			if ( $this->need_process( 'media' ) ) {
				if ( ! $this->importer->check_writeable() ) {
					$this->send_fail_msg( wp_kses( __( 'Could not write files into directory: <strong>%swp-content</strong>', 'insight-core' ),
						array(
							'strong' => array(),
						)
					),
						str_replace( '\\', '/', ABSPATH ) );
				}

				$_tmppath = $this->_cpath . INSIGHT_CORE_THEME_SLUG . '-' . $this->dummy . '_tmp';

				// START DOWNLOAD IMAGES
				$this->importer->download_package( $_tmppath );
				//  FINISH DOWNLOAD AND UNPACKAGE
				$this->importer->unpackage( $this->_cpath, $_tmppath );
			}

			if ( $this->need_process( 'woocommerce' ) ) {
				$this->importer->import_woocommerce_image_sizes();
			}

			if ( $this->need_process( 'xml' ) ) {
				$this->import_xml();
			}

			if ( $this->need_process( 'home' ) ) {
				$this->importer->import_page_options();
			}

			if ( $this->need_process( 'sidebars' ) ) {
				$this->importer->import_sidebars();
			}

			if ( $this->need_process( 'widgets' ) ) {
				$this->importer->import_widgets();
			}

			if ( $this->need_process( 'menus' ) ) {
				$this->importer->import_menus();
			}

			if ( $this->need_process( 'customizer' ) ) {
				$this->importer->import_customizer_options();
			}

			if ( $this->need_process( 'woocommerce' ) ) {
				$this->importer->import_woocommerce_pages();
			}

			if ( $this->need_process( 'attribute_swatches' ) ) {
				$this->importer->import_attribute_swatches();
			}

			if ( $this->need_process( 'essential_grid' ) ) {
				$this->importer->import_essential_grid();
				$this->importer->fix_essential_grid();
			}

			if ( $this->need_process( 'sliders' ) ) {
				$this->importer->import_rev_sliders();
			}

			InsightCore::update_option_count( INSIGHT_CORE_THEME_SLUG . '_' . $this->dummy . '_imported', $this->dummy );

			$this->send_success_msg( esc_html__( 'Import is successful!', 'insight-core' ) );

		} else {
			$this->send_fail_msg( esc_html__( 'Wrong dummy name', 'insight-core' ) );
		}

		$this->send_response();

	}

	private function need_process( $process ) {
		return in_array( $process, $this->process );
	}

	private function load_importers() {

		require_once( INSIGHT_CORE_IMPORT_PATH . INSIGHT_CORE_DS . 'importer.php' );

		// Load Importer API
		if ( class_exists( 'InsightCore_Importer' ) ) {
			$this->importer                 = new InsightCore_Importer( false );
			$this->importer->generate_thumb = $this->generate_thumb;
		} else {
			$this->send_fail_msg( esc_html__( 'Can\'t find InsightCore_Importer class', 'insight-core' ) );
		}
	}

	private function import_xml() {

		$file = $this->get_file_to_import( 'content.xml' );

		if ( ! $file ) {
			$this->send_fail_msg( sprintf( wp_kses( __( 'File does not exist: <strong>%s/content.xml</strong>', 'insight-core' ), array( 'strong' => array() ) ), $this->dummy ) );
		}

		try {

			$this->importer->import( $file );

		} catch ( Exception $ex ) {
			$this->_send_fail_msg( esc_html__( 'Error while importing', 'insight-core' ) );

			if ( WP_DEBUG || ( isset( $_GET['debug'] ) && $_GET['debug'] == 'true' ) ) {
				var_dump( $ex );
			}
		}
	}

	private function get_file_to_import( $filename ) {

		$file = $this->file_path . $this->dummy . INSIGHT_CORE_DS . $filename;

		if ( ! file_exists( $file ) ) {
			return false;
		}

		return $file;
	}

	private function send_response() {

		if ( ! empty( $this->response ) ) {
			wp_send_json( $this->response );
		} else {
			wp_send_json( array( 'message' => 'empty response' ) );
		}
	}

	private function send_success_msg( $msg ) {

		$this->send_msg( 'success', $msg );

	}


	private function send_fail_msg( $msg ) {

		$this->send_msg( 'fail', $msg );

	}

	private function send_msg( $status, $message ) {
		$this->response = array(
			'status'  => $status,
			'message' => $message,
		);

		$this->send_response();
	}

	private function is_valid_dummy_slug( $dummy ) {
		return in_array( $dummy, array_keys( $this->dummies ) );
	}
}

new InsightCore_Import();