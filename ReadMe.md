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
