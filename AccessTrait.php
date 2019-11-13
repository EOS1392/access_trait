<?php

namespace BeFlo\AccessTrait;

/**
 * This trait ignore the private, protected behaviour of objects in php
 *
 * Class AccessTrait
 *
 * @package BeFlo\AccessTrait
 */
trait AccessTrait
{

    /**
     * This method will return the value fo the given variable of the given class, no matter, if the variable is
     * private or protected
     *
     * @param string      $variableName
     * @param object      $object
     * @param string|null $alternativeObjectScope
     *
     * @return mixed
     */
    protected function getVariable(string $variableName, $object, string $alternativeObjectScope = null)
    {
        $boundClosure = \Closure::bind(function () use ($variableName) {
            $result = null;
            if(property_exists($this, $variableName)) {
                $result = $this->$variableName;
            }
            return $result;
        }, $object, $alternativeObjectScope ?? $object);

        return $boundClosure($variableName);
    }

    /**
     * Set a variable in the given object within the specified scope or the scope of the object.
     *
     * @param string      $variableName
     * @param             $newValue
     * @param             $object
     * @param string|null $alternativeObjectScope
     */
    protected function setVariable(string $variableName, $newValue, $object, string $alternativeObjectScope = null): void
    {
        $closure = \Closure::bind(function() use ($variableName, $newValue) {
            $this->$variableName = $newValue;
        }, $object, $alternativeScope ?? $object);
        $closure();
    }

    /**
     * This method execute the given method name in the given object with the given parameter, no matter which visible
     * state the method has! Be careful!
     *
     * @param string      $methodName
     * @param object      $object
     * @param array       $parameters
     * @param string|null $alternativeObjectScope
     *
     * @return mixed
     */
    protected function executeMethod(string $methodName, $object, array $parameters = [], string $alternativeObjectScope = null)
    {
        $boundClosure = \Closure::bind(function () use ($methodName, $parameters) {
            $result = null;
            if (method_exists($this, $methodName)) {
                $result = $this->{$methodName}(...$parameters);
            }

            return $result;
        }, $object, $alternativeObjectScope ?? $object);
        return $boundClosure($methodName, $parameters);
    }
}