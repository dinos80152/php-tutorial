# Array Functions
## Filter

*array_filter* 會去走訪 array 裡的所有元素，並將符合條件的串成 array 回傳出來。

```php
array array_filter ( array $array [, callable $callback [, int $flag = 0 ]] )
```

判斷來源 IP 是否在白名單裡。

```php
array_filter($allow_ips, function($ip) {
    return $ip == $_SERVER['REMOTE_ADDR'];
}) ? : throw new Exception('Denied IP');
```

當沒有設定條件時，會傳回符合 true 條件的 array

```php
array_filter(array('', true, 's', 0, null));
//[true, 's']
```

## Map

*array_map* 會將每個 array 裡的元素經過指定的 function 處理，並將結果丟進另一個 array 傳出來。

```php
array array_map ( callable $callback , array $array1 [, array $... ] )
```

將 array 裡的元素做大寫處理

```php
$array = ['p', 'h', 'p'];
$post_array = array_map(function($value) {
    return strtoupper($value);
}, $array);
var_dump($post_array); //['P', 'H', 'P']
```

將兩個 array 做對應，數字對應到英文單字。

```php
function map_num($num, $word) {
    return [$num => $word];
}

$number = [1,2,3,4,5];
$number_eng = ['one', 'two', 'three', 'four', 'five'];
array_map('map_num', $number, $number_eng);
//[1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five']
```

這邊有個很像的叫 *array_walk*，它會走訪每個元素，但是回傳 boolean，若全部成功走完傳回 true，沒走完回傳 false。


```php
bool array_walk ( array &$array , callable $callback [, mixed $userdata = NULL ] )
```

**若要真的改變元素，請 passing by reference。**

```php
function upper_str($value, $key, $prefix) {
    $value = strtoupper($prefix . $value);
}

function upper_str_reference(&$value, $key, $prefix) {
    $value = strtoupper($prefix . $value);
}

$array = ['p', 'h', 'p'];

$bool = array_walk($array, 'upper_str', '_');
var_dump($array); //['p', 'h', 'p']

$bool = array_walk($array, 'upper_str_reference', '_');
var_dump($array); //['_P', '_H', '_P']
```

## Reduce

array 裡的元素會一個一個依序被丟到 function 裡做處理，上一個元素的處理結果都會被存進 function 裡的第一次參數，供下一個元素處理時使用。

```php
mixed array_reduce ( array $array , callable $callback [, mixed $initial = NULL ] )
```

傳統用 foreach 做 1 到 5 的相乘結果。

```php
function multiply_array($array) {
    foreach($array as $value) {
        $sum *= $value;
    }

    return $sum;
}

multiply_array([1, 2, 3, 4, 5]);
```

改用 array_reduce 的 1 到 5 的相乘結果。並給定第一個初始值為 10。

```php
$array = [1, 2, 3, 4, 5];
array_reduce($array, function($carry, $item) {
    return $carry *= $item;
}, 10);

//1200, because: 10*1*2*3*4*5
```

## Map and Reduce

綜合應用。array 的元素變大寫以後，再一個一個接成字串。

```php
$array = ['p', 'h', 'p'];
array_reduce(array_map(function($value) {
    return strtoupper($value);
}, $array), function($carry, $value) {
    return $carry .= $value;
});
//PHP
```

## others

### array_sum

加總 array 裡的元素。

```php
number array_sum ( array $array )
```

產生一個 1 到 10 的 array，並將 array 裡的元素做加總。

```php
array_sum(range(1, 10));
```

## Reference

1. [Functional Programming in PHP by Simon Holywell](https://www.simonholywell.com/static/slides/2014-02-12/)
2. [PHP Manual - Array Functions](http://php.net/manual/en/function.array.php)