事件相比较中间件的优势是事件比中间件更加精准定位（或者说粒度更细），并且更适合一些业务场景的扩展。例如，我们通常会遇到用户注册或者登录后需要做一系列操作，通过事件系统可以做到不侵入原有代码完成登录的操作扩展，降低系统的耦合性的同时，也降低了BUG的可能性。

## 安装

```shell script
composer require yzh52521/webman-event
```

## 配置

事件配置文件 `config/plugin/yzh52521/event/app.php` 内容如下

```php
return [
    'enable'      => true,
    'event'       =>[
            // 事件监听
            'listener'    => [
                'test' => [
                    \app\listeners\TestListeners::class,
                ],
            ],
        
            // 事件订阅器
            'subscriber' => [
               \app\subscribes\TestSubscribe::class,
            ],
    ]
];
```

## 快速开始

事件类：Test

```php
namespace app\events;

class Test
{
    public  $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }
}
```

监听类

```php
namespace app\listeners;

use app\events\Test;

class TestListeners
{
    public function __construct()
    {
    }

    /**
     * 处理事件
     * @return void
     */
    public function handle(Test $event)
    {
        // 控制台打印
        var_dump('listener');
        var_dump($event->data);
    }
}
```

订阅类

```php
namespace app\subscribes;

use app\events\Test;

class TestSubscribe
{
    public function handleTest(Test $event)
    {
        var_dump('subscribe');
        var_dump($event);
    }

    public function subscribe($events)
    {
        $events->listen(
            Test::class,
            [TestSubscribe::class, 'handleTest']
        );
    }
}
```

调用触发事件

```

event(new Test('event data')); 
or
event('test',[new Test('event data')]);
```


