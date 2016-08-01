# NOTICE 注意事项

## 作用域

  - 由于整个application以进程模式启动，所以一定要注意变量的作用域问题。

  - 慎用单例模式，Request、Response、Model、Controller等，切记，一定不要用单例。

  - 单例模式下的对象，一定不要保存个性化数据，否则会被别的进程调用到。

  - 静态变量的作用域将会是整个Application（php-fpm模式下运行，只会在当前进程，即当次请求中生效）。

## 一定要替换Application

  - 因为原始Application并不是基于常驻进程模式。

  - Lumen默认的Application在执行结束后，`callTerminableMiddleware()`方法是protected修饰的，所以重写成public的。

## 资源文件访问

  - 不支持资源文件请求，如果需要请配置nginx。
