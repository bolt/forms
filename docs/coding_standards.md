Running PHPStan and Easy Codings Standard
=========================================

If you're working on improving this extension (as opposed to working _with_ this extension), 
you might want to run the built-in configurations for ECS and PHPStan.

First, make sure dependencies are installed:

```bash
composer install
```

And then run ECS to find potential issues:

```bash
vendor/bin/ecs check src
```

Or to fix them automatically:

```bash
vendor/bin/ecs check src
```


