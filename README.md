[![Circle CI](https://circleci.com/gh/bear/cassis.svg?style=shield)](https://circleci.com/gh/tantek/cassis)

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
include 'cassis.php';
```

In PHP using Composer:

```
  "require": {
    "tantek/cassis": "0.1.*"
  },
```

```
require_once 'vendor/autoload.php';
```

Tests
-----

To run the PHP tests:

```
$ phpunit.phar
```

To run the JS tests:

```
$ tape js-tests/*.js | tap-spec
```

or if you don't have tape and tap-spec installed globally, then

```
$ ./node_modules/tape/bin/tape js-tests/*.js | ./node_modules/tap-spec/bin/cmd.js
```
