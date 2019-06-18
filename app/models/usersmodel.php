<?php
namespace MVC\Models;

class UsersModel extends AbstractModel
{
    public $User_id;
    public $User_name;
    public $User_email;
    public $User_password;
    public $User_img;


    protected static $tableName = 'users';

    protected static $primaryKey = 'User_id';

    protected static $tableSchema = array(
        'User_id'       => self::DATA_TYPE_STR,
        'User_name'     => self::DATA_TYPE_STR,
        'User_email'    => self::DATA_TYPE_STR,
        'User_password' => self::DATA_TYPE_STR,
        'User_img'      => self::DATA_TYPE_STR
    );

    public function __construct($UserId, $UserName, $UserEmail, $UserPassword, $UserImg)
    {
        global $connection;
        $this->User_id = $UserId;
        $this->User_name = $UserName;
        $this->User_email = $UserEmail;
        $this->User_password = $UserPassword;
        $this->User_img = $UserImg;
    }
    public function __get($prop)
    {
        return $this->$prop;
    }
    public function getTableName()
    {
        return self::$tableName;
    }
}
