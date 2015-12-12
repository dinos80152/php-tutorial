# Gitlab CI

## Code Coverage

```
\ \ Lines:\s*(\d+.\d+\%)
```

## .gitlab-ci.yml

```
before_script:
  - composer install
  - cp .env.example .env
  - php artisan key:generate

jobs:
  script: 
    - phpcs app/ --standard=PSR2
    - phpunit --coverage-text
```
