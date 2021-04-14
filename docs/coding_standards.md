Running PHPStan and Easy Codings Standard
=========================================

First, make sure dependencies are installed:

```bash
COMPOSER_MEMORY_LIMIT=-1 composer update
```

And then run ECS:

```bash
vendor/bin/ecs check src
```
