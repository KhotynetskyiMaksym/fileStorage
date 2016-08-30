<?php
/**
 * Created by PhpStorm.
 * User: Maksym
 * Date: 11.07.2016
 * Time: 17:21
 */
class User
{
    public static function register($name,  $password){
        $db = Db::getConnection();

        $sql = 'INSERT INTO user (name, password)'
             . 'VALUES (:name, :password)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }
    public static function checkName($name){
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }
    public static function checkPassword($password){
        if (strlen($password) >= 6){
            return true;
        }
        return false;
    }

       public static function checkNameExists($name){
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM user WHERE name = :name';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    public static function checkUserData($name, $password)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM user'
            . ' WHERE name = :name AND password = :password';
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();
        if ($user) {
            return $user['id'];
        }
        return false;
    }
    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }
    public static function checkLogged()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header('Location: /user/login/');
    }
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    /**
     * @param integer $id
     * @return user by id
     */
    public static function getUserById($id){
        if ($id) {
            $db = Db::getConnection();

            $sql = 'SELECT * FROM  `user` WHERE id = :id';
            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);

            $result->setFetchMode(PDO::FETCH_ASSOC);

            $result->execute();

            return $result->fetch();
        }
    }
    public static function edit($userId, $name, $password)
    {
        $db = Db::getConnection();

        $sql = 'UPDATE `user` SET name = :name, password = :password
                WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $userId, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }
    public static function checkPhone($phone)
    {
        if (strlen($phone) >= 10) {
            return true;
        }
        return false;
    }
}