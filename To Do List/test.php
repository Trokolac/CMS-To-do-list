<?php foreach( $tasks_finished as $task_finished){ ?>

<form action="./index.php" method="post">
  <input type="hidden" name="finished_task" value="<?php echo $task_finished->id; ?>" />
  <button name="finished" class="btn btn-sm btn-outline-success">Finished</button>
</form>

<?php } ?>