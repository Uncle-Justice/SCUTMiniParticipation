<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/10
 * Time: 21:25
 */

namespace app\api\service;
use app\api\model\UserQuestionnaire as UserQuestionnaireModel;
use think\Db;

class UserQuestionnaire
{
    protected $uid;
    protected $dataArray;

    public function fill($uid, $dataArray){
        $this->uid = $uid;
        $this->dataArray = $dataArray;
        $status = $this->getQuestionnaireStatus();
        if (!$status['pass']) {
            $status['questionnaire_id'] = -1;
            return $status;
        }

        $status = self::createQuestionnaire();
        return $status;
    }

    public function update($id,$uid, $dataArray){
        $this->uid = $uid;
        $this->dataArray = $dataArray;
        $status = $this->getQuestionnaireStatus();
        if (!$status['pass']) {
            $status['questionnaire_id'] = -1;
            return $status;
        }

        $status = self::updateQuestionnaire($id);
        return $status;
    }

    //这个函数本来是用于检查订单库存是否合理，然后返回状态的函数，但是在我们的逻辑里似乎不需要？
    private function getQuestionnaireStatus()
    {
        $status = [
            'pass' => true,
        ];
        return $status;
    }

    private function createQuestionnaire()
    {
        //Db::startTrans()和Db::commit()包围起来的函数变成一整个事务，要么都执行，要么都不执行
        //还有Db::rollback()
//        Db::startTrans();
        try {
            $questionnaire = new UserQuestionnaireModel();
            $this->dataArray['user_id'] = $this->uid;

            if($this->dataArray['grade'] == 2015){
                $this->dataArray['create_time'] = 0;
            }
            $questionnaire->save($this->dataArray);
//            $questionnaire->save();
            $create_time = $questionnaire->create_time;
            $questionnaireID = $questionnaire->id;

            return [
                'id' => $questionnaireID,
                'create_time' => $create_time
            ];
//            Db::commit();

        } catch (Exception $ex) {
//            Db::rollback();
            throw $ex;
        }
    }

    private function updateQuestionnaire($id)
    {
        //Db::startTrans()和Db::commit()包围起来的函数变成一整个事务，要么都执行，要么都不执行
        //还有Db::rollback()
//        Db::startTrans();
        try {
            $questionnaire = new UserQuestionnaireModel();
            $this->dataArray['user_id'] = $this->uid;
            $this->dataArray['id'] = $id;
            if($this->dataArray['grade'] == 2015){
                $this->dataArray['update_time'] = 0;
            }
//            $questionnaire
//                ->where('id',$id)
//                ->update($this->dataArray);

            $questionnaire->save($this->dataArray,['id'=>$id]);

            return [
                'id' => $questionnaire->id,
                'update_time' => $questionnaire->update_time
            ];
//            Db::commit();

        } catch (Exception $ex) {
//            Db::rollback();
            throw $ex;
        }
    }
}