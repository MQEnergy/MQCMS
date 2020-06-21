<?php
declare(strict_types=1);

namespace App\Utils;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Snowflake\IdGeneratorInterface;
use Hyperf\Utils\ApplicationContext;

class Common
{
    /**
     * 构建大小图显示列表 9的倍数 大图6->9 大图13->18 大图24->27 大图31->36 大图42->45 ...
     * @param RequestInterface $request
     * @param array $data
     * @return array
     */
    public static function calculateList($page, $limit, array $data)
    {
        $page < 1 && $page = 1;
        $limit > 100 && $limit = 100;

        $multiple = (($limit / 3) - 1) / 2; // limit的数量 9 15 21 27...
        $suffix = $page % 2 === 0 ? 3 : 5;
        $currentKey = floor($limit - $suffix * $multiple);
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $data[$key]['img_status'] = 0; // 小图
                if (count($data) >= $limit) {
                    $data[$currentKey - 1]['img_status'] = 1; // 大图
                }
            }
        }
        return array_values($data);
    }


    /**
     * 生成密码
     * @param $password
     * @param string $salt
     * @return string
     */
    public static function generatePasswordHash($password, $salt = '')
    {
        return sha1(substr(md5($password), 0, 16) . $salt);
    }

    /**
     * 初始化一个加盐字符串
     * @param int $cost
     * @return string
     * @throws \Exception
     */
    public static function generateSalt($cost = 13)
    {
        $cost = (int)$cost;
        if ($cost < 4 || $cost > 31) {
            return '';
        }
        // Get a 20-byte random string
        $rand = random_bytes(20);

        // Form the prefix that specifies Blowfish (bcrypt) algorithm and cost parameter.
        $salt = sprintf('$2y$%02d$', $cost);

        // Append the random salt data in the required base64 format.
        $salt .= str_replace('+', '.', substr(base64_encode($rand), 0, 22));

        return $salt;
    }

    /**
     * 分布式全局唯一ID生成算法
     * @return int
     */
    public static function generateSnowId()
    {
        $container = ApplicationContext::getContainer();
        $generator = $container->get(IdGeneratorInterface::class);
        return $generator->generate();
    }

    /**
     * 根据ID反推对应的Meta
     * @param $id
     * @return \Hyperf\Snowflake\Meta
     */
    public static function degenerateSnowId($id)
    {
        $container = ApplicationContext::getContainer();
        $generator = $container->get(IdGeneratorInterface::class);

        return $generator->degenerate($id);
    }

    /**
     * 获取当前访问的控制器名称
     * @param $class
     * @return string|string[]
     */
    public static function getCurrentControllerName($class)
    {
        $controllers = get_class($class);
        $controller = str_replace('Controller','', substr(strrchr($controllers, '\\'), 1));
        return self::uncamelize($controller);
    }

    /**
     * 获取当前访问的控制器的方法名称（通过注解路由方式不可用）
     * @param RequestInterface $request
     * @param $class
     * @return array|mixed|string
     */
    public static function getCurrentActionName(RequestInterface $request, $class)
    {
        $pathList = explode('/', $request->decodedPath());
        $methods = get_class_methods(get_class($class));
        $method = $methods && !empty($pathList) ? array_values(array_intersect($pathList, $methods)) : [];
        $method = !empty($method) && count($method) === 1 ? $method[0] : '';
        return self::uncamelize($method);
    }

    /**
     * 获取当前访问目录
     * @return string
     */
    public static function getCurrentPath(RequestInterface $request)
    {
        $pathList = explode('/', $request->decodedPath());
        $path = !empty($pathList) ? $pathList[0] : '';
        return $path;
    }

    /**
     * 获取模版的渲染路径（index除外）
     * @param RequestInterface $request
     * @param $class
     * @return string
     */
    public static function getTemplatePath($class, $method)
    {
        return  env('APP_WEB_TEMP', 'default') . '/' . self::getCurrentControllerName($class) . '/' . self::uncamelize($method, '_');
    }

    /**
     * 获取n位数组深度
     * @param $arr
     * @param int $depth
     * @return int
     */
    public static function getArrCountRecursive(array $array)
    {
        $maxDep = 1;
        $dep = 1;
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $dep = self::getArrCountRecursive($v) + 1;
            }
            if ($dep > $maxDep) {
                $maxDep = $dep;
            }
        }
        return $maxDep;
    }

    /**
     * 获取目录下的子目录
     * @param $path
     * @return mixed
     */
    public static function getChildPath($path)
    {
        $list = [];
        if (is_dir($path)) {
            $dp = dir($path);
            while ($file = $dp->read()) {
                if ($file != "." && $file != "..") {
                    if (is_dir($path . "/" . $file)) {
                        array_push($list, $file);
                    }
                    self::getChildPath($path . "/" . $file);
                }
            }
            $dp->close();
        }
        return $list;
    }

    /**
     * 清空文件夹函数和清空文件夹后删除空文件夹函数的处理
     * @param $path
     * @return bool
     */
    public static function delDirFile($path)
    {
        if (is_dir($path)) {
            $dh = opendir($path);
            while ($file = readdir($dh)) {
                if ($file != "." && $file != "..") {
                    $fullpath = $path . "/" . $file;
                    if (!is_dir($fullpath)) {
                        unlink($fullpath);
                    } else {
                        self::delDirFile($fullpath);
                    }
                }
            }
            closedir($dh);
            if (rmdir($path)) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * 创建多级目录
     * @param $path
     * @return bool
     */
    public static function mkDir($path)
    {
        return is_dir($path) or (self::mkDir(dirname($path)) and mkdir($path, 0777));
    }

    /**
     * 初始化一个不重复的uuid
     * @return string
     */
    public static function generateUniqid()
    {
        return md5(uniqid((string) rand_float(), true));
    }

    /**
     * 中划线转驼峰
     * @param $uncamelized_words
     * @param string $separator
     * @return string
     */
    public static function camelize($uncamelized_words, $separator='-')
    {
        $uncamelizedWords = $separator . str_replace($separator, " ", strtolower($uncamelized_words));
        return ltrim(str_replace(" ", "", ucwords($uncamelizedWords)), $separator);
    }

    /**
     * 驼峰命名转中划线命名
     * @param $camel_caps
     * @param string $separator
     * @return string
     */
    public static function uncamelize($camel_caps, $separator='-')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camel_caps));
    }

    /**
     * 无限极分类
     * @param $data
     * @return array
     */
    public static function generateTree($data) {
        $items = [];
        foreach ($data as $v) {
            $items[$v['id']] = $v;
        }
        $tree = [];
        foreach ($items as $k => $item) {
            if(isset($items[$item['parent_id']])) {
                if (isset($item['is_choose']) && $item['is_choose']) {
                    $items[$item['parent_id']]['check_list'][] = intval($k);
                }
                $items[$item['parent_id']]['children'][] = &$items[$k];
            }else{
                $item['check_list'][] = intval($k);
                $item['children'] = [];
                $tree[] = &$items[$k];
            }
        }
        return $tree;
    }

    /**
     * 无限极分类封装
     * @param $arr
     * @param string $key_name
     * @param int $pid
     * @param int $lev
     * @param array $tree
     * @return array
     */
    public static function sonTree($arr, $key_name='name', $pid = 0, $lev = 0, &$tree = [])
    {
        foreach ($arr as $key => $value) {
            if ($value['parent_id'] == $pid) {
                $value['lev'] = $lev;
                $value[$key_name] = str_repeat("|---", $lev) . $value[$key_name];
                $tree[] = $value;
                self::sonTree($arr, $key_name, $value['id'], ++$lev, $tree);
                --$lev;
            }
        }
        return $tree;
    }
}