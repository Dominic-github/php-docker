<?php
ob_start();
include('includes/header.php');
include('../middleware/adminMiddleware.php');

include_once('../config/connectDB.php');
if(isset($_POST['search'])){
  $value = $_POST['text_search'];
  $string = "SELECT *  FROM Users WHERE user_id like '%$value%' OR username Like '%$value%' ";
  $query = mysqli_query($conn,$string);
}else{
  $query = mysqli_query($conn,"SELECT *  FROM Users");
}

?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex">
          <h4 class=" col-md-2">All User</h4>
          <form class=" input-group" action="user-list.php" method="post">
            <div class="form-outline">
              <input type="search" name="text_search" id="form1" class="form-control" placeholder="Search user" />
            </div>
          <button type="submit" name="search" class="btn btn-primary">
            <i class="fas fa-search"></i>
              </button>
            </form>
            <form class="input-group" action="functions/actions.php" method="post">
          
          <button type="submit" name="export-user-csv" class="btn btn-primary ms-md-auto pe-md-4">
            Export
              </button>
            </form>

        </div>
        <div class="card-body">
          <table class="table table-striped">

          <thead>

            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>FullName</th>
              <th>Email</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>

            <tbody>
              <?php
              $index = 0;
              while($row = mysqli_fetch_assoc($query) ){
              $role_id = $row["role_id"];
              $role = $role_id == 1? "Admin" : "User";
              ?>
                  <tr class='products'>
                       <th scope="row"><?=$row["user_id"]?></th>
                       <td>'<?=$row["username"]?>'</td>
                       <td>"<?=$row["full_name"]?>"</td>
                       <td>"<?=$row["email"]?>"</td>
                       <td>"<?=$role?>"</td>
                       <td class="actions">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeModal-<?=$row["user_id"]?>">
                              Change
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="changeModal-<?=$row["user_id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Change User ID: <?=$row["user_id"]?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                 <form action="functions/actions.php?id=<?=$row["user_id"]?>" method="POST">
                                  <div class="modal-body">
                                  <div class="form-group">
                                      <label for="">Username</label>
                                      <input type="text" name='username' class="form-control" value="<?=$row["username"]?>" placeholder="Enter username">
                                    </div>
                                        <div class="form-group">
                                      <label for="">Email</label>
                                      <input type="text" name='email' class="form-control"  value="<?=$row["email"]?>" placeholder="Enter email">
                                    </div>
                                    <div class="form-group">
                                      <label for="">FullName</label>
                                      <input type="text" name='full_name' class="form-control" value="<?=$row["full_name"]?>" placeholder="Enter fullname">
                                    </div>
                                     <div class="form-group">
                                      <label for="">Password</label>
                                      <input type="password" name='password' class="form-control" value="" placeholder="Enter password">
                                    </div>
                                     <div class="form-group">
                                      <label for="">Confirm password</label>
                                      <input type="password" checked  name='confirm_password' class="form-control" value="" placeholder="Enter confirm password">
                                    </div>
                                  </div>

                                    <div class="form-group">
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="role" value="Admin" id="admin-radio" >
                                          <label class="form-check-label" for="flexRadioDefault1">
                                           Admin
                                         </label>
                                         <input class="form-check-input" type="radio" name="role" checked value="User" id="user-radio" >
                                         <label class="form-check-label" for="flexRadioDefault2">
                                           User
                                          </label>
                                         </div>
                                    </div>
                    


                                  <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                                        <button type="submit" name="change-user" class="btn btn-primary">Save changes</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>


                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal-<?=$row["user_id"]?>">
                              Delete
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal-<?=$row["user_id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Are you sure, want to delete User ID: <?=$row["user_id"]?>
                                  </div>
                                  <div class="modal-footer">
                                    <form action="functions/actions.php?id=<?=$row["user_id"]?>" method="POST">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" name="delete-user" class="btn btn-primary">Yes</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                        </div>
                       </td>
                     </tr>
              
              <?php } ?>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </thead>
          </table>

        </div>
      </div>
    </div> 
  </div>
</div>


<?php include('./includes/footer.php')?>