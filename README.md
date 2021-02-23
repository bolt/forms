# Forms

Authors: Bob den Otter, Ivo Valchev

This Bolt extension can be used to handle forms in your Bolt 4 project.

Installation:

```bash
composer require bolt/forms
```


## Running PHPStan and Easy Codings Standard

First, make sure dependencies are installed:

```
COMPOSER_MEMORY_LIMIT=-1 composer update
```

And then run ECS:

```
vendor/bin/ecs check src
```

## Setting up a contact form

After installing the `bolt/forms` extension, you can directly use the default
contact form in your twig template like this:

```twig
    {{ boltform('contact') }}
```

which will display something that looks like this:

![contact form](https://user-images.githubusercontent.com/7093518/94814151-3a03ce00-03f9-11eb-8946-96a03ba0a263.png)

## Customing the contact form. Creating new forms.

All the configuration required to customise the contact form, or build
your very own Bolt form is located in `config/extensions/bolt-boltforms.yaml`.

The first time you open it, you'll see a few options are already defined for you.
The default configuration file includes a lot of comments to help you get started.

### Create a form and save it to a ContentType

Scroll down to `contact:` where you'll find the configuration for the default contact form.

To create a new form and store submissions in a Bolt ContentType, 
add a new key to the yaml file, along with the options for the new form.
For example:

```yaml
quotations:
    templates:                      # Override the global Twig templates if you want
    #        form: @theme/form.twig
    #        email: @theme/email.twig
    #        subject: @theme/subject.twig
    #        files: @theme/file_browser.twig
    feedback:
        success: Quotation request is received. We'll be in touch soon.
        error: There are errors in the form, please fix before trying to resubmit
    database:
        contenttype:
            name: quotations # save all form submissions to the quotations contenttype
            field_map:
                timestamp: ~ # do not save the timestamp
                url: ~ # do not save the url
                path: ~ # do not save the path
                ip: ~ # do not save the ip
    fields:
        name:
            type: text
            options:
                required: true
                label: Name
                attr:
                    placeholder: Your name...
                constraints: [ NotBlank, { Length: { 'min': 3, 'max': 128 } } ]
        email:
            type: email
            options:
                required: true
                label: Email address
                attr:
                    placeholder: Your email...
                constraints: [ NotBlank, Email ]
        needhelp:
            type: choice
            options:
                required: true
                label: What project do you need help with?
                choices: { 'Web development': 'web-development', 'Mobile development': 'mobile-development', 'Marketing': 'marketing' }   
        details:
            type: textarea
            options:
                required: true
                label: Please descript your desired app      
        submit:
            type: submit
            options:
                label: Request quotation »
                attr:
                    class: button primary
```

If the name of the fields in your ContentType and the form do not match exactly,
use the `field_map` option to override the default mapping:

```yaml
    database:
        contenttype:
            name: quotations # save all form submissions to the quotations contenttype
            field_map:
                name: customer_name # name is the form field. customer_name is the contenttype field.
```

In addition to all form fields, you can also keep the following information:

* `timestamp` - the timestamp when the form is submitted
* `url` - the url where the form is submitted
* `path` - the absolute path where the form  is submitted
* `ip` - the ip address of the user submitting the form
* `attachments` - an array of attached files from file fields

To store that information in a ContentType, simply create a field for each option that
you want to keep, and remove the override from the form config, e.g.
`ip: ~ # do not save the ip <- REMOVE THIS LINE`

### Create a form and save it to a custom database table

Instead of saving the data to a Bolt ContentType, you can also save it to a custom
table of your own making. To do so, just update the `database` option in the form
configuration:

```yaml
    database:
        table:
            name: custom_quotations # save all form submissions to the custom_quotations table in the database
            field_map: # optional
                timestamp: ~ # do not save the timestamp
                url: ~ # do not save the url
                path: ~ # do not save the path
                ip: ~ # do not save the ip
                attachments: ~ # do not save attached files
```

### Add CAPTCHA challenges to protect against bots

Bolt forms support the following CAPTCHA platforms:

* [Google reCAPTCHA](https://www.google.com/recaptcha/about/) (v3, v2 checkbox, v2 invisible)
* [hCaptcha](https://www.hcaptcha.com/)

You will need to obtain a site key and secret key from either of the above platforms.

**Please note it is not possible to use both. hCaptcha has been designed to easily replace reCAPTCHA, so it takes over.**

Uncomment either the `hcaptcha` or `recaptcha` nodes in your config, and populate the public_key (site key) and 
private_key (secret key) settings. Set the `enabled` node to true.

Please note: `theme` can either be `light` or `dark` - it only applies to hCaptcha and reCAPTCHA v2 checkbox.)

hCaptcha:

```yaml
hcaptcha:
    enabled: true
    public_key: "..."
    private_key: "..."
    theme: dark
```

reCAPTCHA:

```yaml
recaptcha:
    enabled: true
    public_key: '...'
    private_key: '...'
    theme: light
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

## 💡 Tips

To configure a `date`, `datetime` or `dateinterval` field to use HTML5's standard date picker widget, set the options as this example:

```yaml
date_of_birth:
    type: date
    options:
        widget: single_text
```

To configure a `choice` field to show checkboxes, set the options as this example:

```yaml
favourite_food:
    type: choice
    options:
        choices:
            "bananas": "Bananas"
            "chocolate": "Chocolate"
            "oranges": "Oranges"
        expanded: true
        multiple: true
```

More options regarding the `choice` field are available on the [official Symfony Forms documentation](https://symfony.com/doc/current/reference/forms/types/choice.html#select-tag-checkboxes-or-radio-buttons) page.
