#PHP Namespace
## 概念
Namespace 其實就是資料夾的概念，可以解決同樣名字的 Class 如何被使用。

## 情境
今天在 AVA 有新聞, 在 LoL 也有新聞，我們需要有個新聞中心 show 出所有的新聞

* 在 LoL 資料夾底下創一個 News Class
```php
/**
 * project/lol/news.php
**/
class News
{
}
```

* 在 AVA 資料夾底下創一個 News Class
```php
/**
 * project/ava/news.php
**/
class News
{
}
```

* 新聞頁面 show 出新聞
```php
/**
 * project/index.php
**/
require('lol/news.php');
require('ava/news.php');
$news = new News;
```
* 問題來了，兩個 class 都是 News，它不知道你是要 new 哪個 News，怎麼辦？

## 解決辦法

### 改名字
* 在 LoL 資料夾底下創一個 LoLNews Class
```php
/**
 * project/lol/LoLNews.php
**/
class LoLNews
{
}
```

* 在 AVA 資料夾底下創一個 AvaNews Class
```php
/**
 * project/ava/AvaNews.php
**/
class AvaNews
{
}
```

* 新聞頁面 show 出新聞
```php
/**
 * project/index.php
**/
require('lol/LoLNews.php');
require('ava/AvaNews.php');
$lolNews = new LoLNews;
$avaNews = new AvaNews;
```

**但這不是個好方法，都用資料夾分門別類了，為什麼還要加前綴呢。**

### Namespace
* 在 LoL 資料夾底下創一個 News Class，並加上 namespace
```php
/**
 * project/lol/news.php
**/
namespace Lol;

class News
{
}
```

* 在 AVA 資料夾底下創一個 News Class，並加上 namespace
```php
/**
 * project/ava/news.php
**/
namespace Ava;

class News
{
}
```

* 新聞頁面 show 出新聞，可直接使用或使用 **use**
```php
/**
 * project/index.php
 * 直接使用
**/
require('lol/news.php');
require('ava/news.php');
$lolNews = new Lol\News;
$avaNews = new Ava\News;
```

```php
/**
 * project/index.php
 * 使用 use
**/
require('lol/news.php');
require('ava/news.php');

use Lol\News as LolNews;
use Ava\News as AvaNews;

$lolNews = new LolNews;
$avaNews = new AvaNews;
```
### 是不是很 easy 呢~