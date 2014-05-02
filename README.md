#ターミナルでツイッターを見る

```

$git clone git@github.com:MasatoYoshioka/tw.git
$composer install

```

```
vi ~/bin/tw.php
define('CONSUMER_KEY','your consumer_key');
define('CONSUMER_SECRET','your consumer_secret');
define('ACCESS_TOKEN','your access_token');
define('ACCESS_SECRET','your access_secret');

$php ~/bin/tw.php
```
