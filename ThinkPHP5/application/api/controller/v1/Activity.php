<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/12
 * Time: 21:19
 */

namespace app\api\controller\v1;
use app\api\model\Activity as ActivityModel;
use app\api\validate\Count;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ActivityMissException;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\lib\exception\UserException;
use think\Db;

class Activity extends BaseController
{
    /*    获取指定的Activity信息
    @url activity/:id
    @http GET
    @id activity的id号
*/
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getFilename();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }

    protected $beforeActionList=[
        'checkSuperScope' => ['only'=>'createActivity']
    ];

    public function getActivity($id){
        (new IDMustBePositiveInt())->goCheck();

        $activity = ActivityModel::getActivityByID($id);
        if (!$activity){
            throw new ActivityMissException();
        }
        $activity = $activity->toArray();
        return $activity;
    }

    public function createActivity(){

        //        $validate =  new QuestionnaireNew();
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
//        $dataArray =  input('post.');

        $name = ActivityModel::get(['name'=>$dataArray['activity']['name']]);
        if($name != null){
            return ['msg' => 'duplicate name'];
        }
        $dataArray['questionnaire']['image'] = $dataArray['activity']['image'];
        $questionnaire = new Questionnaire();
        $questionnaireStatus = $questionnaire->createQuestionnaire($dataArray['questionnaire']);
        $dataArray['activity']['questionnaire_id'] = $questionnaireStatus['id'];

        $activity = new ActivityModel();
        $activity->save($dataArray['activity']);
        return [
            'msg' => 'success',
            'activity_id' => $activity->id,
            'name'=> $activity->name,
            'create_time' => $activity->create_time,
            'image'=> $activity->image,
            'questionnaire_status'=>$questionnaireStatus
        ];
    }

    public static function getRecent($count){
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }

        (new Count())->goCheck();
        $activities = ActivityModel::getMostRecent($count);


        //database.php中修改resultset_type，使得返回类型为collection对象而非数组，这样就额可以很方便的对一组对象进行
        //hidden等操作（banner里面 那个是一个对象所以所以可以直接hidden）
        //所以以后对于一组对象的判空异常，要使用isEmpty()函数，因为一个collection肯定不是空的，
        //只可能是它里面的一个数组是空的
        if($activities->isEmpty()){
            throw new ActivityMissException();
        }
        $time = time();
        $activities = $activities->toArray();
for($i = 0;$i<count($activities);$i++) {
    $map['questionnaire_id'] = $activities[$i]["questionnaire_id"];
    $map['user_id'] = $uid;
    $created = Db::table('user_questionnaire')
        ->where($map)
        ->find();
    if($created == null){
        $activities[$i]["questionnaire"]['created'] = 0;
    }else{
        $activities[$i]["questionnaire"]['created'] = 1;
    }
    $activities[$i]["questionnaire"]["batch_items"] = [
        "batch_item1" => $activities[$i]["questionnaire"]["batch_item1"],
        "batch_item2" => $activities[$i]["questionnaire"]["batch_item2"],
        "batch_item3" => $activities[$i]["questionnaire"]["batch_item3"],
        "batch_item4" => $activities[$i]["questionnaire"]["batch_item4"],
        "batch_item5" => $activities[$i]["questionnaire"]["batch_item5"],
        "batch_item6" => $activities[$i]["questionnaire"]["batch_item6"],
        "batch_item7" => $activities[$i]["questionnaire"]["batch_item7"],
        "batch_item8" => $activities[$i]["questionnaire"]["batch_item8"],
    ];
    $activities[$i]["questionnaire"] = array_diff_key($activities[$i]["questionnaire"],
        ["batch_item1" => "xy", "batch_item2" => "xy",
            "batch_item3" => "xy", "batch_item4" => "xy",
            "batch_item5" => "xy", "batch_item6" => "xy",
            "batch_item7" => "xy", "batch_item8" => "xy",]);
    if($time<$activities[$i]["questionnaire"]["deadline"]){
        $activities[$i]["questionnaire"]["closed"] = 0;
    }else{
        $activities[$i]["questionnaire"]["closed"] = 1;
    }

    $activities[$i]["image"] = 'http://uncle-justice.top' . DS . 'uploads'.DS.$activities[$i]["image"];

}
        return $activities;
    }

}