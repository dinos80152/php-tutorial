# Lambda

## Recursion

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

## Lambda

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

```php
$data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
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

$results = array_map(get_algorithm($rand_seed_func), $data);
```
## Partial

```php
$first_char = function($string) {
    return substr($string, 0, 1);
};

array_map($first_char, ['Dino', 'Amy', 'Birdy']);
// ['D', 'A', 'B']
```

## Currying

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