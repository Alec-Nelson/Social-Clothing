<?php

class Posts extends DbObject {
    // name of database table
    const DB_TABLE = 'posts';

    // database fields
    protected $id;
    protected $title;
    protected $content;
    protected $author_id;
    protected $date_created;

    // constructor
    public function __construct($args = array()) {
        $defaultArgs = array(
            'id' => null,
            'author_id' => 0,
            'shirt_id' => 0,
            'pants_id' => 0,
            'shoes_id' => 0,
            'hat_id' => 0,
            'jacket_id' => 0,
            'message' => '',
            'location' => '',
            'date_created' => null
            );

        $args += $defaultArgs;

        $this->id = $args['id'];
        $this->author_id = $args['author_id'];
        $this->shirt_id = $args['shirt_id'];
        $this->pants_id = $args['pants_id'];
        $this->shoes_id = $args['shoes_id'];
        $this->hat_id = $args['hat_id'];       
        $this->jacket_id = $args['jacket_id'];
        $this->message = $args['message'];
        $this->location = $args['location'];
        $this->date_created = $args['date_created'];
    }

    // save changes to object
    public function save() {
        $db = Db::instance();
        // omit id and any timestamps
        $db_properties = array(
            'author_id' => $this->author_id,
            'shirt_id' => $this->shirt_id,
            'pants_id' => $this->pants_id,
            'shoes_id' => $this->shoes_id,
            'hat_id' => $this->hat_id,
            'jacket_id' => $this->jacket_id,
            'message' => $this->message,
            'location' => $this->location
            );
        $db->store($this, __CLASS__, self::DB_TABLE, $db_properties);
    }

    // load object by ID
    public static function loadById($id) {
        $db = Db::instance();
        $obj = $db->fetchById($id, __CLASS__, self::DB_TABLE);
        return $obj;
    }

    // load all posts on this blog
    public static function getAllPosts($limit=null) {
        $query = '';
        if($limit == null)
        {
            $query = sprintf(" SELECT id FROM %s ORDER BY date_created DESC",
                self::DB_TABLE
                );
        }
        else
        {
            $query = sprintf(" SELECT id FROM %s ORDER BY date_created DESC LIMIT %d ",
                self::DB_TABLE,
                $limit
                );
        }
        $db = Db::instance();
        $result = $db->lookup($query);
        if(!mysql_num_rows($result))
            return null;
        else {
            $objects = array();
            while($row = mysql_fetch_assoc($result)) {
                $objects[] = self::loadById($row['id']);
            }
            return ($objects);
        }
    }

    public static function getUserPosts($id){
        $query = sprintf(" SELECT id FROM %s WHERE author_id = '%s' ORDER BY date_created DESC ",
            self::DB_TABLE,
            $id
            );
        $db = Db::instance();
        $result = $db->lookup($query);
        if(!mysql_num_rows($result))
            return null;
        else {
            $objects = array();
            while($row = mysql_fetch_assoc($result)) {
                $objects[] = self::loadById($row['id']);
            }
            return ($objects);
        }
    }

    public static function deletePosts($id){
        $db = Db::instance();
        $query = sprintf(" DELETE FROM %s  WHERE author_id = '%s'",
            self::DB_TABLE,
            $id
        );
        $ex = mysql_query($query);
        if(!$ex)
        die ('Query failed:' . mysql_error());
    }

}
