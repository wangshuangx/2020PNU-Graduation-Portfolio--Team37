<?php

namespace app\index\validate;

use think\Validate;

class Admin extends Validate {

    protected $rule = [
        'account' => 'require',
        'password' => 'require',
    ];
    
    protected $message = [
        'account.require' => '管理员账户不能为空',
        'password.require' => '密码不能为空',

    ];
    
    protected $scene = [
        'signIn' => ['account', 'password'],
    ];

}
