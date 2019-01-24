<?php

namespace Ctx\Service\Ctx\Child;

use Ctx\Basic\Ctx;
use Predis\Client as Redis;
use Jetea\Database\MySqlConnection;
use Jetea\Database\PostgresConnection;

/**
 * 框架存储辅助类
 *
 */
class Storage extends Ctx
{
    /**
     * 构造函数
     */
    public function __construct()
    {
    }

    /**
     * db实例，所有子类都会共享该属性
     */
    private static $dbObj = [];

    /**
     * 加载数据库mysql获取数据库操作对象
     * $this->loadDB();
     * $this->loadDB('mission.slave');
     *
     * @param string $database
     * @return \Jetea\Database\Connection
     */
    public function db($database = 'default.master')
    {
        if (! isset(self::$dbObj[$database])) {
            $config = $this->ctx->Ctx->getConf('database.' . $database);

            if ($config['driver'] == 'mysql') {
                $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $config['host'], $config['port'], $config['database'], $config['charset']);
                $connection = new MySqlConnection($dsn, $config['username'], $config['password']);

                //Set the connection character set and collation.
                // $collation = isset($config['collation']) ? " collate '{$config['collation']}'" : '';
                // $connection->getPdo()->prepare("set names '{$config['charset']}'" . $collation)->execute();

                //Set the timezone on the connection.
                // $connection->getPdo()->prepare('set time_zone="'.$config['timezone'].'"')->execute();

                //Set the modes for the connection 严格模式
//                if (version_compare($connection->getAttribute(PDO::ATTR_SERVER_VERSION), '8.0.11') >= 0) {
//                    $strictMode = "set session sql_mode='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'";
//                }
//                $strictMode = "set session sql_mode='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'";
//                $connection->getPdo()->prepare($strictMode)->execute();
            } else {    //默认Pgsql
                $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', $config['host'], $config['port'], $config['database']);
                $connection = new PostgresConnection($dsn, $config['username'], $config['password']);

                //Set the connection character set and collation.
                // $connection->getPdo()->prepare("set names '{$config['charset']}'")->execute();

                //Set the timezone on the connection.
                // $connection->getPdo()->prepare("set time zone '{$config['timezone']}'")->execute();

                //Set the schema on the connection.
                // $connection->getPdo()->prepare("set search_path to {$config['schema']}")->execute();
            }

            self::$dbObj[$database] = $connection;
        }

        return self::$dbObj[$database];
    }

    /**
     * redis实例
     */
    private static $redisObj = [];

    /**
     * 加载Redis对象
     * $this->ctx->loadRedis();
     * $this->ctx->loadRedis('test');
     *
     * @param string $redis
     * @return Redis
     */
    public function redis($redis = 'default')
    {
        if (! isset(self::$redisObj[$redis])) {
            $config = $this->ctx->Ctx->getConf('redis.' . $redis);
            self::$redisObj[$redis] = new Redis([
                'scheme'    => 'tcp',
                'host'      => $config['host'],
                'port'      => $config['port'],
                'timeout'   => $config['timeout'],
            ]);
            // self::$redisObj[$redis] = new Redis($config['host'], $config['port'], $config['timeout']);
        }

        return self::$redisObj[$redis];
    }

    public function __destruct()
    {
        foreach (self::$redisObj as $redis) {
            /** @var $redis Redis */
            $redis->disconnect();
        }
    }
}
