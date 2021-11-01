Add CAPTCHA challenges to protect against bots
==============================================

Bolt forms support the following CAPTCHA platforms:

* [Google reCAPTCHA](https://www.google.com/recaptcha/about/) (v3, v2 checkbox, v2 invisible)
* [hCaptcha](https://www.hcaptcha.com/)

You will need to obtain a site key and secret key from either of the above platforms.

**Please note it is not possible to use both. hCaptcha has been designed to easily replace reCAPTCHA, so it takes over.**

Uncomment either the `hcaptcha` or `recaptcha` nodes in your config, and populate the public_key (site key) and
private_key (secret key) settings. Set the `enabled` node to true.

For reCAPTCHA v3, you can set a threshold for the score that's returned from Google. If the score is not met, the string set in `recaptcha_v3_threshold` is returned to the form.

Please note: `theme` can either be `light` or `dark` - it only applies to hCaptcha and reCAPTCHA v2 checkbox.)

## hCaptcha

```yaml
hcaptcha:
    enabled: true
    public_key: "..."
    private_key: "..."
    theme: dark
```

## reCAPTCHA

```yaml
recaptcha:
    enabled: true
    public_key: '...'
    private_key: '...'
    theme: light
    recaptcha_v3_threshold: 0.0 # A threshold of 0.0 allows all scores returned from Google to be submitted.
    recaptcha_v3_fail_message: We've been unable to verify whether you're human! Please, try resubmitting the form or get in touch via an alternative contact method.
```

Finally, insert a captcha field in your form where you would like the CAPTCHA challenge to appear. If an invisible
CAPTCHA is being used (reCAPTCHA v3 or v2 invisible), this is where any validation errors will be rendered.

This field must be before the submit button for reCAPTCHA v3 and v2 invisible. The field name can
be anything as long as it is unique within your form.

```yaml
contact:
    fields:
        # hCaptcha:
        my_hcaptcha_field:
            type: captcha
            options:
                captcha_type: hcaptcha

        # reCAPTCHA v3:
        my_recaptcha_v3_field:
            type: captcha
            options:
                captcha_type: recaptcha_v3

        # reCAPTCHA v2 checkbox:
        my_recaptcha_v2_checkbox_field:
            type: captcha
            options:
                captcha_type: recaptcha_v2
                # Use "label: false" to hide the label
                label: Please complete this CAPTCHA

        # reCAPTCHA v2 invisible:
        my_recaptcha_v2_invisible_field:
            type: captcha
            options:
                captcha_type: recaptcha_v2
                captcha_invisible: true

        # submit button must come after the CAPTCHA
```