# Benchmark

## Example

Find user by their name.
The data has three kind of key: id, name and more. Some users' name is empty, a few users have more data.

### Usage

1. execute generate_users.php for generating user data
2. use index.php to play benchmark

## Simple Benchmark
```php
$start_time = microtime(true);

// process here

$end_time = microtime(true);

$spend_time = $end_time - $start_time;
```

## Conclusion

* === > ==
* Avoid any notice and warning
  * add quote around array key
  * avoid manipulate undefined variables
* String function > regular expression
* Don't write any calculation in for expression
* isset() and empty() are great

## Others

* Don't use @
* echo > print
* "a" and 'a' doesn't matter in performance
* PDO > mysqli_query
* Static Method > Non-Static Method

## Reference

* [My Collection of PHP Performance Benchmarks](http://maettig.com/code/php/php-performance-benchmarks.php)

* [The PHP Benchmark](http://www.phpbench.com/)

* [PHP 程式效能優化的 40 條建議](http://blog.longwin.com.tw/2008/02/php_optimizing_40_comment_2008/)

* [PHP5 寫法效能比較](http://blog.longwin.com.tw/2008/02/php5_performance_write_data_2008/)

## Tools

* [Xdebug](http://xdebug.org/index.php)

* [victorjonsson/PHP-Benchmark](https://github.com/victorjonsson/PHP-Benchmark)