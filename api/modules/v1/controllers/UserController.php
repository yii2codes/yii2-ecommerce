<?php
 
namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;

///use api\modules\v1\components\ActiveController;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

 
/**
 * User Controller API
 *
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>
 */
class UserController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];
        
        return $behaviors;
    }
}