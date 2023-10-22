<?php
if ($_POST) {
$userN = $_POST['name'];
$passW = $_POST['password'];

$myfile = fopen("bai6.txt", "w") or die("Unable to open file!");
$text="Jacob|transport\nLars|griskraft";
fwrite($myfile,$text);
fclose($myfile);
// Puts the whole array in a file every new line is an array
$userlist = file('bai6.txt',FILE_SKIP_EMPTY_LINES);
//

// Defines a boolean success to false
$success = false;

foreach( $userlist as $user ) {
    $user_details = explode( '|', $user);

   if (trim($user_details[0]) == $userN && trim($user_details[1]) == $passW) {
    //if ((in_array($userN, $user_details) and (in_array($passW,     $user_details)))) {
        $success = true;
        echo $success . " is: ";
        break;
    }
}

if ($success) {
    echo "<br> Hi $userN you have been logged in. <br>";
} else {
    echo "<br> You have entered the wrong username or password. Please try again. <br>";
}
}

?>

    <form action="" method="POST">
        Comments:
        <textarea rows="10" cols="30" name="commentContent"></textarea>
        <br /> Name: <input type="text" name="name"><br /> Password: <input
            type="password" name="password" size="15" maxlength="30" /> <br /> <input
            type="submit" value="Post!"> <br />
    </form>

