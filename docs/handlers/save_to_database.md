Create a form and save it to a custom database table
====================================================

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