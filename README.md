# sword

## Summary (简述)

 Sword is a tool used on lumen. It allows the lumen to run in memory. Each request is only to be used for the Controller class, and no need to initialize the entire framework, which greatly improve the performance of the high performance.
 
 Sword 是用在lumen上的一个工具。它可以使lumen常驻运行内存中。每次请求都只实例化Controller等类，而不需要初始化整个框架，从而大幅度提运行高性能。

## Notice

 - [注意事项](doc/notice.md)

## installed

```shell
composer require onex/sword
```

- 复制Application.php到app目录下

```shell
copy lumen_project_dir/vendor/onex/sword/misc/Application.php lumen_project_dir/app/
```

- 修改 $app实例化的类

```php
// 位于lumen_project_dir/bootstrap/app.php文件

//$app = new Laravel\Lumen\Application(
//   realpath(__DIR__.'/../')
//);

//修改为以下内容
$app = new App\Application(
    realpath(__DIR__.'/../')
);

```

## run

```shell
vendor/bin/sword
```

## config

 - [配置信息](doc/config.md)
