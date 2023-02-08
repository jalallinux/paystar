<?php


if (!function_exists('classToSlug')) {
    function classToSlug(string $class, string $separator = '_'): string
    {
        return strtolower(implode($separator, preg_split('/(?=[A-Z])/', class_basename($class), -1, PREG_SPLIT_NO_EMPTY)));
    }
}
