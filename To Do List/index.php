<?php 
require_once './ToDo.class.php';
require_once './User.class.php';
require_once './Helper.class.php';

if( User::isLoggedIn() ) { 
    $loggedInUser = new User();
    $loggedInUser->loadLoggedInUser();
}

// dodavanje novog taska u bazu
if( isset($_POST['add']) ){
    $t = new ToDo();
    $t->task_name = $_POST['task_name'];
    $t->task_description = $_POST['task_description'];
    $t->priority = $_POST['priority'];
    $t->insert();
} 

// zavrsen task
if( isset($_POST['finished']) ) {
    $taskFinished = new ToDo($_POST['finished_task']);
    if( $taskFinished->finish() ) {
        Helper::addMessage("You finished the task <strong>$loggedInUser->name!</strong>");
    } else {
        Helper::addError("Something went wrong.");
    }
  }

//delete iz databaze
  if( isset($_POST['delete']) ) {
    $taskDelete = new ToDo($_POST['delete_task']);
    if( $taskDelete->deleteFromDB() ) {
        Helper::addMessage("Task deleted!");
    } else {
        Helper::addError("Something went wrong.");
    }
  }

// prikazati taskove iz baze
$u = new ToDo();
$tasksAll = $u->all();

//prikazati taskove koji su zavrseni
$f = new ToDo();
$tasksFinished = $u->finished();

$comentSection = new ToDO();

if( isset($_POST['post_comment']) ) {
    if( $comentSection->addComment($_POST['body']) ) {
      Helper::addMessage('Comment added successfully.');
    }
  }
  
if( isset($_POST['delete_comment']) ) {
    if( $comentSection->deleteComment($_POST['comment_id']) ) {
      Helper::addMessage('Comment deleted successfully.');
    } else {
      Helper::addError('Failed to delete comment.');
    }
  }

$comments = $comentSection->comments();
    
?>

<?php include './header.layout.php'; ?>

<?php 
Helper::sessionStart();
if (isset($_SESSION['user_id'])) { ?>

<div class="container">
    <div class="row mt-5">
        <div class="col-md-6">
            <form action="./index.php" method="post">

                <h5>Task Name</h5>

                <input name="task_name" type="text" class="form-control">

                <h5 class="mt-4">Task description</h5>

                <textarea name="task_description" class="form-control" rows="5"></textarea>

                <div class="checkboxes">

                    <h5 class="mt-4">Priority</h5>
                    <input name="priority" type="radio" name="checkbox" value="1" id="1" checked />
                    <label for="1">1</label> &nbsp;
                    <input name="priority" type="radio" name="checkbox" value="2" id="2" />
                    <label for="2">2</label> &nbsp;
                    <input name="priority" type="radio" name="checkbox" value="3" id="3" />
                    <label for="3">3</label> &nbsp;
                    <input name="priority" type="radio" name="checkbox" value="4" id="4" />
                    <label for="4">4</label> &nbsp;
                    <input name="priority" type="radio" name="checkbox" value="5" id="5" />
                    <label for="5">5</label>
                </div>

                <button name="add" class="btn btn-outline-dark mt-4" style="width:100%;">Add</button>

            </form>
        </div>
        <div class="col-md-6">
            <?php require_once './tasks.php'; ?>
        </div>
    </div>
</div>

<?php } ?>

<?php
Helper::sessionStart();
if (!isset($_SESSION['user_id'])) {
?>
<div class="container">
<div class="row mt-5">
    <div class="col-md-5 mt-5">
        <h1>Site lets you work more collaboratively and get more done.</h1>
        <h4 class="mt-3">Site’s boards and lists enable you to organize and prioritize your projects in a fun, flexible, and rewarding way.</h4>
        <a href="./register.php"><button type="button" class="btn btn-success btn-lg mt-3 mb-5">Sign Up - It's Free!</button></a>
    </div>
    <div class="col-md-7">
        <img class="mb-5" src="./IMG/hero-a.svg">
    </div> 
</div>
</div>
<?php } ?>

<div class="container">
<div class="row">
  <div class="col-md-12">
    <h2 class="mt-5 mb-4">Comments</h2>
  </div>
</div>

<?php
Helper::sessionStart();
if (isset($_SESSION['user_id'])) {
?>
<div class="row">
  <div class="col-md-12 mb-5">
    <form action="./index.php" method="post">
      <div class="form-group">
        <label for="inputBody">Comment</label>
        <textarea name="body" class="form-control" id="inputBody" rows="3"></textarea>
      </div>
      <button name="post_comment" class="btn btn-outline-dark float-right">Post comment</button>
      <br clear="all" />
    </form>
  </div>
</div>
<?php } ?>

<?php foreach($comments as $comment) { ?>
<div class="row mb-5">
  <div class="col-md-12">
  
      <div class="card comment">

      <?php
          require_once './User.class.php';
          $loggedInUser = new User();
          $loggedInUser->loadLoggedInUser();
          $canDeleteComment = false;

          if( $loggedInUser->id == $comment->user_id ) {
            $canDeleteComment = true;
          }
        ?>

        <?php if($canDeleteComment) { ?>
          <form action="./index.php" method="post" class="deleteCommentForm">
            <input type="hidden" name="comment_id" value="<?php echo $comment->id; ?>" />
            <button name="delete_comment" class="btn btn-outline-danger">Delete</button>
          </form>
        <?php } ?>

        <div class="card-body"><?php echo $comment->body; ?></div>
        <div class="card-meta">
          Posted by <b><?php echo $comment->name; ?></b> 
          at <?php echo $comment->created_at ?>
        </div>
      </div>
<?php } ?>
  </div>
</div>






<?php include './footer.layout.php'; ?>