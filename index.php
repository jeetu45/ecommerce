<?php 
       require_once $_SERVER['DOCUMENT_ROOT'].'/socialnetwork/core/init2.php';
       include ("includes/head.php");
        if(!is_logged_in()){
     login_error_redirect();
     header('Location: login.php');
   }
      include("includes/navigation.php");
      include("includes/headerfull.php");
      include("includes/leftbar.php");
      echo $_SESSION['ABuser'];

   $sql = "SELECT * FROM products WHERE featured = 1";
   $featured = $db->query($sql);
 ?>

  <!--main content-->
  <div class="col-md-8">
  <div class="row">
  <h2 class="text-center">Feature Product</h2>
  <?php while($product = mysqli_fetch_assoc($featured)) : ?>
  <div class="col-md-3 text-center">
  <h4><?php echo $product['title']; ?></h4>
  <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>" class="img-thumb" />
  <p class="list-price text-danger">List Price:  <s>$<?php echo $product['list_price']; ?></s></p>
  <p class="price">Our Price: $<?php echo $product['price']; ?></p>
  <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?php echo $product['id']; ?>)">Details</button>
  </div>
   <?php endwhile; ?>
  </div>
  </div>

<?php
  include("includes/rightbar.php");
  include("includes/footer.php");
  ?>
 