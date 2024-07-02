<?php


namespace app\controllers;

use app\models\Users;
use Yii;
use yii\rest\Controller;

class UserController extends Controller
{
    public function actionIndex()
    {
        $listUser = Users::find()->orderBy("id")->all();
        return ['status' => true, 'data' => ['ListUser' => $listUser, 'now' => date('d/m/Y')], 'message' => 'success'];
    }

    public function actionCreate()
    {

        $user = new Users();
        // $user->username = 'thinh';
        // $user->password_hash = 'ddsadadsadsd321';
        // $user->age = '21';

        $user->username = Yii::$app->request->post('username');
        $user->password_hash = Yii::$app->getSecurity()->generatePasswordHash(Yii::$app->request->post('password'));
        $user->age = Yii::$app->request->post('age');

        $user->save();
    }

    public function actionDelete($id)
    {
        $user = Users::findOne($id);
        if ($user->delete()) {
            return ['status' => true, 'data' => ['now' => date('d/m/Y')], 'message' => 'success'];
        }
    }
    public function actionLogin()
    {
        $dataRequest = Yii::$app->request->post();
        if (isset($dataRequest['username']) && $dataRequest['password']) {
            $userAccount = 'toan';
            $passwordAccount = md5(123);
            if ($dataRequest['username'] === $userAccount && md5($dataRequest['password']) === $passwordAccount) {
                return [
                    'status' => true,
                    'data' => [
                        'now' => date('d/m/Y')
                    ],
                    'message' => 'success'
                ];
            } else {
                return [
                    'status' => false,
                    'data' => [
                        'now' => date('d/m/Y')
                    ],
                    'message' => 'Invalid username or password'
                ];
            }
        } else {
            return [
                'status' => false,
                'data' => [
                    'now' => date('d/m/Y')
                ],
                'message' => 'empty input'
            ];
        }
    }
}