<!-- ! press tab -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" type="image/x-icon" href="pin.ico" />

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Handlee|Rock+Salt&display=swap" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="style.css">

  <title>To do List</title>

</head>

<body>
  <?php
      // initialize errors variable
    $errors = "";

    // connect to database
    $db = mysqli_connect("localhost", "root", "", "todo");

    // insert a quote if submit button is clicked
    if (isset($_POST['submit'])) {
      if (empty($_POST['task'])) {
        $errors = "*You must fill in the task";
      }else{
        $task = $_POST['task'];
        $sql = "INSERT INTO tasks (task) VALUES ('$task')";
        mysqli_query($db, $sql);
        header('location: todolist.php');
      }
    }
    if (isset($_GET['del_task'])) {
  $id = $_GET['del_task'];

  mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);
  header('location: todolist.php');
}

?>
  <div class="container">
  <div class="row justify-content-center">
  <ul>
      <li>
          <div class="content">
            <p class="title"><b>TO DO LIST:</b></p>
            <form method="post" action="todolist.php" class="input_form">
              <?php if (isset($errors)) { ?>
          	<p><?php echo $errors; ?></p>
          <?php } ?>

          		<input type="text" name="task" class="task_input">
          		<button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>

          	</form><p style="font-size:20px;color:#007bff;">*Click Task name to mark it done.</p>
            <center>
            <table>
            	<thead>
            		<tr>
            			<th>No.</th>
            			<th>Tasks</th>
            			<th style="width: 60px;">Action</th>
            		</tr>
            	</thead>

            	<tbody>
            		<?php
            		// select all tasks if page is visited or refreshed
            		$tasks = mysqli_query($db, "SELECT * FROM tasks");

            		$i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
            			<tr>
            				<td class="number" width="10"> <?php echo $i; ?> </td>
            				<td class="task"> <?php echo $row['task']; ?> </td>
            				<td class="action">
            					<a href="todolist.php?del_task=<?php echo $row['id'] ?>" >Remove</a>
            				</td>
            			</tr>
            		<?php $i++; } ?>
            	</tbody>
            </table></center>

            </div>
          </div>
      </li>
    </ul>
</div>
</div>
<script>

// Add a "checked" symbol when clicking on a list item
$(function(){
  var $curParent, Content;
  $(document).delegate("td.task","click", function(){
    if($(this).closest("s").length) {
      Content = $(this).parent("s").html();
      $curParent = $(this).closest("s");
      $(Content).insertAfter($curParent);
      $(this).closest("s").remove();
    }
    else {
      $(this).wrapAll("<s />");
    }
  });
});


</script>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

</html>