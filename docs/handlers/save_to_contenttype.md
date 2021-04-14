Create a form and save it to a ContentType
==========================================

Scroll down to `contact:` where you'll find the configuration for the default
contact form.

To create a new form and store submissions in a Bolt ContentType, add a new key
to the yaml file, along with the options for the new form. For example:

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
