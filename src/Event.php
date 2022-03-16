<?php

namespace yzh52521\event;

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

/**
 * Class Event
 * @package yzh52521\event
 * @method static \Illuminate\Events\Dispatcher dispatch($event)
 */
class Event
{
    /**
     * @var Dispatcher
     */
    protected static $instance = null;

    /**
     * @return Dispatcher|null
     */
    public static function instance()
    {
        if (!static::$instance) {
            $container        = new Container;
            static::$instance = new Dispatcher($container);
            $eventsList       = config('plugin.yzh52521.event.app');
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
        return self::instance()->{$name}(... $arguments);
    }
}