<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/27
 * Time: 14:17
 */

namespace app\api\controller\v1;
use app\api\model\UserQuestionnaire as UserQuestionnaireModel;
use app\api\model\User as UserModel;
use app\api\model\Activity as ActivityModel;
use app\api\service\Token as TokenService;
use app\lib\exception\UserException;
use think\Cache;
use think\Db;


class Notification
{
    public function getRecent(){
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }

        $notifications = UserQuestionnaireModel::getNotification($uid);
        return $notifications;

    }

    public function alreadyRead(){
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }
                  $dataArray =  input('post.value/a');
//        $dataArray =  input('post.');


        $userquestionnaire = new UserQuestionnaireModel();
        $userquestionnaire->save([$dataArray['already_read']=>1],['id'=>$dataArray['id']]);
        $status  = ["already_read"=>$dataArray['already_read'],"id"=>$dataArray['id']];
        return $status;
    }

    public function releaseNotice(){
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }
        $dataArray =  input('post.value/a');
//        $dataArray =  input('post.');


        $re = Db::table('user_questionnaire')
            ->where('questionnaire_id','=',$dataArray['id'])
            ->where('status','=',$dataArray['target'])
            ->column($dataArray['notification']);
        if ( $re == null || $re[0] == ''){

            Db::table('user_questionnaire')
                ->where('questionnaire_id','=',$dataArray['id'])
                ->where('status','=',$dataArray['target'])
                ->update([$dataArray['notification']=>$dataArray['detail']]);
            $status = ["already_full"=>0];
        }
        else{
            $status = ["already_full"=>1];
        }
        $respond = $this->sendMessage($dataArray['id']);
        $status["sendMessageRespond"] = $respond;
        return $status;
    }

    //发送模板消息
    public function sendMessage($id){
        $token = Cache::get('token');
        $userquestionnaire = UserQuestionnaireModel::get($id);
        $openid =  $userquestionnaire->openid;
        $qid = $userquestionnaire->questionnaire_id;
        $activity_name = ActivityModel::get(['questioannaire_id' => $qid])->name;
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$token);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        $post_data = array(
            "touser"=>$openid,
            "template_id" => "qozId9HglwPO3LyOwXFEmh67fuPoOQtX6TshiXlDPr8",
            "page"=> "index",
            "form_id"=>"FORMID",
            "data"=>array(
                "keyword1"=>array(
                "value"=> $activity_name
                ),
                "keyword2"=> array(
                    "value"=> $userquestionnaire->status
                ),
                "keyword3"=>array(
                    "value"=> "你有新的活动通知，请进入小程序查看具体信息"
                ),
                "keyword4"=> array(
                    "value"=>$userquestionnaire->update_time
                )
            ),
//            "emphasis_keyword"=>"keyword1.DATA"
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return ($data);
    }
}