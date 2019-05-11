<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/5/3
 * Time: 9:34
 */


namespace app\api\controller\v1;
use app\api\model\Questionnaire as QuestionnaireModel;
use app\api\model\User as UserModel;
use app\api\service\Token as TokenService;
use app\lib\exception\UserException;
use think\Db;
use http\Client\Curl;
use PHPExcel;

class Manage extends BaseController
{
    public function approve(){
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }
        $dataArray =  input('post.value/a');
//        $dataArray =  input('post.');

        $limit = QuestionnaireModel::where('id','=',$dataArray['id'])
                                        ->column('limit');
        $limit = $limit[0];
        Db::table('user_questionnaire')
            ->where('questionnaire_id','=',$dataArray['id'])
            ->order('create_time asc')
            ->limit($limit)
            ->update(['status' => '已录取']);
        Db::table('user_questionnaire')
            ->where('status','审核中')
            ->update(['status' => '未录取']);
        Db::table('questionnaire')
            ->where('id',$dataArray['id'])
            ->update(['approved' => 1]);
        $status  = ["msg"=>"一键筛选成功","success"=>1];
        return $status;
    }

    function excel_down(){

        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }

        $xlsName  = "export";
        $xlsCell  = array(
            array('name','名字'),
//            array('nickname','名字'),
//            array('email','邮箱'),
        );
        $xlsData  = Db::table('user_questionnaire')->field('name')->select();
        $this->exportExcel($xlsName,$xlsCell,$xlsData);
    }

    function exportExcel($expTitle,$expCellName,$expTableData){
        include_once EXTEND_PATH.'PHPExcel/PHPExcel.php';//方法二
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $expTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
//        $objPHPExcel = new PHPExcel();//方法一
        $objPHPExcel = new \PHPExcel();//方法二
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for($i=0;$i<$dataNum;$i++){
            for($j=0;$j<$cellNum;$j++){
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
            }
        }
        ob_end_clean();//这一步非常关键，用来清除缓冲区防止导出的excel乱码
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xlsx"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//"xls"参考下一条备注
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');//"Excel2007"生成2007版本的xlsx，"Excel5"生成2003版本的xls
        $objWriter->save('php://output');
        exit;
    }


}