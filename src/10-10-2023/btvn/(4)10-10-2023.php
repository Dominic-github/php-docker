<?php 
$listTodo = array();
$input = "";



function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $input = test_input($_POST["input"]);
  array_push($listTodo,$input);
}

?>
  <form method="post" action="
<?php
echo htmlspecialchars($_SERVER["PHP_SELF"]);

?>">

Input Todo: <input name="input" type='text'/>
<input type="submit" name="submit" value="Submit">
</form>

<ul>
<?php foreach($listTodo as $val): ?>
    <li>
    <input class="notborder"readonly value=<?=$val;?>>
        <button>Change</button>
        <button>Delete</button>
    </li>
<?php endforeach; ?>
</ul>


