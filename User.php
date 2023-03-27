<?php

require 'MySQL.php';
require 'dataconfig.php';

class USER extends MYSQL
{
    //SET TABLE NAME
    private $_table = 'users';

    public function __construct()
    {
        // configuration data
        global $config;

        //call parent constructor
        parent :: __construct($config);
    }

    /*
    *list all users
    *return array returns every user row as array of associative
     */
    public function getUsers()
    {
        $this->select($this->_table);

        return $this->fetchAll();
    }

    /*  *show one user
        *user id
        *return array returns every user row as array of associative
    */
    public function getUser($user_id)
    {
        $this->select($this->_table, 'id='.$user_id);

        return $this->fetch();
    }

    /* * add new user
       * the array $user_date is associative array have column and value
       * return id  user
    */
    public function addUser($user_date)
    {
        return $this->insert($this->_table, $user_date);
    }

    /* *update existing user
       *the array $user_date is associative array have column and value
       *return id  user
       *return int number for affected rows
    */
    public function updateUser($user_date, $user_id)
    {
        return $this->update($this->_table, $user_date, 'id='.$user_id);
    }

    /**delete existing user
      *return id  user
      *return int number for affected rows
    */
    public function deleteUser($user_id)
    {
        return $this->delete($this->_table, 'id= '.$user_id);
    }

    /**search user
     * string $keyword
     * return array returns every user row as array of associative
     */
    public function searchUser($keyword)
    {
        $this->select($this->_table, " name LIKE '%$keyword%' OR email LIKE '%$keyword%' ");

        return $this->fetchAll();
    }
}
