# Email Mods for Easy Digital Downloads

This plugin adds to Email tags for use in EDD's email templates.

- `daan_renewal_link`: for use in EDD recurring emails. Generates a renewal link to be used in e.g. emails sent when a
  license failed to renew.
- `ffwp_license_keys`: generates a cleaner (compared to the core tag) overview of purchased license keys, which also
  keeps in mind variable pricing
  options.

- `daan_update_payment_url`: the URL of Recurring's `update_payment_link` tag, which is a complete link. Use it as a
  link's URL, e.g. to show it as a button (Formats > Button). WordPress' link editor adds `http://` in front of it, which is removed
  again when the email is sent.

It also adds the Payment Method condition (Emails > Condition) to subscription emails, e.g. renewal reminders:
`{if payment_method="stripe"}…{/if}`. EDD's own condition only works in order emails.
