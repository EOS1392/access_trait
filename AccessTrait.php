<?php

namespace EOS1392\AccessTrait;

/**
 * Class AccessTrait
 *
 * @package EOS1392\AccessTrait
 */
trait AccessTrait
{

    /**
     * This method execute the given method name in the given object with the given parameter, no matter which visible
     * state the method has! Be careful!
     *
     * @param string $methodName
     * @param object $object
     * @param array  $parameters
     *
     * @return mixed
     */
    protected function getMethodAccess($methodName, $object, $parameters = array())
    {
        $closure = function ($methodName, $parameters) {
            $result = null;
            if (method_exists($this, $methodName)) {
                $result = call_user_func_array(array($this, $methodName), $parameters);
            }
            return $result;
        };
        $boundClosure = \Closure::bind($closure, $object, $object);
        return $boundClosure($methodName, $parameters);
    }

    /**
     * This method will return the value fo the given variable of the given class, no matter, if the variable is
     * private or protected
     *
     * @param string $variableName
     * @param object $object
     *
     * @return mixed
     */
    protected function getVariableAccess($variableName, $object)
    {
        $closure = function ($variableName) {
            return $this->$variableName;
        };
        $boundClosure = \Closure::bind($closure, $object, $object);
        return $boundClosure($variableName);
    }
}