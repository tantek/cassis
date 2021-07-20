cassis.js
=========

<img src="http://tantek.pbworks.com/f/1297010926/cassis128.png" alt="" align="left" /> CASSIS stands for: client and server scripting implementation subset.

Conceived [in late 2008](http://twitter.com/t/statuses/916632211), the goal of the CASSIS Project is universal javascript (JS) that works on the client and the server for scalable application logic. The primary use-case is writing code to implement application logic that runs in browsers, especially dynamic interfaces that make use of XMLHTTPRequest (XHR/AJAX/AHAH), and also runs on web servers.

Until typical hosting companies support running JS on the server, CASSIS code must run in at least two programming language environments, JS on the client, and something that can be made to resemble JS on typical hosting company servers, which turns out to be PHP.

For more background see:
http://cassisjs.org

Including CASSIS
----------------

Use the following code to include cassis.js locally from your server:

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
$ npm test
```

Experimental live
-----------------

Experimental CASSIS improvements and additions are tested live here:
* https://tantek.com/cassis.js

If you're curious or want to try a version potentially newer than the cassis.js published here.
