<?php

namespace app\index\controller;

use think\Controller;
use think\Db;

/**
 * 登录类
 *
 * @author QingHao
 */
class Login extends Controller {

    /**
     * 登录页面 
     * 
     * @access local 
     */
    public function loginView() {
        session('adminId', null);
        return $this->fetch('/login/login');
    }

    /**
     * 登录
     */
    public function signIn() {

        $param = input();
        $validate = new \app\index\validate\Admin();
        if (!$validate->scene('signIn')->check($param)) {
            return json(['code' => -1, 'msg' => $validate->getError()]);
        }

        $hasUser = Db::name('admin')->where('account', $param["account"])->find();
        if (empty($hasUser)) {

            return json(['code' => -1, 'url' => '', 'msg' => 'account not exist']);
        }

        if ($hasUser["password"] != password_verify($param["password"], $hasUser['password'])) {

            return json(['code' => -1, 'url' => '', 'msg' => 'wrong password']);
        }

        if ($hasUser["status"] == "-1") {

            return json(['code' => -1, 'url' => '', 'msg' => 'account baned']);
        }

        session("adminId", $hasUser["id"]);
        session("adminRealname", $hasUser["realname"]);


        return json(['code' => 200, 'msg' => 'SignIn Success']);
    }

}
