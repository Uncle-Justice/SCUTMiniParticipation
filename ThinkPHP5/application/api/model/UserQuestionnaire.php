<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/10
 * Time: 21:07
 */

namespace app\api\model;


use think\Db;

class UserQuestionnaire extends BaseModel
{
    protected $hidden = ['extend','delete_time'];
    protected $autoWriteTimestamp = true;

    public function questionnaire(){
        $result = $this->belongsTo('Questionnaire', 'questionnaire_id','id');
        return $result;
    }

    public static function getNotification($uid){
        $result = self::all(['user_id'=>$uid]);
        $result = $result->toArray();
        $j = 0;
//        ->value('notification1,already_read1,notification2,already_read2,notification3,already_read3');
        for($i = 0;$i < count($result);$i++){

            $notification[$i]['id'] = $result[$i]['id'];
            $name = Db::table('activity')->where('questionnaire_id' ,'=',$result[$i]['questionnaire_id'])
                                                        ->column('name');
            $notification[$i]['activity_name'] = $name[0];
            $notification[$i]['notification1'] = $result[$i]['notification1'];
            $notification[$i]['already_read1'] = $result[$i]['already_read1'];
            if($notification[$i]['notification1'] != null && $notification[$i]['already_read1'] == 0)
                $j++;
            $notification[$i]['notification2'] = $result[$i]['notification2'];
            $notification[$i]['already_read2'] = $result[$i]['already_read2'];
            if($notification[$i]['notification2'] != null && $notification[$i]['already_read2'] == 0)
                $j++;
            $notification[$i]['notification3'] = $result[$i]['notification3'];
            $notification[$i]['already_read3'] = $result[$i]['already_read3'];
            if($notification[$i]['notification3'] != null && $notification[$i]['already_read3'] == 0)
                $j++;
            $notification[$i]['update_time'] = $result[$i]['update_time'];
        }
        $notification['total'] = $j;
        return $notification;

    }

}