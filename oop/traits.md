# Traits

A Trait is intended to reduce some limitations of single inheritance by enabling a developer to reuse sets of methods freely in several independent classes living in different class hierarchies.

一堆方法的集合，它不屬於特定類別區塊，又會被很多類別區塊用到，無法獨立創建，需要依附在物件上面。

## 概念

* traits vs. service class

洛克人裝備和萊西的分別，裝備沒主人裝載就不能動，萊西沒主人可以自己活蹦亂跳。

* traits vs. helper

裝備 vs. 地圖上的資源，資源一開始就放在那，不管誰都可以使用，跟誰一點關係都沒有，一般處理基本型態時使用。

* traits vs. parent class

裝備 vs 父母，沒了裝備失去功能，沒有父母喪失自我。一個是強化，一個是靈魂。

## 範例

### 基本用法

```php
traits XBuster
{

	public $version = 1;

    public function canon()
    {
        echo "}}}}}}";
    }
}

class MegaMan
{
    use XBuster;

    public function shut()
    {
    	echo ">>>>>>";
    }
}

$megaMan = new MegaMan;

echo $megaMan->shut();
echo $megaMan->version;
echo $megaMan->canon();
```

### 抽象方法

```php
traits Footer
{
	// 新功能
    public function slip()
    {
        echo "_>_>";
    }

    // 基本功能加強版
    public function run()
    {
    	$this->walk();
    	echo '.';
    }

    abstract public function walk();
}

class MegaMan
{
    use Footer;

    public function shut()
    {
    	echo ">>>>>>>";
    }

    public function walk()
    {
    	echo "..";
    }
}

$megaMan = new MegaMan;

echo $megaMan->slip();
echo $megaMan->walk();
echo $megaMan->run();

```

### 套裝組合

```php
traits XBuster
{

	public $version = 1;

    public function canon()
    {
        echo "}}}}}}";
    }
}

traits Footer
{
	// 新功能
    public function slip()
    {
        echo "_>_>";
    }

    // 基本功能加強版
    public function run()
    {
    	$this->walk();
    	echo '.';
    }

    abstract public function walk();
}

traits Limbs
{
    use XBuster, Footer;
}


class MegaMan
{
    use Limbs;

    public function shut()
    {
    	echo ">>>>>>>";
    }
}

$megaMan = new MegaMan;

echo $megaMan->canon();
echo $megaMan->run();
```

### 改變方法可見度

```php
traits Footer
{
	// 新功能
    public function slip()
    {
        echo "_>_>";
    }

    // 基本功能加強版
    public function run()
    {
    	$this->walk();
    	echo '.';
    }

    abstract public function walk();
}

class MegaMan
{
	use Footer {
		slip as private;
    }
}
```

## 特性

* 不可 new
* 沒有建構子
* 同方法時執行順序：類別 > Traits > 父類別

### 

## Reference
* [What are PHP Traits?](http://culttt.com/2014/06/25/php-traits/)
* [逐步提昇PHP技術能力 - PHP的語言特性 ： Traits](http://ithelp.ithome.com.tw/question/10133226)
* [Traits@php.net](http://php.net/manual/en/language.oop5.traits.php)
* [Traits@Hack and HHVM](http://docs.hhvm.com/manual/en/hack.traits.php)