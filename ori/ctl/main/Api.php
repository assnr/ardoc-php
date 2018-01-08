<?php
/**
 * 生成文档接口说明.
 *
 * 自动生成接口文档
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Arphp_Api
 * @author   ycassnr <ycassnr@gmail.com>
 * @license  http://www.arphp.org/licence ar licence 5.1
 * @version  GIT: 0103
 * @link     http://www.arphp.org
 */
namespace ori\ctl\main;

use \ar\core\ApiController as Controller;

/**
 * 生成接口API
 *
 * @category  PHP
 * @package   Arphp_Api
 * @author    ycassnr <ycassnr@gmail.com>
 * @author    Another Author <another@example.com>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.arphp.org/licence ar licence 5.1
 * @version   Release: @package_version@
 * @link      http://www.arphp.org
 */
class Api extends Controller
{
    /**
     * 初始化方法
     *
     * @return void
     */
    public function init()
    {
        // $this->request 请求参数数组， 控制器任意地方可调用
        // var_dump($this->request);
        header('Access-Control-Allow-Origin:*');
    }

    /**
     * 文档json
     *
     * <pre>
     *    api.fetch(url, {dname: "dname1", dname2: "dname2", dname3: "dname3"})
     *    .then(json => (dosomething(json)))
     * </pre>
     *
     * @param string $apiname 接口名称
     *
     * @author ycassnr <ycassnr@gmail.com>
     *
     * @apiname arphp接口重构
     *
     * @return void
    */
    public function docjson(string $apiname = '')
    {
        $parseFile = '';
        if ($apiname) :
            list($docname, $api) = explode('::', $apiname);
            $parseFile = \ar\core\cfg('docMenu.' . $docname . '.prefix') . $api . '.php';
        else :
            $parseFile = __FILE__;
        endif;

        $info = $this->getAnnotationService()->parse($parseFile)->getInformation();
        $comments = $this->getTransService()->convert($info);
        $this->showJson($comments);

    }

    /**
     * 生成文档目录
     *
     * <pre>
     * 返回 : {"ret_code":"1000","ret_msg":"","
     * data":[{"apiname":"Api","menuname":"\u751f\u6210\u63a5\u53e3API"}]}
     * </pre>
     *
     * @param string $docmenu 目录索引
     *
     * @author ycassnr <ycassnr@gmail.com>
     *
     * @apiname 生成文档目录
     *
     * @return void
     */
    public function docjsonMenu(string $docmenu)
    {
        $menuConfig = \ar\core\cfg('docMenu.' . $docmenu);
        if ($menuConfig) :
            $prefix = $menuConfig['prefix'];
            if (is_dir($prefix)) :
                $listApiFiles = scandir($prefix);
                $menu = [];
                foreach ($listApiFiles as $api) :
                    if (($index = strpos($api, '.php')) !== false) :
                        $classFile = $prefix . $api;
                        $docComment = $this->getAnnotationService()
                            ->parse($classFile)
                            ->getInformation();
                        $apiname = substr($api, 0, $index);
                        $menu[] = [
                            'apiname' => $apiname,
                            'menuname' => $docComment['cdoc']['docDesc'],
                            'index' => $docmenu . '::' . $apiname,
                        ];
                    endif;
                endforeach;
                $this->showJson($menu);
            else :
                $this->showJsonError('docmenu prefix not found');
            endif;
        else :
            $this->showJsonError('docmenu not found');
        endif;

    }

    /**
     * Ardoc工具概述
     *
     * @author ycassnr <ycassnr@gmail.com>
     *
     * @apiname 工具说明
     *
     * @return void
     */
    public function description()
    {
         $doc = [
              'name' => 'arphp 自动文档生成工具"ardoc"说明(注：接口项目名称)',
              'communication' => '
* *接口地址*: https://github.com/arphp (示例)
* 数据格式: *json*
* 请求方式: *GET|POST|REQUEST|PUT*
              ',
              'params' => '
1. *全局返回示例* :
`{ret_code: 1000, ret_msg: "请求成功"}`
  * **ret_code** 返回码，1000为正常返回，其他为错误返回
  * **ret_msg**  返回信息， ret_code != 1000 的时候,额外会多一个err_msg(错误信息字段)
2. *全局数据返回示例* : `{ret_code: 1000, ret_msg: "请求成功", data: [[something1], [something2]]}`
  * *data* 返回的数据，前端js处理
              ',
              'other' => '
1. 编码需要严格遵守 phpcs PSR2规范，否则可能不能正常生成文档
2. 请求需要带上appkey(非必须, 此处权限验证需要根据业务情况实现)
- 此文档为 ardoc 自动生成
- arphp开发交流群259956472
              ',
         ];
         $this->showJson($doc);

    }

    /**
     * 生成文档
     *
     * <pre>
     *    api.fetch(url, {dname: "dname1", dname2: "dname2", dname3: "dname3"})
     *    .then(json => (dosomething(json)))
     * </pre>
     *
     * @param string $dname  文档名称
     * @param int    $dname2 文档名称2
     * @param string $dname3 文档名称3
     *
     * @author ycassnr <ycassnr@gmail.com>
     * @author another user <ycassnr@gmail.com>
     *
     * @apiname 项目开发首页1
     *
     * @return void
    */
    public function docprametest($dname, int $dname2, $dname3 = 'd3')
    {
        $info = $this->getAnnotationService()->parse(__FILE__)->getInformation();
        $comments = $this->getTransService()->convert($info);
        $this->showJson($comments);

    }

    /**
     * Just for test
     *
     * @author tester <tester@coopcoder.com>
     *
     * @apiname 测试方法
     *
     * @return void
     */
    public function tapi()
    {
        echo 'test api';

    }
}
