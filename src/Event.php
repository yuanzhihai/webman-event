<?php

namespace yzh52521\event;

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Webman\Bootstrap;

/**
 * Class Event
 * @package yzh52521\event
 * @method static \Illuminate\Events\Dispatcher dispatch($event,$payload=[], $halt=false)
 * @method static \Illuminate\Events\Dispatcher listen($events, $listener = null)
 */
class Event implements Bootstrap
{
    /**
     * @var Dispatcher
     */
    protected static $instance = null;


    public static function start($worker)
    {
        if ($worker) {
            $container        = new Container;
            static::$instance = new Dispatcher($container);
            $eventsList       = config('plugin.yzh52521.event.app.event');
            if (isset($eventsList['listener']) && !empty($eventsList['listener'])) {
                foreach ($eventsList['listener'] as $event => $listener) {
                    if (is_string($listener)) {
                        $listener = implode(',', $listener);
                    }
                    foreach ($listener as $l) {
                        static::$instance->listen($event, $l);
                    }
                }
            }
            if (isset($eventsList['subscribe']) && !empty($eventsList['subscribe'])) {
                foreach ($eventsList['subscribe'] as $subscribe) {
                    static::$instance->subscribe($subscribe);
                }
            }
        }
        return static::$instance;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return static::$instance->{$name}(... $arguments);
    }
}