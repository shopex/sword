# NoteBook 笔记

## 序

  - 这里会记录一些心得和一些想法

## 核心思想

  - 将lumen的app、router等比较重的但是可以不用每次请求都加载一次的模块在init的时候一次性加载完。然后每次请求的时候只生成request、response、controller等。

  - 这样，每次请求就会只使用很少的资源去处理请求数据即可。不需要像以前一样，把所有的东西都调用一次（比如每次都会读取配置文件信息）。

  - 在请求的时候，onRequest event被触发时，系统会对swoole的request翻译，转化成$illuminate_request，传给lumen_app的dispatch方法，返回$illuminate_response再翻译成swoole_response。

## 作用域

  - php的作用域仅仅在每次request中生效。所以在fpm的模式下，没有作用于Application级别的变量。

  - 在写代码的时候，一定要注意request作用域(bind()方法)和Application作用域(singleton()方法)。

## 守护进程的问题

### 理想状态下 (以laravool为例)

  - 进程需要启动两次(类似laravool)，第一次加载$app、kernel。第二次才是启动服务。

  - 第一次作用相当于启动脚本。第二次调用才是启用各种server。

### 实际状况（sword）

  - 直接运行即启动。

  - 启动时需要加载$app以读取env配置。这些信息都会被加载到server中，然后将$app传给server，成为server的一个属性。
  
  - misc目录下放了一个shell脚本，修改里面文件位置后，可以仍在/etc/init.d目录下，做启动脚本。主要是觉得这样做比较干净，不需要用php来控制自启动什么的。这样就把启动、停止由系统去控制了。

## 资源文件加载

  - 目前为止，不支持资源文件请求，理由是sword是为了微服务的api服务设计的，所以不支持资源文件的访问。

  - 如果需要访问资源文件（比如Oauth服务，会有登录页面），那么请在Nginx中配置。由nginx完成这个功能。


