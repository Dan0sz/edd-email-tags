<?php
/**
 * @package Daan\EDDEmailTags
 * @author  Daan van den Bergh
 * @url https://daan.dev
 * @license MIT
 */

namespace Daan\EDD\EmailTags\Tags;

use EDD_Subscription;

class RenewalLink {
	private $text_domain = 'daan-edd-email-tags';

	/**
	 * Build class.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Registers a custom email tag to display a URL allowing readers to renew their license.
	 *
	 * @return void
	 */
	public function init() {
		edd_add_email_tag(
			'daan_renewal_link',
			__( 'Display a URL allowing readers to renew their license.', $this->text_domain ),
			[ $this, 'replace_tag' ],
			__( 'Renewal Link', $this->text_domain ),
			[ 'subscription' ],
			[]
		);
	}

	/**
	 * Retrieves the renewal URL for a given subscription.
	 *
	 * @param int|string            $subscription_id The ID of the subscription to retrieve the renewal URL for.
	 * @param EDD_Subscription|null $subscription    Optional. An EDD_Subscription object. Default is null.
	 *
	 * @return string The renewal URL for the subscription's license, or an empty string if not found.
	 */
	public function replace_tag( $subscription_id, $subscription = null ) {
		$subscription = new EDD_Subscription( $subscription_id );

		if ( ! $subscription ) {
			return '';
		}

		$license = edd_software_licensing()->get_license_by_purchase(
			$subscription->parent_payment_id,
			$subscription->product_id
		);

		if ( ! $license ) {
			return '';
		}

		$args = [
			'edd_license_key' => $license->__get( 'key' ),
			'download_id'     => $license->__get( 'download_id' ),
		];

		return add_query_arg( $args, edd_get_checkout_uri() );
	}
}
