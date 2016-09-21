Yii2 Media Manipulation Module
==============================
media manipulation implementation in Yii2


## Installation
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist mhndev/yii2-media "0.*"
```

or add

```
"mhndev/yii2-comment": "0.*"
```
to the require section of your `composer.json` file.

Introduction 
------------


This package helps you manipulate any kind of media (image , video, text, pdf, ...) for any kind of entity you like.
for example consider you have a Post Entity , first of all you should use EntityTrait in your model just like following :



this package also helps you upload media and specify max upload size for any kind of media and mime types
and also you can specify this package log if memory directory size which you upload file is less than x MB.
