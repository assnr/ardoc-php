<?php
/**
* class to parse annotations
*
* @author ycassnr <ycassnr@gmail.com>
*/

namespace ori\ctl\main\service;

class Annotation
{
    protected
        $information,
        $fileContent
    ;

    /**
    * New Annotation object bind to a file
    * @param string $file
    */
    public function __construct($file = '')
    {
        if ($file) :
            $this->file($file);
        endif;

    }

    // file
    protected function file($file)
    {
        if (!is_file($file)) :
            throw new \Exception("parse file not found");
        else :
            $this->fileContent = file_get_contents($file);
        endif;
        return $this;

    }

    /**
    * Run file parse
    * @return this
    */
    public function parse($file = '')
    {
        if (!$file && !$this->fileContent) :
            throw new \Exception("parse file not found");
        endif;

        if ($file) :
            $this->file($file);
        endif;

        $class = array( // Conteneur d'information sur la/les classe(s)
            'namespace' => null, // Espace de nom
            'className' => '', // Collection de classe
        );
        $resParse = token_get_all($this->fileContent); // Parse PHP file

        foreach ($resParse as $v) {
            if (is_array($v)) :
                $v['token_name'] = token_name($v[0]);
                if ($v[2] === 2) :
                    $class['doc'] = $this->parseDocComment($v[1]);
                    continue;
                elseif ($v[2] === 19) :
                    $class['cdoc'] = $this->parseClassComment($v[1]);
                    continue;
                endif;
            endif;
        }

        preg_match('#namespace (\S+);\s{1}#sU', $this->fileContent, $matchNameSpace);
        $class['namespace'] = $matchNameSpace[1];

        preg_match('#class (\S+)\s{1}#sU', $this->fileContent, $matchClassName);
        $class['className'] = $matchClassName[1];

        preg_match_all('#\s{1}/\*\*.*\*/\s+public function \S+\(.*\)#sUm', $this->fileContent, $matchMethodCompleted);
        $class['methods'] = $this->parseMethodComments($matchMethodCompleted[0]);

        $this->information = $class;
        return $this;

    }

    protected function parseDocComment($annotation)
    {
        $doc = [
            'docDesc' => $this->parseComments($annotation),
        ];
        return array_merge($doc, $this->parseParams($annotation));

    }

    protected function parseClassComment($annotation)
    {
        $doc = [
            'docDesc' => $this->parseComments($annotation),
        ];
        return array_merge($doc, $this->parseParams($annotation));

    }

    protected function parseComments($annotation)
    {
        preg_match('#/\*\*(.*)+\@#smU', $annotation, $matchDes);
        $docDesc = $matchDes[0];
        $docDesc = rtrim($docDesc, '@');
        $docDesc = ltrim($docDesc, '/**');
        $docDesc = str_replace('* ', '', $docDesc);
        $docDesc = str_replace('*' . "\r\n", "\r\n", $docDesc);
        $docDesc = str_replace('*' . "\r", "\r", $docDesc);
        $docDesc = str_replace('*' . "\n", "\n", $docDesc);
        $docDesc = trim($docDesc);
        return $docDesc;

    }

    protected function parseMethodComments($annotation)
    {
        $classMethods = [];
        foreach ($annotation as $method) :
            $methodContext = [];
            if (strpos($method, 'function init()') !== false) :
                continue;
            else :
                preg_match('#function (\S+)\((.*)\)#', $method, $matchMethodName);
                $methodContext['methodName'] = $matchMethodName[1];
                $methodContext['funcparams'] = $matchMethodName[2];
                $methodComment = $this->parseComments($method);
                $methodContext['methodComment'] = $methodComment;
                $commentparams = $this->parseParams($method);
                $methodContext = array_merge($methodContext, $commentparams);
                $classMethods[] = $methodContext;
            endif;
        endforeach;
        return $classMethods;

    }

    protected function parseParams($annotation)
    {
        $doc = [];
        preg_match_all('#\* @(.*)+#', $annotation, $matchParams);
        foreach ($matchParams[0] as $params) {
            $params = str_replace('* @', '', $params);
            preg_match('#(\S+)\s{1}#', $params, $matchP);
            if (isset($doc[$matchP[1]]) && !is_array($doc[$matchP[1]])) :
                $tempMatchNodeVal = $doc[$matchP[1]];
                $doc[$matchP[1]] = [];
                $doc[$matchP[1]][] = $tempMatchNodeVal;
            endif;
            $nodeVal = trim(substr($params, strlen($matchP[1])));
            if (isset($doc[$matchP[1]])) :
                $doc[$matchP[1]][] = $nodeVal;
            else :
                $doc[$matchP[1]] = $nodeVal;
            endif;
        }
        return $doc;

    }

    /**
    * Retourne les informations
    */
    public function getInformation()
    {
        return $this->information;

    }

}
