# Package

## Folder Structure

```
hello-world/
  src/
    HelloWorld/
      HelloWorld.php
    config/
      helloworld.php
  tests/
    HelloWorld/
      HelloWorldTest.php
README.md
composer.json
.gitignore
```

hello-world/src/HelloWorld/
```
namespace DinoLai\HelloWorld;

class HelloWorld
{
    public function sayHello()
    {
        return "Hello World";
    }
}

```

hello-world/tests/HelloWorldTest
```

namespace DinoLai\HelloWorld;

class HelloWorldTest extends \PHPUnit_Framework_TestCase
{

    public function testSayHello()
    {

        $helloWorld = new HelloWorld;

        $this->assertSame('Hello World', $helloWorld->sayHello);
    }
}
```

## Composer.json

```
composer init
```

composer.json
```
{
    "name": "DinoLai/Hello-World",
    "description": "Composer Package Hello World Example",
    "keywords": ["example"],
    "license": "CPL 1.0",
    "type": "library",
    "require": {
        "php": ">=5.5.9"
    },
    "require-dev": {
        "phpunit/phpunit": "~4.0"
    },
    "autoload": {
        "psr-4": {
            "DinoLai\HelloWorld\\": "src/HelloWorld"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "DinoLai\HelloWorld\\": "tests/HelloWorld"
        }
    }
}
```

## Git Tag

### Version

X.Y.Z or vX.Y.Z

Patch version Z (x.y.Z | x > 0) MUST be incremented if only backwards compatible bug fixes are introduced. A bug fix is defined as an internal change that fixes incorrect behavior.

Minor version Y (x.Y.z | x > 0) MUST be incremented if new, backwards compatible functionality is introduced to the public API. It MUST be incremented if any public API functionality is marked as deprecated. It MAY be incremented if substantial new functionality or improvements are introduced within the private code. It MAY include patch level changes. Patch version MUST be reset to 0 when minor version is incremented.

Major version X (X.y.z | X > 0) MUST be incremented if any backwards incompatible changes are introduced to the public API. It MAY include minor and patch level changes. Patch and minor version MUST be reset to 0 when major version is incremented.

[Semantic Versioning 2.0.0](http://semver.org/)

### Command

```
git tag -a v0.0.1 -m "first release"
```


## Satis

### satis.json

```
{
    "repositories": [
        { "type": "vcs", "url": "https://github.com/dinos80152/hello-world" }
    ],
}
```

### Command

```
php bin/satis build satis.json web/
```

## Composer

### version
* 1.2
* >=1.2
* ^1.2
* ~1.2

### require
```
composer require dinolai/hello-world ~1.2
```

### create-project
```
composer create-project dinolai/hello-world hello-world.com ~1.2
```

## Resources

### PHP
[Packagist](https://packagist.org/)

### Laravel

#### Package Development
[Package Development@laravel.com](http://laravel.com/docs/5.1/packages)

#### Resources
[Packalyst](http://packalyst.com/)


## Best Practice
* [License](http://www.openfoundry.org/tw/comparison-of-licenses)
* Exclude development stuff from dist
* PSR-4 autoloading
* PSR-2 coding standard
* Code comments
* Semantic versioning
* Unit Tests
* Continuous Integration
* README.md

[PHP Package Checklist](http://phppackagechecklist.com/)

## Reference
* [Creating your first Composer/Packagist package](http://blog.grossi.io/2013/creating-your-first-composer-packagist-package/)
* [Starting a New PHP Package The Right Way](http://www.sitepoint.com/starting-new-php-package-right-way/)



