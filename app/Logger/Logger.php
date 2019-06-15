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
    private $action;
    private $adresseIp;
    private $location;
    private $user;
    private $table;
    private $logger_token;


    /**
     * Logger constructor.
     * @param $action
     * @param $adresseIp
     * @param $location
     * @param $user
     * @param $table
     * @param $logger_token
     */
    public function __construct($action, $adresseIp, $location, $user, $table, $logger_token)
    {
        $this->action = $action;
        $this->adresseIp = $adresseIp;
        $this->location = $location;
        $this->user = $user;
        $this->table = $table;
        $this->logger_token = $logger_token;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getAdresseIp()
    {
        return $this->adresseIp;
    }

    /**
     * @param mixed $adresseIp
     */

    public function setAdresseIp(): void
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $this->adresseIp = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->adresseIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $this->adresseIp = (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
        }
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location): void
    {
        $this->location = 'Gabon';
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser(): void
    {

        if (Sentinel::guard('web')->check()) {
            $this->user = Sentinel::getUser();
        }
        $this->user = 'Visiteur';
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table): void
    {
        $this->table = $table;
    }

    /**
     * @return mixed
     */
    public function getLoggerToken()
    {
        return $this->logger_token;
    }

    /**
     * @param mixed $logger_token
     */
    public function setLoggerToken(): void
    {
        $this->logger_token = $this->str_randomize(70);
    }

    function tableName($model)
    {

        return (new $model())->getTable();
    }

    protected function str_randomize($length)
    {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function fetchLog($model)
    {
        Log::create(
            [
                'action' => FETCH_ACTION,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );
    }


    public function fetchEmptyLog($model)
    {
        Log::create(
            [
                'action' => FETCH_EMPTY,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );
    }


    public function notFoundLog($model, $id)
    {
        Log::create(
            [
                'action' => NOT_FOUND . '' . $id,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );
    }


    public function createLog($model)
    {
        Log::create(
            [
                'action' => STORE_ACTION,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );
    }


    public function createFailureLog($model)
    {
        Log::create(
            [
                'action' => STORE_FAILURE_ACTION,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );
    }


    public function showLog($model, $id)
    {
        Log::create(
            [
                'action' => SHOW_ACTION . '' . $id,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );
    }


    public function showFailureLog($model, $id)
    {
        Log::create(
            [
                'action' => SHOW_FAILURE_ACTION . '' . $id,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );

    }


    public function editLog($model, $id)
    {
        Log::create(
            [
                'action' => EDIT_ACTION . ' ' . $id,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );
    }


    public function editFailureLog($model, $id)
    {
        Log::create(
            [
                'action' => EDIT_FAILURE_ACTION . '' . $id,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );
    }


    public function updateLog($model, $id)
    {
        Log::create(
            [
                'action' => UPDATE_ACTION . '' . $id,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );
    }


    public function updateFailureLog($model, $id)
    {
        Log::create(
            [
                'action' => UPDATE_FAILURE_ACTION . '' . $id,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );
    }


    public function storeLog($model)
    {
        Log::create(
            [
                'action' => STORE_ACTION,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );
    }


    public function storeFailureLog($model)
    {
        Log::create(
            [
                'action' => STORE_FAILURE_ACTION,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );
    }


    public function deleteLog($model, $id)
    {
        Log::create(
            [
                'action' => DELETE_ACTION . '' . $id,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );
    }


    public function deleteFailureLog($model, $id)
    {
        Log::create(
            [
                'action' => DELETE_FAILURE_ACTION . '' . $id,
                'adresseIp' => $this->getAdresseIp(),
                'location' => $this->getLocation(),
                'user' => $this->getUser(),
                'table' => $this->tableName($model),
                'logger_token' => $this->getLoggerToken(),
            ]
        );
    }


}