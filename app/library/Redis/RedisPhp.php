<?php
/**
 * Created by ThinhLK.
 * User: MT844
 * Date: 7/31/14
 * Time: 9:50 AM
 */
/**
 * 	class working with redis database using php redis
 *

 */
class RedisPhp{
    /**
     * config
     *
     * @var array
     */
    protected static $_config;

    /**
     * Options
     */
    const OPT_SERIALIZER = 1;
    const OPT_PREFIX = 2;

    /**
     * Serializers
     */
    const SERIALIZER_NONE = 0;
    const SERIALIZER_PHP = 1;

    /**
     * intances of redisPhp object
     *
     * @staticvar array
     */
    protected static $_instances = array();

    public static $total_time =0;
    public static $build = array();
    /**
     * get redisPhp instance
     * @param 	string	$connect the connect name
     *
     * @return 	Redis
     */
    public static function getInstance($connect = null) {
        $startTime = self::timeCall();
        if($connect == null){
            $option = Config::get('redis.default');
        }else{
            $option = Config::get('redis.'.$connect);
            if($option == null){
                $option = Config::get('redis.default');
            }
        }
        self::$_config = $option['servers'];
        if(isset(self::$_instances[$connect])){
            $redis = self::$_instances[$connect];
        }else{
            $redis = new Redis();
            $redis->connect(self::$_config['host'],self::$_config['port']);

            if(isset(self::$_config['db'])){
                $redis->select(self::$_config['db']);
            }
            self::$_instances[$connect] = $redis;
        }
        $redis->setOption(self::OPT_SERIALIZER,self::SERIALIZER_PHP);
        $endTime = self::timeCall();
        $load_time = round(($endTime - $startTime),5)."s";
        self::$total_time += $load_time;
        self::$build[]=array(
            'connect'=>$connect,
            'time'=>$load_time
        );
        return  $redis;//self::$_instances[$connect];

    }

    public static  function timeCall(){
        $time = microtime();
        $time = explode(" ",$time);
        $time = $time[1] + $time[0];
        return $time;
    }

    public static function addToQueueBySortedSet($connect,$key,$value){
        $redis = self::getInstance($connect);
        $redis->zADD($key,time(),$value);
    }

    public static function getFromQueueBySortedSet($connect,$key,$start,$end){
        $redis = self::getInstance($connect);
        $data = $redis->zRange($key,$start,$end);
        //$redis->zRemRangeByRank($key,$start,$end);
        return $data;
    }

    public static function removeFromQueueBySortedSet($connect,$key,$member){
        $redis = self::getInstance($connect);
        $redis->zRem($key,$member);
    }

    public static function addToListByRPush($connect,$key,$value){
        $redis = self::getInstance($connect);
        $redis->RPUSH($key,$value);
    }

    public static function getFromListByLRange($connect,$key,$start=0,$stop=100){
        $redis = self::getInstance($connect);
        $data = $redis->LRANGE($key,$start,$stop);
        return $data;
    }

    public static function removeFromQueueByList(){

    }
}