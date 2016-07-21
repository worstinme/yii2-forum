<?php

namespace worstinme\forum\helpers;

use Yii;

class UploadAction extends \worstinme\jodit\UploadAction
{
    protected function afterFileSave($fileName, $path, $folder) {

        $uploadedFiles = Yii::$app->session->get('uploadedFiles',[]);
        $uploadedFiles[] = $folder.$fileName;
        Yii::$app->session->set('uploadedFiles',$uploadedFiles);
        
    }
}