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
		add_action( 'edd_add_email_tags', [ $this, 'add_renewal_link_email_tag' ], 99 );
		add_action( 'edd_add_email_tags', [ $this, 'add_software_licensing_email_tag' ], 101 );
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
}
