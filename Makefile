csfix:
    vendor/bin/ecs check src --fix
    make stancheck


stancheck:
    vendor/bin/phpstan --memory-limit=1G analyse -c phpstan.neon src
