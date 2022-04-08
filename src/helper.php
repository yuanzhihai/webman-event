<?php
if (!function_exists('event')) {
    /**
     * 调用事件
     * @param $event
     */
    function event($event)
    {
        \yzh52521\event\Event::dispatch($event);
    }
}