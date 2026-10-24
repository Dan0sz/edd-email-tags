<?php
/**
 * @package Daan\EDDEmailTags
 * @author  Daan van den Bergh
 * @url https://daan.dev
 * @license MIT
 */

namespace Daan\EDD\EmailTags;

class Plugin {
	/**
	 * Build class.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Action & Filter hooks.
	 *
	 * @return void
	 */
	private function init() {
		add_action( 'edd_add_email_tags', [ $this, 'add_renewal_link_email_tag' ] );
		add_action( 'edd_add_email_tags', [ $this, 'add_software_licensing_email_tag' ] );
		add_action( 'edd_add_email_tags', [ $this, 'add_update_payment_url_email_tag' ] );
		add_action( 'edd_email_conditional_tags_register_conditions', [ $this, 'add_payment_method_condition' ] );
		add_filter( 'edd_email_content_tags', [ $this, 'fix_tag_urls' ] );
	}

	/**
	 * Add renewal link email tag.
	 *
	 * @return void
	 */
	public function add_renewal_link_email_tag() {
		new Tags\RenewalLink();
	}

	/**
	 * Add license keys email tag.
	 *
	 * @return void
	 */
	public function add_software_licensing_email_tag() {
		new Tags\LicenseKeys();
	}

	/**
	 * Add update payment URL email tag.
	 *
	 * @return void
	 */
	public function add_update_payment_url_email_tag() {
		new Tags\UpdatePaymentUrl();
	}

	/**
	 * Add the Payment Method condition to subscription emails.
	 *
	 * @param \EDD\Pro\Emails\ConditionalTags\ConditionRegistry $registry
	 *
	 * @return void
	 */
	public function add_payment_method_condition( $registry ) {
		( new Conditions\SubscriptionPaymentMethod() )->register( $registry );
	}

	/**
	 * WordPress' link editor prepends http:// to a link's URL without a protocol, e.g. {daan_update_payment_url}. After
	 * the tag is replaced with its URL, that's e.g. http://https://daan.dev/…, so remove it again.
	 *
	 * @param string $content The email's content, with its tags replaced.
	 *
	 * @return string
	 */
	public function fix_tag_urls( $content ) {
		// Also with encoded quotes, e.g. href=&quot;.
		return preg_replace( '~(href=(?:["\']|&quot;|&#0*3[49];|&apos;))https?://(https?://)~i', '$1$2', $content );
	}
}
