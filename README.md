Community Library
=================

## Requirements

* PHP >= 8.2
* [`symfony-cli`](https://symfony.com/download)
* [`composer`](https://getcomposer.org/download/)

## Install

```console
$ git clone https://github.com/adrienroches-sensio/sf7pack.2026.06.08.git
$ cd ./sf7pack.2026.06.08
$ symfony composer install
$ symfony console doctrine:migrations:migrate --no-interaction
$ symfony console foundry:load-fixtures catalog --no-interaction
$ symfony serve
```

Check the output of `symfony serve` to access the application.
