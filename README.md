# sword

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
