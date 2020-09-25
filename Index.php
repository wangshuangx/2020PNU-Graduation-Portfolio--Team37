<?php

namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Controller {

    public function index() {
        if (session('adminId') == null) {
            return $this->fetch('/login/login');
        }

        $getWashingHandCount = Db::name('health')->where("create_time", 'like', date("Y-m-d", time()) . "%")->where(['type' => "washingHand"])->count();
        $this->assign("washingHandCount", $getWashingHandCount);
        $getBrushingToothCount = Db::name('health')->where("create_time", 'like', date("Y-m-d", time()) . "%")->where(['type' => "brushingTooth"])->count();
        $this->assign("brushingToothCount", $getBrushingToothCount);

        return $this->fetch('/main/main');
    }

    public function hello($name = 'ThinkPHP5') {
        return 'hello,' . $name;
    }

}
