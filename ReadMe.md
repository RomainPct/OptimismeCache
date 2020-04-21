# Optimisme Cache
## Insert a simple cache system on your website in less than 5 minutes

### How ton install Optimisme Cache ?

You can install Optimisme Cache thank's to composer

```
composer require optimisme/optimisme-cache
```



### How to use Optimisme Cache ? (2 methods)

#### 1. Using the cache function

```php
<?php
include 'vendor/autoload.php'

$cacheManager = new Optimisme\Cache();

$cacheManager->cache(function() {
    ?>
    
    // Write your code there

    <?php
});
?>
```

#### 2. Using the open and close functions

```php
<?php
include 'vendor/autoload.php'

$cacheManager = new Optimisme\Cache();

if ($cacheManager->open()):
    ?>

    // Write your code there

    <?php
    $cacheManager->save();
endif;
?>
```

### Settings

When you create an instance of Optimisme Cache, you can set two specific settings :
- $name : You can specifiy a custom name for exemple is this component is used many times in different places. By default or if you set it to null, a name will be automatically generated according to the current page url.
- $cachetime : Time in seconds while this specific cached code will stay in cache

Optimisme Cache also supports caching subcomponents of page or components.

```php
<?php
include 'vendor/autoload.php'

$pageCache = new Optimisme\Cache(null, 1200);
$pageCache->cache(function() {
    ?>
    // Write your page code there
    <?php
    $componentCache = new Optimisme\Cache('my-custom-component-name', 600);

    $componentCache->cache(function() {
        ?>
        
        // Write your component code there

        <?php
    });
});
?>
```