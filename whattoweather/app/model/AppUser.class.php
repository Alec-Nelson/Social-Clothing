<?php

class AppUser extends DbObject {
    // name of database table
    const DB_TABLE = 'user';

    // database fields
    protected $id;
    protected $username;
    protected $pw;
    protected $first_name;
    protected $last_name;
    protected $email;

    // constructor
    public function __construct($args = array()) {
        $defaultArgs = array(
            'id' => null,
            'username' => '',
            'pw' => '',
            'email' => null,
            'first_name' => null,
            'last_name' => null,
            'admin' => 0
            );

        $args += $defaultArgs;

        $this->id = $args['id'];
        $this->username = $args['username'];
        $this->pw = $args['pw'];
        $this->email = $args['email'];
        $this->first_name = $args['first_name'];
        $this->last_name = $args['last_name'];
        $this->admin = $args['admin'];
    }

    // save changes to object
    public function save() {
        $db = Db::instance();
        // omit id and any timestamps
        $db_properties = array(
            'username' => $this->username,
            'pw' => $this->pw,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'admin' => $this->admin
            );
        $db->store($this, __CLASS__, self::DB_TABLE, $db_properties);
    }

    // delete object
    public function delete()
    {
         $db = Db::instance();
            $query = sprintf(" DELETE FROM %s  WHERE username = '%s' AND pw = '%s' ",
            self::DB_TABLE,
            $this->username,
            $this->pw
            );
            $ex = mysql_query($query);
            if(!$ex)
            die ('Query failed:' . mysql_error());
    }

    // load object by ID
    public static function loadById($id) {
        $db = Db::instance();
        $obj = $db->fetchById($id, __CLASS__, self::DB_TABLE);
        return $obj;
    }

    // load user by username
    public static function loadByUsername($username=null) {
        if($username === null)
            return null;

        $query = sprintf(" SELECT id FROM %s WHERE username = '%s' ",
            self::DB_TABLE,
            $username
            );
        $db = Db::instance();
        $result = $db->lookup($query);
        if(!mysql_num_rows($result))
            return null;
        else {
            $row = mysql_fetch_assoc($result);
            $obj = self::loadById($row['id']);
            return ($obj);
        }
    }

    public function isFollowing($targetId)
    {
        $query = sprintf(" SELECT id FROM %s WHERE follower_id = '%d' AND followee_id = '%d' ",
            "following",
            $this->id,
            $targetId
            );
        $db = Db::instance();
        $result = $db->lookup($query);
        if(!mysql_num_rows($result))
            return false;
        else {
            return true;
        }
    }

    public function getAllFollowing()
    {
        $query = '';
        $query = sprintf(" SELECT * FROM `following` WHERE `follower_id` = %d",
            $this->id
            );
        $db = Db::instance();
        $result = $db->lookup($query);
        if(!mysql_num_rows($result))
            return null;
        else {
            $objects = array();
            while($row = mysql_fetch_assoc($result)) {
                $objects[] = $row['followee_id'];
            }
            return ($objects);
        }
    }

    public function follow($targetId)
    {
        if(!$this->isFollowing($targetId))
        {
            $query = sprintf("INSERT INTO `following`( `follower_id`, `followee_id`) VALUES (%d, %d)",
                $this->id,
                $targetId);
            $db = Db::instance();
            $result = mysql_query($query);
            return $result;
        }
        else
        {
            return false;
        }
    }
    public function unfollow($targetId)
    {
        if($this->isFollowing($targetId))
        {
            $query = sprintf("DELETE FROM `following` WHERE `follower_id`=%d AND `followee_id` = %d",
                $this->id,
                $targetId);
            $db = Db::instance();
            $result = mysql_query($query);
            return $result;
        }
        else
        {
            return false;
        }
    }



}
