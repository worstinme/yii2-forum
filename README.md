# yii2-forum
forum extension for yii 2

------------------------------------
 
### Install

```
composer require --prefer-dist "worstinme/yii2-forum:dev-master"
```

### Example settings

```php
'forum' => [
    'class' => 'worstinme\forum\frontend\Module',
    'languages'=>[
        'ru'=>'Русский',
        'en'=>'English',
    ]
],
```

### Route
        
* '<lang:(en|ru)>/forum'=>'forum/default/index',
* '<lang:(en|ru)>/forum/<action:(section-create|forum-create|section-delete|forum-activate|forum-delete|section-activate)>'=>'forum/default/<action>',
* '<lang:(en|ru)>/forum/<action:(lock|new-thread|upload-image|file-browser|post-delete|delete|edit|reply)>'=>'forum/threads/<action>', 
* '<lang:(en|ru)>/forum/<section:[\w\-]+>'=>'forum/default/section',
* '<lang:(en|ru)>/forum/<section:[\w\-]+>/<forum:[\w\-]+>'=>'forum/default/forum',
* '<lang:(en|ru)>/forum/<section:[\w\-]+>/<forum:[\w\-]+>/<thread_id:\d+>'=>'forum/threads/view',

```
['pattern'=>'forum','route'=>'forum/default/index','defaults'=>['lang'=>'ru']],
['pattern'=>'forum/<action:(section-create|forum-create|section-delete|forum-activate|forum-delete|section-activate)>','route'=>'forum/default/<action>','defaults'=>['lang'=>'ru']],
['pattern'=>'forum/<action:(lock|new-thread|upload-image|file-browser|post-delete|delete|edit|reply)>','route'=>'forum/threads/<action>','defaults'=>['lang'=>'ru']],
['pattern'=>'forum/<section:[\w\-]+>','route'=>'forum/default/section','defaults'=>['lang'=>'ru']],
['pattern'=>'forum/<section:[\w\-]+>/<forum:[\w\-]+>','route'=>'forum/default/forum','defaults'=>['lang'=>'ru']],
['pattern'=>'forum/<section:[\w\-]+>/<forum:[\w\-]+>/<thread_id:\d+>','route'=>'forum/threads/view','defaults'=>['lang'=>'ru']],
```

### Default settings
 
```php
public $languages = ['en'=>'English'];
public $postPageSize = 20;
public $moderRole = 'admin';

public $profileModel = '\app\models\Profile';
public $profileModelUserColumn = 'id';

public $postEditDelay = 60*5;
public $postDeleteDelay = 60*5;
public $threadEditDelay = 60*5;
public $threadDeleteDelay = 60*5;

public $processLanguageSetting = true;
```

### Profile model

```php
<?php

namespace app\models;

use Yii;
use himiklab\thumbnail\EasyThumbnailImage;

class Profile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user';
    }

    public function getUrl() {
        return ['/profile/user','id'=>$this->user_id,'lang'=>Yii::$app->language];
    }

    public function getName() {
        return $this->name.' '.$this->surname;
    }

    public function getAvatarUrl() {
        return EasyThumbnailImage::thumbnailFileUrl(Yii::getAlias('@common').'/files'.$this->avatar, 160, 160, EasyThumbnailImage::THUMBNAIL_OUTBOUND);
    }

    public function getUrl() {
        return '#';
    }

}
```