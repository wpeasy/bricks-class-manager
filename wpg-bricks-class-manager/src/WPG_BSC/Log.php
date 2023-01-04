<?php

namespace WPG_BSC;

class Log
{
    public static function log($data, $stack_trace = false)
    {
        if(WPG_BSC_DEBUG && class_exists('\BugFu')){
            \BugFu::log($data, $stack_trace);
        }
    }
}