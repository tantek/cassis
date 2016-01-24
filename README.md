cassis.js
=========

http://cassisjs.org

Including CASSIS
----------------

Use the following code to include cassis.js:

Clientside in HTML:

```
<script type="text/javascript" src="cassis.js"></script>
```

Serverside in PHP:

```
ob_start(); // stops the few HTML comments in CASSIS from being outputted
include 'cassis.js';
ob_end_clean();
```

In PHP using Composer:

```
  "require": {
    "tantek/cassis": "0.1.*"
  },
```

```
ob_start();
require_once 'vendor/autoload.php';
ob_end_clean();
```

Tests
-----

To run the PHP tests:

```
$ phpunit.phar
```
