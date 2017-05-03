# Symfony webhook bundle for Lokalise
This bundle receives the webhook from lokalise.co and uploads the new translation files to your directories.

## 1. Installing the bundle
Require it with composer.
```bash
composer require alicorn/lokalise-bundle
```

## 2. Enable the bundle in your kernel

```php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        // ...
        new Alicorn\LokaliseBundle\AlicornLokaliseBundle(),
        // ...
    );
}
```

## 3. Configure the bundle routing

```yaml
# app/config/routing.yml

alicorn_lokalise:
    resource: "@AlicornLokaliseBundle/Controller/"
    type:     annotation
    prefix:   /lokalise/webhook # your webhook url
```

## 4. Configure the bundle

```yaml
# app/config/config.yml

# ...

alicorn_lokalise:
    host: "https://s3-eu-west-1.amazonaws.com/lokalise-assets/" # Lokalise host for downloads can be overwritten
    web_path: "web/locales" # Path for locale files #1
    symfony_path: "app/Resources/translations" # Path for locale files #2, can be blank
    extract_file: "/tmp/langs.zip"
```

## 5. Configure webhook on lokalise

Configure your webhook on lokalise.

![screen shot 2017-05-03 at 16 43 42](https://cloud.githubusercontent.com/assets/1528278/25663213/b84c424e-301f-11e7-8903-44ee004b26ab.png)

When building the project in lokalise, it will trigger the webhook and unzip the translation files to the configured directories.




