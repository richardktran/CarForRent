<?php

namespace Khoatran\CarForRent\App;

use Closure;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * @link https://viblo.asia/p/tu-build-1-dependency-injection-container-voi-php-gDVK2mye5Lj
 */
class Container
{
    protected array $instances = [];

    /**
     * @param $abstract
     * @param $concrete
     */
    public function bind($abstract, $concrete = null)
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }
        $this->instances[$abstract] = $concrete;
    }

    /**
     * Lấy ra instance từ Container
     *
     * @param $abstract
     * @param array $parameters
     * @return mixed|object
     * @throws ReflectionException
     */
    public function make($class, array $parameters = [])
    {
        if (!isset($this->instances[$class])) {
            $this->bind($class);
        }

        $concrete = $this->instances[$class];

        if ($concrete instanceof Closure) {
            return $concrete($this, $parameters);
        }

        $reflector = new ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw new Exception("Class {$concrete} is not instantiable");
        }

        $methods = $reflector->getConstructor();

        if (empty($methods)) {
            return $reflector->newInstance();
        }

        $parameters = $methods->getParameters();
        $dependencies = $this->resolveDependencies($parameters);

        return $reflector->newInstanceArgs($dependencies);
    }


    /**
     * @throws ReflectionException
     */
    public function callMethod($callable, $parameters = [])
    {
        $callbackClass = $callable[0];
        $callbackMethod = $callable[1] ?? '__invoke';

        $methodReflection = new ReflectionMethod($callbackClass, $callbackMethod);

        $parameters = $methodReflection->getParameters();

        $dependencies = [];

        foreach ($parameters as $param) {
            $dependency = new ReflectionClass($param->getType()->getName());
            $dependencies[] = $this->make($dependency->name);
        }

        $initClass = $this->make($callbackClass, $parameters);

        return $methodReflection->invoke($initClass, ...$dependencies);
    }

    /**
     * @param $parameters
     * @return array
     * @throws Exception
     */
    protected function resolveDependencies($parameters): array
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = new ReflectionClass($parameter->getType()->getName());
            $dependencies[] = $this->make($dependency->name);
        }

        return $dependencies;
    }
}
