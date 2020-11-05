<?php

class test
{

    private $a = 1;

    /**
     * function_a
     * @return int
     */
    public static function a(): int
    {
        self::b();
        return 1;
    }

    /**
     * function_b
     * @return string
     */
    static function b(): string
    {
        return '';
    }
}