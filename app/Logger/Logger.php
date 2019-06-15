<?php


namespace App\Logger;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Class   Logger
|  @author Dominique DAMBA (s3nsei) , copyright 2019
|
|
|*/



use Sentinel;
use  App\Log;

const  FETCH_ACTION = 'Lecture liste';
const  FETCH_EMPTY = 'Lecture liste vide';
const  NOT_FOUND = 'Lecture ,item non trouvé';
const  STORE_ACTION = 'Ecriture';
const  STORE_FAILURE_ACTION = 'Erreur Ecriture';
const  SHOW_FAILURE_ACTION = 'Lecture erroné, item id = ';
const  SHOW_ACTION = 'lecture item';
const  EDIT_ACTION = 'Modification item = ';
const  EDIT_FAILURE_ACTION = 'Modification erroné item = ';
const  UPDATE_ACTION = 'Mis à jours item id =';
const  UPDATE_FAILURE_ACTION = 'Mis à jours erroné item = ';
const  DELETE_ACTION = 'Suppression item = ';
const  DELETE_FAILURE_ACTION = 'Suppression érroné item = ';


class Logger
{
    private static $action;
    private static $adresseIp;
    private static $location;
    private static $user;
    private static $table;
    private static $logger_token;


    /**
     * Logger constructor.
     * @param $action
     * @param $adresseIp
     * @param $location
     * @param $user
     * @param $table
     * @param $logger_token
     */
    public  function __construct($action, $adresseIp, $location, $user, $table, $logger_token)
    {
       self::$action = $action;
       self::$adresseIp = $adresseIp;
       self::$location = $location;
       self::$user = $user;
       self::$table = $table;
       self::$logger_token = $logger_token;
    }

    /**
     * @return mixed
     */
    public static function getAction()
    {
        return self::$action;
    }

    /**
     * @param mixed $action
     */
    public static function setAction($action): void
    {
    }

    /**
     * @return mixed
     */
    public static function getAdresseIp()
    {
        return self::$adresseIp;
    }

    /**
     * @param mixed $adresseIp
     */

    public static function setAdresseIp(): void
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
           self::$adresseIp = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
           self::$adresseIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
           self::$adresseIp = (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
        }
    }

    /**
     * @return mixed
     */
    public static function getLocation()
    {
        return self::$location;
    }

    /**
     * @param mixed $location
     */
    public static function setLocation(): void
    {
       self::$location = 'Gabon';
    }

    /**
     * @return mixed
     */
    public static function getUser()
    {
        return self::user;
    }

    /**
     * @param mixed $user
     */
    public static function setUser(): void
    {

        if (Sentinel::guard('web')->check()) {
           self::$user = Sentinel::getUser();
        }
       self::$user = 'Visiteur';
    }

    /**
     * @return mixed
     */
    public static function getTable()
    {
        return self::$table;
    }

    /**
     * @param mixed $table
     */
    public static function setTable(): void
    {
       self::$table = '';
    }

    /**
     * @return mixed
     */
    public static function getLoggerToken()
    {
        return self::$logger_token;
    }

    /**
     * @param mixed $logger_token
     */
    public static function setLoggerToken(): void
    {
       self::$logger_token =self::str_randomize(70);
    }

    static function tableName($model)
    {

        return (new $model())->getTable();
    }

    protected static function str_randomize($length)
    {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function fetchLog($model)
    {
        Log::create(
            [
                'action' => FETCH_ACTION,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );
    }


    public static function fetchEmptyLog($model)
    {
        Log::create(
            [
                'action' => FETCH_EMPTY,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );
    }


    public static function notFoundLog($model, $id)
    {
        Log::create(
            [
                'action' => NOT_FOUND . '' . $id,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );
    }


    public static function createLog($model)
    {
        Log::create(
            [
                'action' => STORE_ACTION,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );
    }


    public static function createFailureLog($model)
    {
        Log::create(
            [
                'action' => STORE_FAILURE_ACTION,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );
    }


    public static function showLog($model, $id)
    {
        Log::create(
            [
                'action' => SHOW_ACTION . '' . $id,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );
    }


    public static function showFailureLog($model, $id)
    {
        Log::create(
            [
                'action' => SHOW_FAILURE_ACTION . '' . $id,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );

    }


    public static function editLog($model, $id)
    {
        Log::create(
            [
                'action' => EDIT_ACTION . ' ' . $id,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );
    }


    public static function editFailureLog($model, $id)
    {
        Log::create(
            [
                'action' => EDIT_FAILURE_ACTION . '' . $id,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );
    }


    public static function updateLog($model, $id)
    {
        Log::create(
            [
                'action' => UPDATE_ACTION . '' . $id,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );
    }


    public static function updateFailureLog($model, $id)
    {
        Log::create(
            [
                'action' => UPDATE_FAILURE_ACTION . '' . $id,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );
    }


    public static function storeLog($model)
    {
        Log::create(
            [
                'action' => STORE_ACTION,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );
    }


    public static function storeFailureLog($model)
    {
        Log::create(
            [
                'action' => STORE_FAILURE_ACTION,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );
    }


    public static function deleteLog($model, $id)
    {
        Log::create(
            [
                'action' => DELETE_ACTION . '' . $id,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );
    }


    public static function deleteFailureLog($model, $id)
    {
        Log::create(
            [
                'action' => DELETE_FAILURE_ACTION . '' . $id,
                'adresseIp' =>self::getAdresseIp(),
                'location' =>self::getLocation(),
                'user' =>self::getUser(),
                'table' =>self::tableName($model),
                'logger_token' =>self::getLoggerToken(),
            ]
        );
    }


}