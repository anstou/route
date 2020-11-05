<?php


namespace Anst\Route;

/**
 * Class ReadRoutes
 * 一次只能获取一个model,
 * 因为当A-model中存在class AA时,
 * 此时如果B-model中也存在class AA时,
 * 会报class重复的错误,之所以yaf调用不出错是因为,
 * 会根据路由来只加载那个model对应的class
 * 但是可以装载anstou/command包里的php a route:list来读取全部模块路由
 * 或php a route:module {name}来读取某一个模块的路由
 * @package Route
 */
class ReadRoutes
{
    /**
     * 读取该模块的路由
     * @param string $module 要获取路由的model名
     * @throws \Exception
     */
    public static function read(string $module)
    {
        $routes = [];
        $path = \Yaf_Application::app()->getAppDirectory(). '/modules';
        $module = $argv[1] ?? '';

        $path = $path . DIRECTORY_SEPARATOR . ucfirst(strtolower($module)) . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR;
        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                $info = pathinfo($file);
                $name = $info['basename'];
                if (strtolower($info['extension']) === 'php') {
                    include_once $path . $name;
                    $c = strtolower($info['filename']);
                    $re = new \ReflectionClass(ucfirst($c) . 'Controller');
                    foreach ($re->getMethods() as $method) {
                        if (substr($method->name, -6) === 'Action')
                            $routes[] = strtolower("/{$module}/{$c}/" . substr($method->name, 0, -6));
                    }
                }
            }
        } else throw new \Exception($path . '目录不存在');
        return $routes;
    }

}