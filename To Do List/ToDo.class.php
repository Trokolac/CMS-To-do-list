<?php 

class ToDo {

    private $db;
    public $id;
    public $priority;
    public $task_name;
    public $task_description;
    public $created_at;
    public $updated_at;
    public $deleted_at;
  
    function __construct($id = null) {
        require_once './Helper.class.php';
        $this->db = require './db.inc.php';

        if($id) {
          $this->id = $id;
          $this->all();
        }
    }

    public function insert(){
      Helper::sessionStart();

      if( !isset($_SESSION['user_id']) ) {
        Helper::addError('You have to be logged in to add tasks.');
        return false;
      }

      if( !$this->taskNameEmpty() ){
        return false;
      }
 
      $stmt_insert = $this->db->prepare("
        INSERT INTO `tasks`
          (`user_id`, `priority`, `task_name`, `task_description`)
        VALUES
          (:user_id, :priority, :task_name, :task_description)
      ");
      $success = $stmt_insert->execute([
        ':user_id' => $_SESSION['user_id'],
        ':priority' => $this->priority,
        ':task_name' => ucfirst($this->task_name),
        ':task_description' => ucfirst($this->task_description)
      ]);
      
      if( $stmt_insert->rowCount() > 0 ) {
        Helper::addMessage('Task added!');
        return false;
      }
  
      return true;
    }

    public function taskNameEmpty(){
      if( $this->task_name == "" ){
        Helper::addError('Task name must be filled.');
        return false;
      }
      return true;
    }

    public function all() {
      Helper::sessionStart();

      if( !isset($_SESSION['user_id']) ) {
        return false;
      }

      $stmt_get = $this->db->prepare("
        SELECT *
        FROM `tasks`
        WHERE `deleted_at` IS NULL
        AND `user_id` = :user_id
        ORDER BY priority DESC
      ");
      $stmt_get->execute([
        ':user_id' => $_SESSION['user_id']
      ]);
      return $stmt_get->fetchAll();
    }

    public function finish() {
      $stmt_finish = $this->db->prepare("
        UPDATE `tasks`
        SET `deleted_at` = now()
        WHERE `id` = :id
       
      ");
      return $stmt_finish->execute([ ':id' => $this->id ]);
    }

    public function finished() {

      Helper::sessionStart();

      if( !isset($_SESSION['user_id']) ) {
        
        return false;
      }
      $stmt_get = $this->db->prepare("
        SELECT *
        FROM `tasks`
        WHERE `deleted_at` IS NOT NULL
        AND `user_id` = :user_id
        ORDER BY priority DESC
      ");
      $stmt_get->execute([
        ':user_id' => $_SESSION['user_id']
      ]);
      return $stmt_get->fetchAll();
    }

    public function deleteFromDB() {
      $stmt_delete = $this->db->prepare("
        DELETE
        FROM `tasks`
        WHERE `id` = :id
       
      ");
      return $stmt_delete->execute([ ':id' => $this->id ]);
    }

    public function addComment($body) {
      require_once './User.class.php';
      Helper::sessionStart();
  
      $body = trim($body);
  
      if( !User::isLoggedIn() ) {
        Helper::addError('You have to be logged in to add comment.');
        return false;
      }
  
      if (!$body || $body == "") {
        Helper::addError('Comment can not be empty.');
        return false;
      }
  
      $stmt_addComment = $this->db->prepare("
        INSERT INTO `comments`
        (`user_id`, `body`)
        VALUES
        (:user_id, :body)
      ");
      return $stmt_addComment->execute([
        ':user_id' => $_SESSION['user_id'],
        ':body' => ucfirst($body)
      ]);
    }
  
    public function comments() {
      $stmt_getComments = $this->db->prepare("
        SELECT
          comments.id,
          comments.user_id,
          users.name,
          comments.body,
          comments.created_at
        FROM comments, users
        WHERE comments.deleted_at IS NULL
        AND comments.user_id = users.id
        ORDER BY created_at DESC
      ");
      $stmt_getComments->execute([ 'user_id' => $this->id ]);
      return $stmt_getComments->fetchAll();
    }
  
    public function deleteComment($id) {
      $stmt_delete = $this->db->prepare("
        UPDATE `comments`
        SET `deleted_at` = now()
        WHERE `id` = :id
      ");
      return $stmt_delete->execute([ ':id' => $id ]);
    }
  
}

?>