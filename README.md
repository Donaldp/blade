# blade
Blade for modulusPHP

## Installing

```
composer require don47/blade
```

## Setting up

Open `app\Config\grammer.php` and add the following code inside `return`

```
'don47-blade' => [
  'enabled' => true,
  'class' => Don47\Grammer\Blade::class
]
```

Your `app\Config\grammer.php` file should now look like this:
```
<?php

return [

  'don47-blade' => [
    'enabled' => true,
    'class' => Don47\Grammer\Blade::class
  ]

];
```