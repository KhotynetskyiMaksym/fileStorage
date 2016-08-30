<?php

/**
 * Created by PhpStorm.
 * User: Maksym
 * Date: 24.06.2016
 * Time: 1:57
 */
class Db
{
    public static function getConnection()
    {
        $paramsPath = ROOT. '/config/db_params.php';
        $params = include ($paramsPath);

        $dsn = "mysql:host={$params['host']}; dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);
        $db->exec("set names utf8");

        return $db;
    }
}