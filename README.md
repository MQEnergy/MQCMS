# MQCMS
[![License](https://img.shields.io/github/license/MQEnergy/MQCMS)](https://github.com/MQEnergy/MQCMS)
[![Stars](https://img.shields.io/github/stars/MQEnergy/MQCMS)](https://github.com/MQEnergy/MQCMS)

MQCMS是一款现代化，快速，高效，灵活，前后端分离，扩展性强的CMS系统。
MQCMS中的MQ取麻雀拼音首字母。寓意麻雀虽小五脏俱全。
### 特别感谢
本项目基于hyperf2.0框架开发的应用，感谢hyperf的作者提供了这么优秀的框架

### 开发文档
文档正在路上...
单独前端项目仓库：
https://github.com/MQEnergy/MQCMS-admin

### 项目结构
```
MQCMS                           
├─ service                       // 服务层 提供接口等服务
└─ admin                         // 后台前端
```

demo访问：
[https://sourl.cn/Y7kc6x](https://sourl.cn/Y7kc6x) （账号密码：demo/123456）

### 应用截图
#### 1、登录页面
![](screenshot/login.png)
#### 2、平台首页
![](screenshot/user.png)
#### 3、系统管理
![](screenshot/system.png)
#### 4、应用中心
![](screenshot/application.png)

## 一、运行后台前端
```
进入admin目录
yarn install / npm install #安装依赖包
yarn run serve / npm run serve  #运行项目
```

## 二、运行服务端
### 1、docke环境开发
在docker环境下开发，window10环境安装`docker desktop for window`,
window10以下环境安装`docker toolbox`。


##### 1）下载hyperf框架docker镜像
```
docker pull hyperf/hyperf
```


##### 2）下载mqcms系统到本地
```
# 例如：将项目放在本地e:/web/MQCMS
git clone https://github.com/MQEnergy/MQCMS
```

##### 2）进入docker运行命令：
```
docker run -it -v /e/web/MQCMS/service:/mqcms -p 9527:9527 --name mqserver --entrypoint /bin/sh hyperf/hyperf
```

##### 3）将Composer镜像设置为阿里云镜像，加速国内下载速度
```
php mqcms/bin/composer.phar config -g repo.packagist composer https://mirrors.aliyun.com/composer
```

##### 4）docker安装redis
```
docker pull redis
# 进入redis 配置redis可外部访问

docker run -d --privileged=true -p 6379:6379 -v /e/web/MQCMS/service/docker/conf/redis/redis.conf:/etc/redis/redis.conf --name mqredis redis redis-server /etc/redis/redis.conf --appendonly yes
docker exec -it mqredis /bin/sh

# 修改映射在本地的redis.conf
# 修改bind如下（根据自己熟悉程度配置）
# bind 0.0.0.0

# 可开启password（自行按需修改）
# requirepass foobared

# 重启redis
docker restart mqredis
```

##### 5）进入项目安装依赖启动项目
```
docker exec -it mqserver /bin/sh
cd mqcms
php bin/composer.phar install
php bin/composer.phar update # 更新composer包
cp .env.example .env
php bin/hyperf.php migrate
php bin/hyperf.php start 或者 php watch (热更新)
```

##### 6）浏览器访问项目
```
http://127.0.0.1:9527
```
![](./screenshot/home.png)

### 2、扩展功能
#### 1）项目初始化
```
php bin/hyperf.php mq:init

```
#### 1）生成model
```
php bin/hyperf.php gen:model --path=app/Model/Common --with-comments category
```

#### 2）command命令扩展
2-1、创建service
```
# 查看mq:service命令帮助
php bin/hyperf.php mq:service --help

# 创建App\Service命名空间的service
php bin/hyperf.php mq:service FooService Foo
# FooAdminService：service名称 FooAdmin：model名称
 
# 创建其他命名空间的service
php bin/hyperf.php mq:service -N App\\Service\\Admin FooAdminService FooAdmin
# FooAdminService：service名称 FooAdmin：model名称
 
```

2-2、创建logic
```
# 查看mq:logic命令帮助
php bin/hyperf.php mq:logic --help

# 创建App\Logic命名空间的logic
php bin/hyperf.php mq:logic FooLogic FooService common
# FooLogic：logic名称 FooAdmin：model名称 common: service路径
 
# 创建其他命名空间的logic
php bin/hyperf.php mq:logic -N App\\Logic\\Admin FooLogic FooService common
# FooLogic：logic名称 FooService：service名称 common: service命名空间
 
```

2-3、创建controller
```
# 查看mq:controller命令帮助
php bin/hyperf.php mq:controller --help

# 创建App\Controller命名空间的controller
php bin/hyperf.php mq:controller FooController FooLogic admin
# FooController：controller名称 FooLogic：logic名称 admin：模块名称（后台，接口 可扩展，eg.可写成：Admin ADMIN admin ...）

# 创建其他命名空间的controller
php bin/hyperf.php mq:controller -N App\\Controller\\Api\\V1 FooController FooLogic admin
# FooController：controller名称 FooLogic：logic名称 admin：logic命名空间（后台，接口 可扩展，eg.可写成：Api API api ...）

```

2-4、安装plugin（待优化）

本项目支持安装开发的插件分为前后端，插件后台路由建议使用注解路由方式实现，目录结构查看upload/plugins/demo.zip文件
```
demo                             // 插件名称（一般为用户名）
├─ service                       // command命令
├─ components                    // 前端组件目录
├─ controller                    // 控制器目录
├─ migrations                    // 数据库迁移目录
├─ api                           // 前端api访问方法目录
│  ├─ index.js                   // 前端api方法
├─ menu                          // 前端菜单目录
│  ├─ index.js                   // 前端菜单列表
├─ router                        // 前后端路由目录
│  ├─ index.js                   // 前端路由
│  ├─ api.php                    // 前台接口路由
│  └─ admin.php                  // 后台接口路由
```
```
# 查看mq:plugin命令帮助
php bin/hyperf.php mq:plugin --help

# 创建默认命名空间的plugin（默认命名空间可在devtool.php查看）
php bin/hyperf.php mq:plugin up demo
# up：代表安装操作 demo：代表插件打包名称

# 创建其他命名空间的plugin
php bin/hyperf.php mq:plugin -CN App\\Controller\\Admin\\Plugins -SN App\\Service\\Plugins up demo [-H(--hot)]
# CN：controller namespace  SN：service namespace  -H：为热更新参数

运行如下：
start install plugin demo ...
 ---------------- ----------------------------------------------------
  插件临时路径     /mqcms/upload/plugins/demo
 ---------------- ----------------------------------------------------
  控制器路径       /mqcms/app/Controller/Admin/Plugins/Demo
 ---------------- ----------------------------------------------------
  服务层路径       /mqcms/app/Service/Plugins/Demo
 ---------------- ----------------------------------------------------
  数据库迁移路径   /mqcms/migrations
 ---------------- ----------------------------------------------------
plugin demo installed successfully!


# 访问地址
http://127.0.0.1:9527/admin/plugins/demo/index/index
出现结果：
{
    "method": "GET",
    "message": "Hello MQCMS-plugin-demo."
}
```

