<a href="https://arpite.dev">
  <img alt="Arpite hero image" src="./.github/HeroImage.png">
</a>

# Arpite

An open-source Laravel library for building high-quality, accessible applications and administration dashboards. Built using [Inertia.js](https://inertiajs.com/), [React](https://reactjs.org/), [TailwindCSS](https://tailwindcss.com/), and [HeadlessUI](https://headlessui.com/).

## Getting Started

**⚠️ Arpite is currently in early development and APIs are likely to change quite often. Use in production on your own risk!**

1. Install the packages from Composer and NPM

```bash
composer require arpite/arpite
yarn add @arpite/arpite
```

2. Render Arpite in `resources/js/app.js` file

```js
import { Arpite } from "@arpite/arpite";
import "@arpite/arpite/resources/dist/arpite.css";

Arpite.render();
```

3. Build assets

```bash
yarn build
```

4. Add to AppServiceProvider boot() method

```php
Inertia::share([
	"baseUrl" => fn() => URL::to("/"),
	"applicationName" => fn() => env("APP_NAME"),
	"notification" => fn() => Notification::getAndClear(),
	"resetFormIdentifier" => fn() => Session::get("resetFormIdentifier"),
	"csrfToken" => fn() => csrf_token(),
	"balance" => null,
]);
```

5. Add `HandleArpiteRequests` middleware to `web` group inside `app/Http/Kernel.php` file

```php
'web' => [
    \Arpite\Core\Middlewares\HandleArpiteRequests::class
]
```

6. Add to RouteServiceProvider getHomepage() method

```php
public static function getHomepage(): string
{
    return self::HOME;
}
```
