<?php
if (!function_exists('event')) {
    /**
     * 调用事件
     * @param $event
     * @param array $payload
     * @param bool $halt
     * @return void
     */
    function event($event, array $payload = [], bool $halt = false)
    {
        \yuan\event\Event::dispatch($event, $payload, $halt);
    }
}