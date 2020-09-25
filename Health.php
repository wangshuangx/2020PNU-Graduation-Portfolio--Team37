<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\index\controller;

/**
 * Description of Health
 *
 * @author QingHao
 */
use think\Controller;
use think\Db;

class Health extends Controller {

    public function getResult() {
        $data = input('data');
        $getLastResult = Db::name('health')->order("id desc")->find();
        if ($getLastResult['type'] != $data) {
            Db::name('health')->insert(['type' => $data, 'create_time' => date('Y-m-d H:i:s', time())]);
        }
    }

    public function getInfo() {
        $data = input('data');
        $data = [];
        $data['now'] = Db::name('health')->where('create_time', '> time', date("Y-m-d H:i:s", strtotime("-2 second")))->order("create_time desc")->find();
        if ($data['now'] != null) {
            $data['last'] = Db::name('health')->where('type', "<>", $data['now']['type'])->order("create_time desc")->find();
        } else {
            $data['last'] = Db::name('health')->order("create_time desc")->find();
        }

        $data['count'] = Db::name('health')->where("create_time", 'like', date("Y-m-d", time()) . "%")->count();
        return json(["code" => 200, 'data' => $data]);
    }

    public function getChartsData() {
        $dateRange = input('datetime');
        $map = [];
        if ($dateRange != null || $dateRange != '') {
            $dateRange = explode(' - ', $dateRange);
            if (($this->checkDateTime($dateRange[0]) === TRUE) && ($this->checkDateTime($dateRange[1]) === TRUE)) {
                $map[] = ['create_time', 'between time', [$dateRange[0], $dateRange[1]]];
            } else {
                return json(['code' => -1, 'msg' => '时间格式错误']);
            }

            //判断时间跨度
            if (abs(ceil((strtotime($dateRange[1]) - strtotime($dateRange[0])) / 3600)) > 168) {
                
            }
        }

        $text = ['washingHand', 'brushingTooth', 'drinking', 'washingFace', 'washingHair', 'running', 'dryingHair', 'sitting', 'standing', 'walking'];
        $data = [];
        foreach ($text as $arr => $row) {
            $data[$arr]['type'] = $row;
            $data[$arr]['count'] = Db::name('health')->where($map)->where(['type' => $row])->count();
        }
        return json(["code" => 200, 'data' => $data]);
    }

    /**
     * 判断是否为时间 
     * 
     * @access local 
     * @param  $date 时间 
     */
    function checkDateTime($date) {
        if (date('Y-m-d H:i', strtotime($date)) == $date) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
