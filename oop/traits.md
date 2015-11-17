# Traits

A Trait is intended to reduce some limitations of single inheritance by enabling a developer to reuse sets of methods freely in several independent classes living in different class hierarchies.

## 概念

* vs. service class

洛克人裝備和萊西的分別，裝備沒主人裝就不能動，萊西沒主人可以自己活蹦亂跳。

* vs. helper

在地圖上的資源，一開始就放在那，不管誰都可以使用，跟誰一點關係都沒有，一般處理基本型態時使用。

* vs. parent class

裝備 vs 老爸，沒了裝備失去功能，沒有老爸喪失自我。

## 範例

### 組合

```
traits XBuster
{
    public function canon()
    {
        echo "}}}}}}";
    }
}
```

### 改變方法可見度

### 抽象方法

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