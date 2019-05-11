<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/23
 * Time: 20:27
 */

namespace app\lib\exception;



use think\exception\Handle;
use think\Log;
use think\Request;
use think\Exception;

//使用这种全局异常处理的好处：平时写代码的时候会抛出很多异常，
//那么就直接抛出去就好了，把剩下的烂摊子全部交给ExceptionHandler

//默认抛出的异常如果没有被catch解决，就会被TP5框架的（全局）异常处理类Handle去解决
//这里我们选择自己做异常解决，首先要去config.php改掉默认全局异常处理类
class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    //需要返回客户端当前请求的URL路径

    //这里我们重写了Handle里面反馈异常信息的函数
    //Handle的render默认返回html页面

    //这里使用的是\Exception而非think\Exception,因为还有一种异常，比如域名打错，是HttpException,
    //但是它并非think\Exception的子类，所以我们应该使用HttpException和think\Exception的共同父类
    //作为输入的参数类型，包括下面的recordErrorLog(也是这个道理)
    public function render(\Exception $e)
    {
        //异常有两种，一种是用户触发，一种是服务器异常
        if($e instanceof BaseException){
            //如果是自定义的异常（用户触发）
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }

        //如果是服务器异常，还需要做日志的记录
        else{
            /*服务器异常也要分是给谁看的，如果是给服务器端看，就应该呈现更详细的页面
            如果是给用户端开发者看的，那就直接返回一个简单的json数组
            这个判断过程直接拿了配置中的app_debug来作为开关，【注意】发布程序之后app_debug应该关闭*/
            if(config('app_debug')){
                //给服务器端开发者看的，这个页面会更详细
                //return default error page
                return parent::render($e);
            }
            else{
            //给用户端开发者看的
            $this->code = 500;
            $this->msg = '服务器内部错误，不想告诉你';
            $this->errorCode = 999;
            $this->recordErrorLog($e);
            }
        }

        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request->url()
        ];
        return json($result, $this->code);
    }

    private function recordErrorLog(\Exception $e){

        //生成自定义日志时，需要做一次初始化
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' =>['error']//如果记录的日志级别低于这个level，就不会记录进去
        ]);
        Log::record($e->getMessage(), 'error');

    }
}