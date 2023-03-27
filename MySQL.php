<?php

class MYSQL
{
    protected $_config = []; //connect database
   protected $_link;            //store connection
   protected $_result;         //store result SELECT statement

    /*** constructor ****/
    public function __construct(array $config)
    {
        if (count($config) !== 4) { //check for array must have 4 elements
            throw new InvalidArgumentException('invalid number of connection parameters');
        }
        $this->_config = $config;
    }

    /** CONNECT TO MYSQL **/
    public function connect()
    {
        /* connect only once **/
        if ($this->_link === null) {
            list($host, $user, $pass, $database) = $this->_config;
            if (!$this->_link = @mysqli_connect($host, $user, $pass, $database)) {
                throw new RuntimeException('Error connection to the sever :'.
            mysqli_connect_error());
            }
            unset($host,$user,$pass,$database);
        }

        return $this->_link;
    }

    /* Execute specified query */
    public function query($query)
    {
        if (!is_string($query) || empty($query)) {
            throw new InvalidArgumentException('the specified query is nt valid.');
        }
        /* lazy connect to my sql */
        $this->connect();
        if (!$this->_result = mysqli_query($this->_link, $query)) {
            throw new RuntimeException('error excepting specified query'.$query
        .mysqli_error($this->_link));
        }

        return $this->_result;
    }

    /*perform SELECT statement*/
    public function select($table, $where = '', $fields = '*', $order = '', $limit = null, $offset = null)
    {
        $query = ' SELECT '.$fields.' FROM '.$table
            .(($where) ? ' WHERE '.$where : '')
            .(($limit) ? ' LIMIT '.$limit : '')
            .(($offset && $limit) ? 'OFFSET'.$offset : '')
            .(($order) ? ' ORDER BY '.$order : '');
        $this->query($query);

        return $this->countRows();
    }

    /*perform INSERT statement*/

    public function insert($table, array $data)
    {
        $fields = implode(',', array_keys($data));
        $values = implode(',', array_map([$this, 'quoteValue'], array_values($data)));
        $query = ' INSERT INTO '.$table.'('.$fields.')'.' VALUES ('.$values.')';
        $this->query($query);

        return $this->getInsertId();
    }

    /*perform UPDATE statement*/
    public function update($table, array $data, $where = '')
    {
        $set = [];
        foreach ($data as $field => $value) {
            $set[] = $field.'='.$this->quotValue($value);
        }
        $set = implode(',', $set);
        $query = ' UPDATE '.$table.' SET '.$set
            .(($where) ? 'WHERE'.$where : '');
        $this->query($query);

        return $this->getAffectedRows();
    }

    /* perform DELETE statement */
    public function delete($table, $where = '')
    {
        $query = ' DELETE FROM '.$table
            .(($where) ? 'WHERE'.$where : '');
        $this->query($query);

        return $this->getAffectedRows();
    }

    /* Escape special values & Characters */
    public function quotValue($value)
    {
        $this->connect();
        if ($value === null) {
            $value = 'NULL';
        } elseif (!is_numeric($value)) {
            $value = "'".mysqli_real_escape_string($this->_link, $value)."'";
        }

        return $value;
    }

    /*fetch single row from the current result set(is an array of associative array)  */
    public function fetch()
    {
        if ($this->_result !== null) {
            if (($row = mysqli_fetch_array($this->_result, MYSQLI_ASSOC)) === false) {
                $this->freeResult();
            }

            return $row;
        }

        return false;
    }

    /*fetch all rows from the current result set(is an array of associative array)  */
    public function fetchAll()
    {
        if ($this->_result !== null) {
            if (($all = mysqli_fetch_all($this->_result, MYSQLI_ASSOC)) === false) {
                $this->freeResult();
            }

            return $all;
        }

        return false;
    }

    /* GET the insertion ID */
    public function getInsertId()
    {
        return $this->_link !== null
    ? mysqli_insert_id($this->_link) : null;
    }

    /* get the number of rows returned by the current result set */
    public function countRows()
    {
        return $this->_result !== null
    ? mysqli_num_rows($this->_result) : 0;
    }

    /* get number of effected rows */
    public function getAffectedRows()
    {
        return $this->_link !== null
    ? mysqli_affected_rows($this->_link) : 0;
    }

    /* free up the current result set */
    public function freeResult()
    {
        if ($this->_result === null) {
            return false;
        }
        mysqli_free_result($this->_result);

        return true;
    }

    /* close connection database */
    public function disconnect()
    {
        if ($this->_link === null) {
            return false;
        }
        mysqli_close($this->_link);
        $this->_link = null;

        return true;
    }

    /* close connection with database  when class timeout */
    public function __destruct()
    {
        $this->disconnect();
    }
}
