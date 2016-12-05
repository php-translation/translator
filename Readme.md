# Translator services

[![Latest Version](https://img.shields.io/github/release/php-translation/translator.svg?style=flat-square)](https://github.com/php-translation/translator/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/php-translation/translator.svg?style=flat-square)](https://travis-ci.org/php-translation/translator)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/php-translation/translator.svg?style=flat-square)](https://scrutinizer-ci.com/g/php-translation/translator)
[![Quality Score](https://img.shields.io/scrutinizer/g/php-translation/translator.svg?style=flat-square)](https://scrutinizer-ci.com/g/php-translation/translator)
[![Total Downloads](https://img.shields.io/packagist/dt/php-translation/translator.svg?style=flat-square)](https://packagist.org/packages/php-translation/translator)

**Services that can be used to translate strings**


## Install

The first thing you need to do is to install a HTTP client. Please read [HTTPlug quickstart](http://docs.php-http.org/en/latest/httplug/users.html).
When the client is installed you may install this package with composer by running:

``` bash
composer require php-translation/translator
```

## Intro

```php

$translator = new Translator();
$translator->addTranslatorService(new GoogleTranslator('api_key'));

echo $translator->translate('apple', 'en', 'sv'); // "äpple"
```
