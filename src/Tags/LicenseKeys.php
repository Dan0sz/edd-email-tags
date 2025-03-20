<?php
/**
 * @package Daan\EDDEmailTags
 * @author  Daan van den Bergh
 * @url https://daan.dev
 * @license MIT
 */

namespace Daan\EDD\EmailTags\Tags;

class LicenseKeys {
	private $text_domain = 'daan-edd-email-tags';

	/**
	 * Build class.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Action & filter hooks.
	 *
	 * @return void
	 */
	private function init() {
		edd_add_email_tag(
			'ffwp_license_keys',
			__( 'Show all purchased licenses (modified)', $this->text_domain ),
			[ $this, 'licenses_tag' ],
			__( 'License Keys (modified)', $this->text_domain )
		);
	}

	/**
	 * Create list of purchased plugins and licenses.
	 */
	public function licenses_tag( $payment_id = 0 ) {
		$keys_output  = '';
		$license_keys = edd_software_licensing()->get_licenses_of_purchase( $payment_id );

		if ( $license_keys ) {
			foreach ( $license_keys as $license ) {
				$price_name = '';

				if ( $license->__get( 'price_id' ) ) {
					$price_name = " - " . edd_get_price_option_name( $license->__get( 'download_id' ), $license->__get( 'price_id' ) );
				}

				$keys_output .= $license->get_download()->get_name() . $price_name . ".\nLicense key: <em>" . $license->key . "</em>\n\r";
			}
		}

		return $keys_output;
	}
}
