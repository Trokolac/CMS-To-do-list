<h5>To do list</h5>

<table class="table table-hover">
  <thead class="thead-dark">
    <tr>
      <th width="20%">Priority</th>
      <th width="30%">Task</th>
      <th width="50%">Description</th>
      <th></th>
    </tr>
  </thead>
  <tbody>

    <?php 
    if(is_array($tasksAll)){
    foreach( $tasksAll as $task ){ ?>
    <tr>
      <th scope="row"> <?php echo "$task->priority"; ?> </th>
      <td><?php echo "$task->task_name"; ?></td>
      <td><?php echo "$task->task_description"; ?></td>
      <td>

            <form action="./index.php" method="post">
              <input type="hidden" name="finished_task" value="<?php echo $task->id ?>" />
              <button name="finished" class="btn btn-sm btn-outline-success"><i class="fas fa-check"></i> Finish</button>
            </form>

            
          </td>
    </tr>
    <?php 
      } 
    }?>
    
  </tbody>
</table>

<h5>Finished tasks</h5>

<table class="table table-hover">
  <thead class="thead-dark">
    <tr>
      <th width="20%">Priority</th>
      <th width="30%">Task</th>
      <th width="50%">Description</th>
      <th></th>
    </tr>
  </thead>
  <tbody>

    <?php 
    if(is_array($tasksFinished)){
    foreach( $tasksFinished as $taskDone ){ ?>
    <tr>
      <th scope="row"> <?php echo "$taskDone->priority"; ?> </th>
      <td><?php echo "$taskDone->task_name"; ?></td>
      <td><?php echo "$taskDone->task_description"; ?></td>
      <td>

            <form action="./index.php" method="post">
              <input type="hidden" name="delete_task" value="<?php echo $taskDone->id ?>" />
              <button name="delete" class="btn btn-sm btn-outline-danger"><i class="fas fa-minus-circle"></i> Delete</button>
            </form>

            
          </td>
    </tr>
    <?php 
      }
    } ?>
    
  </tbody>
</table>