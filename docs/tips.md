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

More options regarding the `choice` field are available on the [official Symfony Forms documentation](https://symfony.com/doc/current/reference/forms/types/choice.html#select-tag-checkboxes-or-radio-buttons) page.
