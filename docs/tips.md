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
