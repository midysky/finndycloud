<?php
namespace app\admin\controller;

use app\admin\model\SysConf as modelSysConf;
class Sysconf extends Base
{
    public function Index()
    {
        $title = '权限设置';
        return view('index',['title'=>$title]);
    }

    //增加角色
    public function AddRole()
    {
        $title = '新增角色';
        return view('addrole', ['title' => $title]);
    }
    //修改角色
    public function EditRole($rid)
    {
        dump($rid);
        $title = '编辑角色';
        $list = array(
            'description' => '角色描述22222',
            'rolename' => '角色名称1111',
        );
        return view('addrole', ['title' => $title,'list'=>$list]);
    }

    //禁用角色
    public function BanRole()
    {
        dump(input());
    }


    //系统设置
    public function SysSet()
    {
        if(request()->isPost()) {
            $data = input();
            $this->checkUserType(3);
            if(empty($data['index_url'])){
                $this->error('网站网址不能为空！');
            }
            if(empty($data['web_site_title'])){
                $this->error('网站标题不能为空！');
            }
            //校验appkey配置
            if(!empty($data['app_key'])){
                $params['op'] = 'checkappkey';
                $params['appsecret'] = $data['app_secret'];
                $res = api_request('POST' ,'appkey.php', api_build_params($params,$data['app_key']));
                if($res['error_code'] != 0){
                    $this->error('授权appKey或appSecret不正确！');
                }
            }

            $modelSysConf = new modelSysConf();
            $modelSysConf->updateSysConf($data);
            $this->success('修改成功','sysconf/sysset');
        }

        $title = '系统设置';

        $systeminfo = $this->getSysConf();
        $this->assign('systeminfo',$systeminfo);
        $this->assign([
            'title' => $title,
        ]);

        return $this->fetch('sysset');
    }



    //后台菜单设置
    public function MenuSet()
    {
        $title = '后台菜单';
        return view('menuset', ['title' => $title]);
    }
    //增加后台菜单
    public function AddMenu()
    {
        $title = '增加后台菜单';
        return view('addmenu', ['title' => $title]);
    }
    //编辑后台菜单
    public function EditMenu()
    {
        $title = '编辑后台菜单';
        return view('addmenu', ['title' => $title]);
    }

}
