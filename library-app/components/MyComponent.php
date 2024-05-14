<?php

namespace app\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
 
class MyComponent extends Component
{
    function function_alert($message) {
        echo "<script>alert('$message');</script>";
    }
}
?>