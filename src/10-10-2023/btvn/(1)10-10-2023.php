<?php
$yourEmail ="";
$sendto = "";
$comment= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $youremail= test_input($_POST["youremail"]);
  $sendto = test_input($_POST["sendto"]);
  $subject= test_input($_POST["subject"]);
  $comment = test_input($_POST["comment"]);
}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>


  <form method="post" action="
<?php 
// send email
echo htmlspecialchars($_SERVER["PHP_SELF"]);
// mail($sendto,$subject,$comment);

?>">

  Your Email: <input type="text" name="youremail">
  <br><br>
  Send To: <input type="text" name="sendto">
  <br><br>
  Subject: <input type="text" name="subject">
  <br><br>
  Comment: <textarea name="comment" rows="5" cols="40"></textarea>
  <br><br>
<input type="submit" name="submit" value="Submit">
    </form>


<?php 
echo "<h2>Your Input:</h2>";
echo $youremail;
echo "<br>";
echo $sendto;
echo "<br>";
echo $subject;
echo "<br>";
echo $comment;
?>
