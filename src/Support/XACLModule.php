<?php

namespace ClaudiusNascimento\XACL\Support;

use Illuminate\Routing\Route;
use Exception;
use ReflectionClass;
/**
 *  A module consists in a controller and all your methods
 *  Each controller are one module
 */
class XACLModule
{

    private $methods;
    private $reflector;

    public $class;

    private $docs = [];

    /**
     *  $class = Path\Toclass\Controller
     */
    public function __construct($class)
    {

        $this->class = $class;

        $this->methods = [];
    }

    public function slug() {

        $r = '/\\\\/';

        $str = preg_replace($r, '-', $this->getNameSpaceName()) . '-' . $this->getClassName();

        return \Str::slug($str);
    }

    public function link() {
        return route('xacl.module', $this->slug());
    }

    public function addMethod($method)
    {
        if(!is_string($method)) throw new \Exception("A method must be of type string", 1);
        if(in_array($method, $this->methods)) return false;

        $this->methods[] = $method;

        $this->setDocs($method);
    }

    public function getDoc($key)
    {
        return empty($this->docs[$key]) ? '' : $this->docs[$key];
    }

    public function getMethods() {
        return $this->methods;
    }

    public function getAction($method)
    {
        if(!in_array($method, $this->methods)) {
            return null;
        }

        return $this->class . '@' . $method;
    }

    private function setDocs($method)
    {

        $reflector = $this->getReflector();

        if($reflector->hasMethod($method)) {

            $docComment = $reflector->getMethod($method)->getDocComment();

            $this->docs[$method] = $this->getDocComment($docComment, $method);
        }
    }

    private function getReflector()
    {

        if($this->reflector) return $this->reflector;

        $this->reflector = new ReflectionClass($this->class);

        $classDocComment = $this->getDocComment($this->reflector, 'class');

        $this->docs['class'] = $classDocComment == 'class' ? $this->getClassName() : $classDocComment;

        return $this->reflector;
    }

    private function getClassName()
    {
        if($this->reflector) {
            return $this->reflector->getShortName();
        }

        return $this->class;
    }

    public function  getNameSpaceName() {
        if($this->reflector) {
            return $this->reflector->getNameSpaceName();
        }

        return '';
    }

    private function getDocComment($docComment, $method)
    {
        if($docComment) {

            $start = config('xacl.doc_start_pattern', '@xacl');

            $pattern = '/'. $start . '(.*?)\n/mis';

            preg_match($pattern, $docComment, $match);

            if(count($match)) return trim($match[1]);
        }

        $defaults = config('xacl.docs_defaults', []);

        if(array_key_exists($method, $defaults)) {

            return __($defaults[$method]);
        }

        return $method;

    }

}
