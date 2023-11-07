   <footer class="footer pt-5">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-12">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="#" class="nav-link pe-0 text-muted" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link pe-0 text-muted" target="_blank">Services</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link pe-0 text-muted" target="_blank">Contact</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link pe-0 text-muted" target="_blank">Help & Support</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

  </main>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/smooth-scrollbar.min.js"></script>
  <!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
  <?php 
  if(isset($_SESSION['message'])){
   ?>

 alertify.set('notifier','position', 'top-right');

 if("<?= $_SESSION['status']; ?>" == "success"){
   alertify.success("<?= $_SESSION['status']; ?>");
 }else if ("<?= $_SESSION['status']; ?>" == "warning"){
    alertify.warning("<?= $_SESSION['status']; ?>");
 }else{
  alertify.error("<?= $_SESSION['status']; ?>");
 }

  <?php
  unset($_SESSION['message']);
  unset($_SESSION['status']);
  }
  ?>

</script>
</body>
</html>