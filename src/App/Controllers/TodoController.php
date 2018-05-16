<?php

namespace App\Controllers;

class TodoController
{
    private $db;

    /**
     * Dependeny Injection (DI): http://www.phptherightway.com/#dependency_injection
     * If this class relies on a database-connection via PDO we inject that connection
     * into the class at start. If we do this TodoController will be able to easily
     * reference the PDO with '$this->db' in ALL functions INSIDE the class
     * This class is later being injected into our container inside of 'App/container.php'
     * This results in we being able to call '$this->get('Todos')' to call this class
     * inside of our routes.
     */
    public function __construct(\PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function getAll()
    {
        $getAll = $this->db->prepare('SELECT * FROM entries');
        $getAll->execute();
        return $getAll->fetchAll();
    }

    public function getLast20Entries()
    {
        $getAll = $this->db->prepare('SELECT * FROM (SELECT * FROM entries ORDER BY entryID DESC LIMIT 20) as r ORDER BY entryID');
        $getAll->execute();
        return $getAll->fetchAll();
    }

    public function getAllFromUsers()
    {
        $getAll = $this->db->prepare('SELECT * FROM users');
        $getAll->execute();
        return $getAll->fetchAll();
    }

    public function getOne($table,$id)
    {
      $tableID = "";
      if ($table == 'entries') {
        $tableID = "entryID";
      }
      elseif ($table == 'users') {
        $tableID = 'userID';
      }
        $getOne = $this->db->prepare("SELECT * FROM $table WHERE $tableID = :id");
        $getOne->execute([
          ':id' => $id
        ]);
        return $getOne->fetch();
    }


    /****************************************/
    /* Post */
    /****************************************/

    // Add a user
    public function addUser($todo)
    {
        $addOne = $this->db->prepare(
            'INSERT INTO users (username, password) VALUES (:username, :password)'
        );

        $hashed = password_hash($todo['password'], PASSWORD_DEFAULT);
        $addOne->execute([
          ':username'  => $todo['username'],
          'password' => $hashed
        ]);
        return [
          'id'          => (int)$this->db->lastInsertId(),
          'username'     => $todo['username']
        ];
    }

    // Add an entry
    public function addEntry($todo)
    {
        $addOne = $this->db->prepare(
            'INSERT INTO entries (`title`, `content`, `createdBy`, `createdAt`) VALUES (:title, :content, :createdBy, :createdAt)'
        );

        $hashed = password_hash($todo['password'], PASSWORD_DEFAULT);
        $addOne->execute([
          ':title'  => $todo['title'],
          ':content'  => $todo['content'],
          ':createdBy'  => $todo['createdBy'],
          ':createdAt'  => $todo['createdAt']
        ]);
        return [
          'entryID'      => (int)$this->db->lastInsertId(),
          'title'     => $todo['title'],
          'content'     => $todo['content'],
          'createdAt'     => $todo['createdAt'],
        ];
    }

}
