# Iterator

## IteratorAggregate

* When an Class Implement this interface, it'll let the object concrete from this class can be iterated.
* Elements depends on which return form getIterator method, if it's $this, elements' key and value will be object field and value.


```php
IteratorAggregate extends Traversable {
    /* Methods */
    abstract public Traversable getIterator ( void )
}
```

### Reference

* [The IteratorAggregate interface@PHP.NET](http://php.net/manual/en/class.iteratoraggregate.php)
* [Simple Object Iterators in PHP@SitePoint](https://www.sitepoint.com/php-simple-object-iterators/)