<?php
/**
 * @package Daan\EDDEmailTags
 * @author  Daan van den Bergh
 * @url https://daan.dev
 * @license MIT
 */

namespace Daan\EDD\EmailTags\Tags;

use EDD\Recurring\Subscriptions\Subscription;
use EDD\Recurring\Subscriptions\Update\Link;

class UpdatePaymentUrl {
	private $text_domain = 'daan-edd-email-tags';
	
	/**
	 * Build class.
	 */
	public function __construct() {
		$this->init();
	}
	
	/**
	 * Registers a custom email tag with the URL of Recurring's {update_payment_link}, which is a complete link. So it
	 * can be used as a link's URL, e.g. to show it as a button.
	 *
	 * @return void
	 */
	public function init() {
		if ( ! class_exists( Link::class ) ) {
			return;
		}
		
		edd_add_email_tag(
			'daan_update_payment_url',
			__( 'The URL of a secure link for customers with Stripe subscriptions to update their payment method without logging in. Use it as a link\'s URL, e.g. to show it as a button.', $this->text_domain ),
			[ $this, 'replace_tag' ],
			__( 'Update Payment URL', $this->text_domain ),
			[ 'subscription' ],
			[ 'customer' ]
		);
	}
	
	/**
	 * @param int|string        $subscription_id
	 * @param Subscription|null $email_object
	 * @param string            $context
	 *
	 * @return string The URL, or an empty string if the subscription's payment method can't be updated this way.
	 */
	public function replace_tag( $subscription_id, $email_object = null, $context = 'order' ) {
		if ( ! $email_object instanceof Subscription ) {
			$email_object = edd_recurring_get_subscription( $subscription_id );
		}
		
		if ( ! $email_object instanceof Subscription ) {
			return '';
		}
		
		return esc_url( (string) Link::generate_for_subscription( $email_object ) );
	}
}
