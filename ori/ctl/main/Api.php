<?php
/**
 * Powerd by ArPHP.
 *
 * Default Controller.
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
 * An example of how to write ar restful api code
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
    }

    /**
     * 文档json
     *
     * <pre>
     *    api.fetch(url, {dname: "dname1", dname2: "dname2", dname3: "dname3"})
     *    .then(json => (dosomething(json)))
     * </pre>
     *
     * @author ycassnr <ycassnr@gmail.com>
     *
     * @apiname arphp接口重构
     *
     * @return void
    */
    public function docjson()
    {
        $info = $this->getAnnotationService()->parse(__FILE__)->getInformation();
        $comments = $this->getTransService()->convert($info);
        $this->showJson($comments);

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
