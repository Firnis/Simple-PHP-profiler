Simple-PHP-profiler
===================
 
### Setting up:

```
include "Profiler.php"
```

### Usage:

```
<?php

$profiler = new Profiler();

$profiler->run("profile name");
...
$profiler->run("profile2 name");
...
for(...) {

$profiler->run("profile3 name");
...
$profiler->stop("profile3 name");

}
...

$profiler->stop("profile2 name");

...

$profiler->stop("profile name");

var_dump($profiler->toArray());

?>
```
