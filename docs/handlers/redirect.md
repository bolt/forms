Redirect after a succesful submit
=================================

After the form has been successfully submitted, the visitor will normally get
redirected to the originating page. You can use the Redirect handler to send
them elsewhere, instead.

You can do this, by setting `redirect:` in the `feedback:` section of the
form's configuration.


```yaml
feedback:
    success: …
    error: …
    redirect:
        target: page/another-page
        query: [name, email]
```

The `target:` specifies where the visitor will be sent. Note that you can add
optional get parameters in this URI, that will get sent as-is. For example:

```yaml
      target: page/another-page?foo=bar&qux=boo
```

You can use 'self' as a special case: This will redirect the browser (using a
GET request) to the originating page. This is useful for when you want the user
to stay on the same page, without them being able to accidentally re-submit the
form by refreshing the page.

The optional `query:` lets you set additional parameters that will contain the
corresponding values from the form. For example, the configuration above will redirect the visitor to a URL like this, after a correct form has been posted:

```
/page/another-page?foo=bar&qux=boo&name=Bob&email=bob%40twokings.nl
```

Please note that these will be sent as `GET` parameters, so do not use these to
pass around sensitive information.