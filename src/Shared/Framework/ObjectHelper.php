<?php

namespace Cart\Shared\Framework;

final class ObjectHelper
{
    /**
     * @param object $instance
     * @param string $className
     * @return bool
     */
    public static function implements(object $instance, string $className): bool
    {
        $classes = class_implements($instance);
        if (false === $classes) {
            return false;
        }
        return array_key_exists($className, $classes);
    }
}
