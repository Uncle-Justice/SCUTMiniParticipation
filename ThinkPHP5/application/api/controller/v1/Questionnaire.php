<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/13
 * Time: 10:04
 */

namespace app\api\controller\v1;
use \app\api\model\Questionnaire as QuestionnaireModel;

class Questionnaire extends BaseController
{
    protected $beforeActionList=[
        'checkSuperScope' => ['only'=>'createQuestionnaire']
    ];

    public function createQuestionnaire($dataArray){
        //        $validate =  new QuestionnaireNew();
        //        $validate->goCheck();
//        $uid = TokenService::getCurrentUid();
//        $user = UserModel::get($uid);
//        if(!$user){
//            throw new UserException();
//        }

        //微信小程序里要改成$dataArray = $validate->getDataByRule(input('post.value/a'));
        //必须加‘/a’才能获取到数组形式的参数
//        $dataArray = $validate->getDataByRule(input('post.'));
//        $dataArray = $validate->getDataByRule(input('post.value/a'));
//        $dataArray =  input('post.value/a');
//        $dataArray =  input('post.');

        $questionnaire = new QuestionnaireModel();
        $questionnaire->save($dataArray);
        return [
            'id' => $questionnaire->id,
            'name'=> $questionnaire->name,
            'create_time' => $questionnaire->create_time
        ];

    }
}