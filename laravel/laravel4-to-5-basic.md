## Flow

```sequence
/public/index.php->Route:
Route->Controller:
Controller->Model:
Model-->Controller:data
Controller->View:
```

## Env

**Laravel 5 doesn't have environment detection**, use .env.example

|       | 4.2 | 5 |
|-------|-----|------|
|env| app/config/[envfolder] | .env |

## Namespace
* Naming Your Application (optional)

```
php artisan app:name Mstar
```


## Route

|  |  4.2 |  5|
|---|------|------|
|middleware | filter | middleware|
|where(global) | app/route.php |app/Providers/RouteServiceProvider.php|


### Middleware

**CSRF Protection is default middleware in Laravel 5**

* 4.2

```php
// app/filter.php
Route::filter('csrf', function()
{
    if (Session::token() != Input::get('_token'))
    {
        throw new Illuminate\Session\TokenMismatchException;
    }
});
```

* 5

```php
// app/Http/Middleware/VerifyCsrfToken.php
class VerifyCsrfToken extends BaseVerifier {

    public function handle($request, Closure $next)
    {
        return parent::handle($request, $next);
    }
}
```

#### Register

```php
// app/Http/Kernel.php

// The application's global HTTP middleware stack.
protected $middleware = [
    //...
    'App\Http\Middleware\VerifyCsrfToken',
];

// The application's route middleware.
protected $routeMiddleware = [
    //...
    'csrf' => 'App\Http\Middleware\VerifyCsrfToken',
];
```

#### Using
* 4.2

```php
Route::get('/', array('before' => 'csrf|auth', 'uses' => 'index@HomeController'));
```

* 5

```php
Route::get('/', ['middleware' => ['csrf', 'auth'], 'uses' => 'index@HomeController']);
```

### Where
#### Global
* 4.2

```php
// app/route.php
Route::pattern('id', '[0-9]+');
```

* 5

```php
// app/Providers/RouteServiceProvider.php
public function boot(Router $router)
{
    $router->pattern('id', '[0-9]+');
    parent::boot($router);
}
```

## Controller

### Parent Class & Namespace

* 4.2

```php
// app/controllers/HomeController.php

class HomeController extends BaseController {}
```

* 5

```php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

class HomeController extends Controller {}
```

## Model

### Parent Class & Namespace

* 4.2
```php
// app/models/User.php
class User extends Eloquent {
}
```

* 5
```php
// app/User.php
use Illuminate\Database\Eloquent\Model;

class User extends Model {
}
```

### Others

* Laravel 5: if you wanna create instance, you have to set
```
protected $guarded = [];

//default
protected $guarded = ['*'];
```
* Relation has to setting namespace

```php
public function users()
{
    return $this->hasMany('App\Models\User');
}
```

### Eager Loading

* 4.2

```php
$report->report_assigns
```

* 5

```php
$report->reportAssigns
```

## View

### Echo
|    | 4.2 | 5 |
-----|-----|----
|escape | `{{{ $data }}}` | `{{ $data }}`|
|raw | `{{ $data }}` | `{!! $data !!}`|

### HTML Helper
* 4.2
  * HTML::
  * FORM::
* 5 (It's removed, solution)
  1. [Adding html package](http://laravelcollective.com/docs/5.0/html)
  2. Using original html tag
```html
<script src="{{ asset("js/jquery.js") }}"></script>
```

```html
<link rel="stylesheet" href="{{ asset("css/style.css") }}">
```

```
<form>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="PUT">
</form>
```

## Pagination

### methods
| 4.2 | 5 |
|-----|----|
| **getTotal()** | **total()**|
| **links()** | **render()**|
| getCurrentPage() | currentPage()|
| getLastPage() | lastPage()|
| getPerPage() | perPage()|
| getFrom() | firstItem()|
| getTo() | lastItem()|

### Customize

* 4.2, modify config or dynamic setting
```php
// app/config/view.php
'pagination' => 'pagination::slider-3',
```

```php
// views/news.php
$news->links('view.name');
```

* 5, Implement Presenter
```php
// Illuminate/Pagination/BootstrapThreePresenter.php

use Illuminate\Contracts\Pagination\Presenter as PresenterContract;

class BootstrapThreePresenter implements PresenterContract
{
}
```

* Give render method presenter object

```php
$news->render($bootstrapThreePresenter);
```

## Package
### Auth

* 4.2, it doesn't maintain anymore.

```
"artdarek/oauth-4-laravel"
```

* 5 (Official Package: Socialite), **Socialite needs your Google app to have Google+ API enabled.**

```
"laravel/socialite": "~2.0"
```

### Predis
* Adding predis to proeject composer.json require block, **In laravel 5,  predis move from require to require-dev.**

```
"predis/predis": "~1.0"
```
