# Cygnus

## Installation
1. Clone into project
```bash
git clone git@github.com:sudobeecom/cygnus.git
```

2. Add repository to project
```json
"repositories": [
    {
        "type": "path",
        "url": "./cygnus"
    }
],
```

3. Require new package
```json
"require": {
    "sudobee/cygnus": "*"
},
```

4. Update packages using composer
```bash
composer update
```

5. Publish/re-publish assets
```bash
rm -rf public/vendor/cygnus
php artisan vendor:publish --tag=cygnus-assets
```

6. Add `app.blade.php`
```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-y-scroll">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('fonts/inter/inter.css') }}" />

    <link rel="stylesheet" href="/vendor/cygnus/index.css">
    <script src="/vendor/cygnus/index.js" defer></script>

    <style>
        :root {
            --cygnus-primary-50: 239 246 255;
            --cygnus-primary-100: 219 234 254;
            --cygnus-primary-200: 191 219 254;
            --cygnus-primary-300: 147 197 253;
            --cygnus-primary-400: 96 165 250;
            --cygnus-primary-500: 59 130 246;
            --cygnus-primary-600: 37 99 235;
            --cygnus-primary-700: 29 78 216;
            --cygnus-primary-800: 30 64 175;
            --cygnus-primary-900: 30 58 138;
        }
    </style>
</head>
<body class="antialiased font-base">
    @inertia
</body>
</html>
```

7. Add to AppServiceProvider boot() method
```php
Inertia::share([
    "baseUrl" => fn() => URL::to("/"),
    "applicationName" => fn() => env("APP_NAME"),
    "notification" => fn() => Notification::getAndClear(),
    "resetFormIdentifier" => fn() => Session::get(
        "resetFormIdentifier"
    ),
    "csrfToken" => fn() => csrf_token(),
]);
```

8. Add to HandleInertiaRequests share() method
```php
/** @var User|null $user */
$user = auth()->check() ? auth()->user() : null;

return array_merge(parent::share($request), [
    "user" => $user?->only("email", "name"),
    "balance" => null,
]);
```

9. Add to RouteServiceProvider getHomepage() method
```php
public static function getHomepage(): string
{
    return self::HOME;
}
```

## Update
Run inside your project directory:
```bash
git submodule update --remote --merge
```
