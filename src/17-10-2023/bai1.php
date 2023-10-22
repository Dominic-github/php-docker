<?php 

// $myfile = fopen("bai1.txt", "w") or die("Unable to open file!");
// $text="lam viec nha\nchoi game\npython";
// fwrite($myfile,$text);
// fclose($myfile);

$myfile = fopen("bai1.txt", "r") or die("Unable to open file!");

$listTodo = array();

while (($line = fgets($myfile)) !== false) {
  array_push($listTodo,$line);
}
fclose($myfile);

$index = 0;

$input = "";


function updateFile($listTodo){
  $myfile = fopen("bai1.txt", "w") or die("Unable to open file!");
    foreach ($listTodo as $value) {
      $todo_details = explode( '|', $value);
      $value = trim($todo_details[0]."|".$todo_details[1]);
      fwrite($myfile,$value);
      fwrite($myfile,"\n");
    }
    fclose($myfile);
}


if(isset($_POST['pushtodo'])){
  $input = $_POST['input'];
  if($input!=""){

    $input = $input."|0";

    array_push($listTodo,$input);
    
    updateFile($listTodo);
  }
}

if(isset($_POST['done'])){
  $id = $_GET['id'];
  $todoInput = trim($_POST['todo-'.$id]."|1");
  $listTodo[count($listTodo) - (int)$id - 1] = $todoInput;
  updateFile($listTodo);
}



if(isset($_POST['submitChange'])){
  $id = $_GET['id'];
  $todoInput = trim($_POST['todo-'.$id]."|0");
  $listTodo[count($listTodo) - (int)$id - 1] = $todoInput;
  updateFile($listTodo); 
}

if(isset($_POST['delete'])){
  $id = $_GET['id'];
  unset($listTodo[count($listTodo) - (int)$id - 1]);  
  updateFile($listTodo); 
}




?>



<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Todo List</title>
        <style>
          .htsp{
            margin-top: 20px;
          }
          input.notborder{
          border: none;
          }
          ul{
          list-style-type: none;
          }

          .success{
            text-decoration-line: line-through;
          }
          form{
            margin: 0;
          }

          .notChange{
            background-color: #ddd;
          }

        </style>
    </head>
        <h1>Todo List</h1>


<form method="post" action="bai1.php">

Input Todo: <input name="input" type='text'/>
<input type="submit" name="pushtodo" value="Submit">
</form>


<ul>List Todo:
      </br>
<?php 
  $listTodo = array_reverse($listTodo);
  foreach($listTodo as $val):?>
  
 <?php if($val != ""): 
    $todo_details = explode( '|', $val);
    ?> 
    <li class="todo-<?=$index?>">
      <form method="post" action="bai1.php?id=<?=$index?>">
        <input type="text" id="<?=$index?>" readonly name="todo-<?=$index?>" class="notChange todo-input todo-input-<?=$index?> <?=$todo_details[1] == 0 ? '' : 'success'?>" value="<?=$todo_details[0];?>"/>
          <input type="submit" id="<?=$index?>" name="done" class="doneButton" value="Done!" />
          <input type="button" id="<?=$index?>" name="change" class="changeButton" value="Change" />
          <input type="submit" id="<?=$index?>" name="submitChange" class="submitChangeButton" value="Submit" />
          <input type="submit" id="<?=$index?>" name="delete" class="deleteButton" value="Delete" />
        </form>
    </li>
    <?endif;?>
<?php $index++; endforeach ?>
</ul>





<script>

let todo = document.querySelectorAll('.todo-input')

let changeButton = document.querySelectorAll('.changeButton')
changeButton.forEach((value)=>{
  console.log(value);
  value.addEventListener("click", ()=>{

    todo[value.id].classList.contains('notChange') ? todo[value.id].classList.remove('notChange'):todo[value.id].classList.add('notChange')

    todo[value.id].readOnly = !todo[value.id].readOnly;
  });
})


</script>
