# Lambda

## Recursion

遞迴。例：運算連續整數總合

* loop

```php
function head_sum($x) {
    for($x; $x > 0; $x--) {
        $sum += $x;
    }
    return $sum;
}
```

* recursion

```php
function head_sum($x) {
    return ($x == 1) ? $x : $x + head_sum($x - 1);
}
head_sum(10)
```

## Anonymous function

匿名函数

```php
$value = 5;
$func_name = function($param) use ($value) {
    return $param + $value;
};
echo $func_name(3); //8
```

```php
$plus_one = function($var) {
    return $var + 1;
};

$func_name = function($param) use ($plus_one) {
    return $param + $plus_one($param);
};
echo $func_name(3); //7
```

## Advanced

判斷隨機數為奇偶數後對陣列裡的值做運算。

```php
function get_algorithm($rand_seed_func) {
    return (odd_even($rand_seed_func()))
        ? function($value) {
            return $value * $value;
        }
        : function($value) use ($rand_seed_func) {
            return ($value * $value / $rand_seed_func()) + 10;
        };
}

function odd_even($value) {
    return ($value % 2 === 0);
}

$rand_seed_func = function() {
    return rand();
};

$data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$results = array_map(get_algorithm($rand_seed_func), $data);
```

## [Partial Function Application](https://en.wikipedia.org/wiki/Partial_application)

從一函數中創造出它的局部函數出來。

```php
$first_char = function($string) {
    return substr($string, 0, 1);
};

$second_char = function($string) {
    return substr($string, 1, 2);
};

array_map($first_char, ['Dino', 'Amy', 'Birdy']);
// ['D', 'A', 'B']

array_map($second_char, ['Dino', 'Amy', 'Birdy']);
// ['i', 'm', 'i']
```

動態創建局部函數

```php
function partial(/* $func, $args... */)
{
    $args = func_get_args();
    $func = array_shift($args);

    return function() use ($func, $args)
    {
        return call_user_func_array($func, array_merge($args, func_get_args()));
    };
}

function add($a, $b)
{
    return $a + $b;
}

$inc = partial('add', 1);
$dec = partial('add', -1);

echo $inc(3); //4
echo $dec(3); //2
```

## [Currying](https://en.wikipedia.org/wiki/Currying)

將接受多個參數的函數變成一個一個接受單個參數的函數，並返回結果的新函數。使得固定某一值後的函數可再被重覆化利用。

```php
$first_char = function($start) {
    return function($length) use ($start) {
        return function($string) use ($start, $length) {
            return substr($string, $start, $length);
        };
    };
};
$a = $first_char(0);
$b = $a(1);
$b('foo'); //f
$c = $a(2);
$c('foo'); //fo
```

## Memoization

如果你需要返回的函式需要經過繁重的運算或串接，可以使用記憶化將它快取住，下次取用減少資源浪費。

```php
function demo() {
    static $cache;
    if(is_null($cache)) {
        $cache = some_expensive_operation();
    }
    return $cache;
}
```

## Reference

1. [Functional Programming in PHP by Simon Holywell](https://www.simonholywell.com/static/slides/2014-02-12/)
2. [PHP Manual - Variable functions](http://php.net/manual/en/function.array.php)
3. [PHP Manual - Anonymous functions](http://php.net/manual/en/functions.anonymous.php)
4. [Using Partial Application in PHP • edd mann](http://eddmann.com/posts/using-partial-application-in-php/)