<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/10
 * Time: 21:21
 */

namespace app\api\controller\v1;
use app\api\service\UserQuestionnaire as UserQuestionnaireService;
use app\api\model\User as UserModel;
use app\api\model\UserQuestionnaire as UserQuestionnaireModel;
use app\api\model\Questionnaire as QuestionnaireModel;
use app\api\model\Notification as NotificationModel;
use app\api\service\Token as TokenService;
use app\api\validate\UserQuestionnaireNew;
use app\lib\exception\UserException;

class UserQuestionnaire extends BaseController
{
    //先检查POST过来的数据是否符合规范
    //再获取当前token所属的user_id，定位到具体的用户
    //POST数据必然会包含questionnaire_id,我们拿着user_id和questionnaire_id去数据库查询
    //如果这个数据已经存在，就去修改，如果不存在，就保存
    protected $beforeActionList=[
        'checkExclusiveScope' => ['only'=>'fillQuestionnaire']
    ];

    public function fillQuestionnaire(){
//        $validate =  new UserQuestionnaireNew();
//        $validate->goCheck();

        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }

        //微信小程序里要改成$dataArray = $validate->getDataByRule(input('post.value/a'));
        //必须加‘/a’才能获取到数组形式的参数
//        $dataArray = $validate->getDataByRule(input('post.'));
//        $dataArray = $validate->getDataByRule(input('post.value/a'));
          $dataArray =  input('post.value/a');
//          $dataArray =  input('post.');


        $batch_item1 = QuestionnaireModel::where('id',$dataArray['questionnaire_id'])
            ->column('batch_item1');
        $batch_items = QuestionnaireModel::where('id',$dataArray['questionnaire_id'])
            ->column('batch_item1,batch_item2,batch_item3,batch_item4,
            batch_item5,batch_item6,batch_item7,batch_item8');
        $batch_items = $batch_items[$batch_item1[0]];


        $map['questionnaire_id'] = $dataArray['questionnaire_id'];

        $map['user_id'] = $uid;
        $userQuestionnaire = $user->userQuestionnaire()
            ->where($map)
            ->select();

        if($userQuestionnaire->isEmpty()){
            //如果这个userQuestionnaire不存在，就保存
            $userQuestionnaire = new UserQuestionnaireService();

            foreach($dataArray['batch_items'] as $v1){
                foreach ($batch_items as $k2=>$v2){

                    if($v2 == null){
                        break;
                    }
                    else{
                        if($v2 == $v1){
                            $dataArray[$k2] = $v1;
                        }
                    }
                }
            }
            $dataArray = array_diff_key($dataArray,['batch_items'=>'xy']);
            $status = $userQuestionnaire->fill($uid, $dataArray);
            $notification = new NotificationModel();
            $notification->save(['uq_id'=>$status['id']]);
            return $status;
        }
        else{

            foreach ($batch_items as $k2=>$v2){
                $dataArray[$k2] = null;
            }
            foreach($dataArray['batch_items'] as $v1){
                foreach ($batch_items as $k2=>$v2){
                    if($v2 == null){
                        break;
                    }
                    else{
                        if($v2 == $v1){
                            $dataArray[$k2] = $v1;
                            break;
                        }
                    }
                }
            }
            $dataArray = array_diff_key($dataArray,['batch_items'=>'xy']);
            $id = $user->userQuestionnaire()
                ->where('questionnaire_id', '=',$dataArray['questionnaire_id'])
                ->value('id');
            $userQuestionnaire = new UserQuestionnaireService();
            $status = $userQuestionnaire->update($id,$uid, $dataArray);
            return $status;
        }

    }

    public function deleteUserQuestionnaire(){
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }

        $dataArray =  input('post.value/a');
        $questionnaire =UserQuestionnaireModel::get(['id'=>$dataArray['id']]);
        if($questionnaire != null){
            $questionnaire->delete();
            return ['msg' => "success"];
        }else{
            return ['msg' => "object required not found"];
        }
    }

    public function getUserQuestionnaire(){
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }



        $questionnaires =UserQuestionnaireModel::all(['user_id'=>$uid],'questionnaire');
        $questionnaires = $questionnaires->toArray();
        for($i = 0;$i<count($questionnaires);$i++) {
            $questionnaires[$i]['questionnaire']['image'] = 'http://uncle-justice.top' . DS . 'uploads'.DS.$questionnaires[$i]['questionnaire']['image'];
        }
//        echo $questionnaires->all()->value('questionnaire_id');
        return $questionnaires;


    }

    public function getNotification(){

    }
}
