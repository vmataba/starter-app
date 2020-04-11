<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\assets\tools;

/**
 * Description of FileViewer
 *
 * @author Victor Mataba <vmataba0@gmail.com>
 */
class FileViewer {

    public static function widget($file, $filePath) {

        return \Yii::$app->controller->renderPartial('@app/views/tools/_file_attachment', [
                    'file' => $file,
                    'filePath' => $filePath
        ]);
    }

}
