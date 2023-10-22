<?php 

$myfile = fopen("bai2.txt", "r") or die("Unable to open file!");
$listPeople = array();

while (($line = fgets($myfile)) !== false) {
  array_push($listPeople,$line);
}
fclose($myfile);
$index = 0;


$fullname = "";
$email = "";
$number = "";


function updateFile($listPeople){
  $myfile = fopen("bai2.txt", "w") or die("Unable to open file!");
    foreach ($listPeople as $human) {
      $human_details = explode( '|', $human);
      $human = trim($human_details[0]."|".$human_details[1]."|".$human_details[2]);
      fwrite($myfile,$human);
      fwrite($myfile,"\n");
    }
    fclose($myfile);
}


if(isset($_POST['pushhuman'])){

  //Lấy dữ liệu nhập vào
  $fullname = addslashes($_POST['txtFullname']);
  $email = addslashes($_POST['txtEmail']);
  $number = addslashes($_POST['txtNumber']);


  if($fullname!="" && $email!="" && $number!=""){
    $input = $fullname."|".$email."|".$number;
    array_push($listPeople,$input);
    updateFile($listPeople);
  }
}



if(isset($_POST['submitChange'])){
  $id = $_GET['id'];
  $fullname = addslashes($_POST['txtFullname-'.$id]);
  $email = addslashes($_POST['txtEmail-'.$id]);
  $number = addslashes($_POST['txtNumber-'.$id]);

  if($fullname!="" && $email!="" && $number!=""){
    $input = $fullname."|".$email."|".$number;
    $listPeople[count($listPeople) - (int)$id - 1] = $input;
    updateFile($listPeople);
  }
}

if(isset($_POST['delete'])){
  $id = $_GET['id'];
  unset($listPeople[count($listPeople) - (int)$id - 1]);  
  updateFile($listPeople); 
}



?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Directory</title>

        <style>
          ul{
            list-style-type: none;
          }
          .list-human{
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            flex: 1;
          }

          form{
            margin: 0;
          }

          .human{
            margin: 20px;;
            border: 1px solid #333;
            height: 250px;
            width: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
          }
          .human-img{
            width: 150px;
            height: 150px;
          }
          .human-info{
          display: flex;
          flex-direction: column;
          align-items: center;
          }
          h5{
            padding: 0;
            margin: 5px;
          }
          .not_border{
            border: 1px solid #fff;
          }
          
        </style>
    </head>

        <h1>Thêm danh bạ</h1>
        <form action="bai2.php" method="POST">
            <table cellpadding="0" cellspacing="0" border="1">
                <tr>
                    <td>
                        Tên đầy đủ : 
                    </td>
                    <td>
                        <input type="text" name="txtFullname" size="50" />
                    </td>
                </tr>
                <tr>
                    <td>
                    Email:
                    </td>
                    <td>
                        <input type="text" name="txtEmail" size="50" />
                    </td>
                </tr>
                <tr>
                    <td>
                    Số điện thoại :
                    </td>
                    <td>
                        <input type="text" name="txtNumber" size="50" />
                    </td>
                </tr>
               
               
            </table>
            <input type="submit" name='pushhuman' value="Thêm" />
            <input type="reset" value="Nhập lại" />
        </form>

        <h1>List danh bạ: </h1>
        <ul class='list-human'>

        <?php 
        $listPeople = array_reverse($listPeople);
        foreach($listPeople as $human):?>

          <?php if($human != ""): 
            $human_details = explode( '|', $human);
            ?> 
          <li class='human'>
            
            <form method="post" action="bai2.php?id=<?=$index?>">
                <img class='human-img' src="https://cdn-icons-png.flaticon.com/512/6596/6596121.png" alt="image">
                <div class="human-info notChange">
                  <input type="text" class='not_border' readonly id="<?=$index?>" name="txtFullname-<?=$index?>" value="<?=$human_details[0]?>"/> 
                  <input type="text" class='not_border' readonly id="<?=$index?>" name="txtEmail-<?=$index?>" value="<?=$human_details[1]?>"/> 
                  <input type="text" class='not_border' readonly id="<?=$index?>" name="txtNumber-<?=$index?>" value="<?=$human_details[2]?>"/> 
                </div>

                <div class="human_action">
                  <input type="button" id="<?=$index?>" name="change" class="changeButton" value="Change" />
                  <input type="submit" id="<?=$index?>" name="submitChange" class="submitChangeButton" value="Submit" />
                  <input type="submit" id="<?=$index?>" name="delete" class="deleteButton" value="Delete" />
                </div>

            </form>
           
            
          </li>



            <?endif;?>
        <?php $index++; endforeach ?>
        </ul>



<script>

let human = document.querySelectorAll('.human-info')
let changeButton = document.querySelectorAll('.changeButton')
changeButton.forEach((value)=>{
  value.addEventListener("click", ()=>{

    human[value.id].childNodes[1].classList.contains('not_border') ? human[value.id].childNodes[1].classList.remove('not_border'):human[value.id].childNodes[1].classList.add('not_border')
    human[value.id].childNodes[3].classList.contains('not_border') ? human[value.id].childNodes[3].classList.remove('not_border'):human[value.id].childNodes[3].classList.add('not_border')
    human[value.id].childNodes[5].classList.contains('not_border') ? human[value.id].childNodes[5].classList.remove('not_border'):human[value.id].childNodes[5].classList.add('not_border')

    human[value.id].childNodes[1].readOnly = !human[value.id].childNodes[1].readOnly;
    human[value.id].childNodes[3].readOnly = !human[value.id].childNodes[3].readOnly;
    human[value.id].childNodes[5].readOnly = !human[value.id].childNodes[5].readOnly;
  });
})


</script>
