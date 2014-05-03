#ターミナルでツイッターを見る

```
$git clone git@github.com:MasatoYoshioka/tw.git
$composer install
```

```

cp ~/config/config.yaml.sample ~/config.config.yaml

$php ~/bin/tw.php
```

##For example

```
$vi .zshrc 
alias tw="/usr/bin/php ~/path/to/tw/bin/tw.php"
$source .zshrc
$tw
```
