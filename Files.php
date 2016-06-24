<?php

namespace app\components;

use Yii;
use yii\base\Exception;
use yii\base\Component;
/**
 * Example usage:
 * In some file in view (i.e. folder views in Yii project) we can use this 
 * component in follow way:
 * <?= Html::img(Yii::$app->files->getFile('@myalias/some_file_name.png')) ?>
 * 
 * It's useful for reading image files in Linux servers, where we haven't 
 * access for example to /aux0/uploaded_images/ directly i.e. we can't 
 * use <img src="/aux0/uploaded_images/some_file_name.png"/> directly
 */
class Files extends Component{
    private $path;
    private $alias;
    private $fileName;
    private $fileContent;
    private $fileContentBase64;
    private $mimeType;
    
    public function getFile($alias){
        /**
         * Check the filename and alias file type
         * Throw new exception if they are of type that differ from string
         */
        
        $path = Yii::getAlias($alias);
        
        if(gettype($alias) !== 'string'){
            throw new Exception($alias . ' must be of type string', -1);
        }
        
        /**
         * Check if file exist
         */
        
        if(file_exists($path) === FALSE){
            throw new Exception('Cannot find file!');
        }
        
        $mimeType = mime_content_type($path);
        
        //To Do check file permission
        
        $fileContent = file_get_contents($path);
        $fileContentBase64 = base64_encode($fileContent);
        return 'data: '. $mimeType . ';base64,' . $fileContentBase64;
    }
}
