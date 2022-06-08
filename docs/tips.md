💡 Tips
======

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

A *single* checkbox can be added like this:

```yaml
newsletter:
    type: checkbox
    options:
        label: "Yes, I'd like to subscribe to your newsletter"
        required: false
```

Note that when using `form_div_layout.html.twig` as layout in `bolt-boltforms.yaml`, checkboxes and radio-buttons do not show labels by default.
If you want to use this layout, it's advised to copy it to your theme folder, change its name, modify it, and configure it like this:

```yaml
layout:
    form: 'my_form_layout.html.twig'
    bootstrap: false
```

More options regarding the `choice` field are available on the [official Symfony Forms documentation](https://symfony.com/doc/current/reference/forms/types/choice.html#select-tag-checkboxes-or-radio-buttons) page.

## Using Content as Choices

With `type: contenttype`, you can use content as choices. This makes additional `params` option is available.
These are the same options as what you'd use for regular `setcontent` queries.

```yaml
favourite_food:
    type: contenttype
    options:
        expanded: true
        multiple: true
        params:
            contenttype: pages
            label: title
            value: slug
            limit: 10
            sort: title
            criteria:
                status: 'draft || published' # by default only published items are queried
```

Options for `choice` are available here; `choices` will be overwritten by the queried values.
The following options are available for `params`:

* `contenttype`: the contenttype to query.
* `label`: the name of the field to use as labels.
* `value`: the name of the field to use as values.
* `limit`: the number of records to return.
* `sort`: the field value to sort on; prefix with `-` for descending order.
* `criteria`: the `where` clause.
