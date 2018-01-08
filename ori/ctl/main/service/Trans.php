<?php
/**
 * trans class annotations for ar doc api
 *
 * @author ycassnr <ycassnr@gmail.com>
 */
 namespace ori\ctl\main\service;

 class Trans
 {
    // convert to readable func params
    public function convert(array $classInfo)
    {
        $methods = $classInfo['methods'];
        foreach ($methods as &$method) :
            $funcparams = $method['funcparams'];
            $param = isset($method['param']) ? $method['param'] : [];

            $funcparamsArr = $funcparams ? explode(',', $funcparams) : [];

            if (empty($method['apiname'])) :
                throw new \Exception("{$classInfo['namespace']}:{$classInfo['className']}.{$method['methodName']}() comments node \"@apiname\" required");
            endif;

            if (empty($method['author'])) :
                throw new \Exception("{$classInfo['namespace']}:{$classInfo['className']}.{$method['methodName']}() comments node \"@author\" required");
            endif;

            if ($funcparams) :
                if (count($funcparamsArr) != count($param)) :
                    throw new \Exception("{$classInfo['namespace']}:{$classInfo['className']}.{$method['methodName']}() comments param num error");
                endif;
            endif;

            $funcParamsRead = [];
            for ($i = 0; $i < count($funcparamsArr); $i++) :
                $funcParamsReadUnit = [];
                $curParam = trim($funcparamsArr[$i]);
                $funcDesc = $param[$i];
                $funcDesc = preg_replace('#(\s)+#', ' ', $funcDesc);
                list($type, $pname, $pdes) = explode(' ', $funcDesc);

                if (strpos($curParam, '=') === false) :
                    $isreq = '必须';
                else :
                    list(, $defaultP) = explode('=', $curParam);
                    $isreq = '非必须,默认"'. trim(str_replace(['\'', '"'], '', $defaultP)) .'"';
                endif;

                $funcParamsReadUnit = [
                    'pname' => ltrim($pname, '$'),
                    'type' => $type,
                    'pdes' => $pdes,
                    'isreq' => $isreq,
                ];
                $funcParamsRead[] = $funcParamsReadUnit;
            endfor;
            $method['funcParamsRead'] = $funcParamsRead;
        endforeach;
        $classInfo['methods'] = $methods;
        return $classInfo;

    }

 }
