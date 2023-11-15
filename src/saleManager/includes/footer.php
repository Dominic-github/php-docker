    <!-- Optional JavaScript; choose one of the two! -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="assets/js/bootstrap.bundle.min.js" ></script>

      <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script>
      <?php 
      if(isset($_SESSION['message'])){
       ?>
     alertify.set('notifier','position', 'top-right');

     if("<?= $_SESSION['status']; ?>" == "success"){
       alertify.success("<?= $_SESSION['message']; ?>");
     }else if ("<?= $_SESSION['status']; ?>" == "warning"){
        alertify.warning("<?= $_SESSION['message']; ?>");
     }else{
      alertify.error("<?= $_SESSION['message']; ?>");
     }

      <?php
      unset($_SESSION['message']);
      unset($_SESSION['status']);
      }
      ?>

  </body>
</html>
