Create a form and save it to a ContentType
==========================================

To create a new form and store submissions in a Bolt ContentType, first 
create a new form. For example, create a file `quotation.yaml` in the folder 
`config/extensions/bolt-boltforms`:

```yaml
# config/extensions/bolt-boltforms/quotation.yaml

templates:                      # Override the global Twig templates if you want
#        form: @theme/form.twig
#        email: @theme/email.twig
#        subject: @theme/subject.twig
#        files: @theme/file_browser.twig
feedback:
  success: Quotation request has been received. We'll be in touch soon.
  error: There are errors in the form. Please fix them, before trying to resubmit
database:
  contenttype:
    name: quotations # save all form submissions to the quotations contenttype
    ignore_missing: true # ignore fields in the form that aren't defined in the ContentType
    status: draft # save entry with publication status published|held|draft
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
      label: Description
      attr:
        placeholder: Please describe your desired website or app…
  submit:
    type: submit
    options:
      label: Request quotation »
      attr:
        class: button primary
```

To store the data, you'd need a ContentType `quotations`, as referenced in the 
form above. For example: 

```yaml
# config/bolt/contenttypes.yaml

quotations:
  name: Quotations
  singular_name: Quotation
  title_format: "Quotation request from: {name}"
  fields:
    name:
      type: text
      variant: inline
    email:
      type: text
      variant: inline
    needhelp:
      type: text
      variant: inline
    details:
      type: textarea
    timestamp:
      type: text
      variant: inline
    url:
      type: text
      variant: inline
    path:
      type: text
      variant: inline
    ip:
      type: text
      variant: inline
```

As a result, the submissions of the form will be stored as proper Records in 
your Bolt backend. See this screenshot as an example: 

![Form saved as Bolt Record](https://user-images.githubusercontent.com/1833361/122095553-d34f0500-ce0d-11eb-827d-00077c00c53f.png)

If the name of the fields in your ContentType and the form do not match exactly,
use the `field_map` option to override the default mapping:

```yaml
    database:
        contenttype:
            name: quotations # save all form submissions to the quotations ContentType
            field_map:
                name: customer_name # name is the form field. customer_name is the ContentType field.
```

In addition to all form fields, you can also keep the following information:

* `timestamp` - the timestamp when the form is submitted
* `url` - the url where the form is submitted
* `path` - the absolute path where the form  is submitted
* `ip` - the ip address of the user submitting the form
* `attachments` - an array of attached files from file fields

To store that information in a ContentType, simply create a field for each 
option that you want to keep, and remove the override from the form config:

`ip: ~ # do not save the ip <- REMOVE THIS LINE`

By default, Boltforms silently ignores fields from the form that are missing from the ContentType. Often this is what you want, because you might not need an `attachments` field, if the form has no file uploads. However, if you do want to have this strict behaviour, set `ignore_missing: false`, like so: 

```yaml
    database:
        contenttype:
            name: quotations # save all form submissions to the quotations ContentType
            field_map:
              timestamp: ~ # do not save the timestamp
              url: ~ # do not save the url
              path: ~ # do not save the path
              ip: ~ # do not save the ip
            ignore_missing: false
```
