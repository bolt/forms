Creating new forms
==================

All the configuration required to customise the contact form, or build
your very own Bolt form is located in `config/extensions/bolt-boltforms.yaml`.

The first time you open it, you'll see a few options are already defined for you.
The default configuration file includes a lot of comments to help you get started.

If you have a few forms and managing the `config/extensions/bolt-boltforms.yaml`
file becomes a chore, you can split each form into its own file in `config/extensions/bolt-boltforms/`.

For example, `config/extensions/bolt-boltforms/contact.yaml` will create a form called `contact`.
Note, you should **only** put the configuration for this form, for example:

```yaml
notification:
    enabled: true
    debug: false
    debug_address: name@example.com # Email address used when debug mode is enabled
    debug_smtp: true
    subject: Your message was submitted
    subject_prefix: '[Boltforms]'
    replyto_name: '{NAME}'                 # Email addresses and names can be either the
    replyto_email: '{EMAIL}'                 # name of a field below or valid text.
    to_name: 'WebsiteName'
    to_email: 'youremail@example.org'
    from_name: 'WebsiteName'
    from_email: 'youremail@example.org'
feedback:
    success: Message submission successful
    error: There are errors in the form, please fix before trying to resubmit
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
    message:
        type: textarea
        options:
            required: true
            label: Your message
            attr:
                placeholder: Your message...
                class: myclass
    needreply:
        type: choice
        options:
            required: false
            label: Do you want us to contact you back?
            choices: { 'Yes': 'yes', 'No': 'no' }
            multiple: false
    submit:
        type: submit
        options:
            label: Submit my message »
            attr:
                class: button primary
```

