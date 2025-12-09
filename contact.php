  
  <?php
require_once 'config/db.php';

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'] ;
    $last_name  = $_POST['last_name'] ;
    $email      = $_POST['email'] ;
    $city       = $_POST['city'] ;
    $interest   = $_POST['interest'] ;
    $timeline   = $_POST['timeline'] ;
    $message    = $_POST['message'] ;
    $agree_marketing = isset($_POST['agree_marketing']) ? 1 : 0;

    if (empty($first_name) || empty($last_name) || empty($email)) {
        $error_message = "Please fill in the required fields";
    } else {
        $sql = "INSERT INTO contact_messages 
            (first_name, last_name, email, city, interest, timeline, message, agree_marketing) 
            VALUES 
            ('$first_name', '$last_name', '$email', '$city', '$interest', '$timeline', '$message', $agree_marketing)";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Your message has been sent successfully!";
            $_POST = [];
        } else {
            $error_message = "Error occurred: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Urbanix</title>
    <link rel="stylesheet" href="fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="CSS/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Days+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Days+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/contact.css">
    <link rel="stylesheet" href="CSS/about.css">
</head>
<body>

<!-- start of Navbar -->
<nav class="navbar navbar-expand-lg position-fixed top-0 end-0 start-0 border border-bottom-1 border-top-0 border-start-0 border-end-0 border-secondary">
  <div class="container-fluid">
    <h5 class="me-4 mt-2 logo">URBANIX</h5>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link me-2" href="home.html">HOME</a></li>
        <li class="nav-item"><a class="nav-link me-2" href="products.html">PRODUCTS</a></li>
        <li class="nav-item"><a class="nav-link me-2" href="about.php">ABOUT</a></li>
        <li class="nav-item"><a class="nav-link me-2" href="cart.html">CART</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">CONTACT US</a></li>
      </ul>
      <form class="d-flex me-2" action="index.html">
        <a class="mt-1" href="admin.php"><i class="fa-regular fa-user nav-icon me-4"></i></a>
        <i class="fa-solid fa-cart-shopping nav-icon me-3"></i>
        <button class="btn nav-btn fw-bold px-3" type="submit">Logout</button>
      </form>
    </div>
  </div>
</nav>
<!-- end of navbar -->

<section id="contactUs" class="contactUs pt-5">
  <div class="container mb-5 py-5">
    <div class="row form-roww rounded-4 m-auto">

       <!-- forrmmmmmmmmmmmmmmmm -->
      <div class="col-lg-8 p-5 bg-white l-form">
        <h4 class="fw-bold mb-4">Get in Touch with Urbanix</h4>
        <p class="fs-6 mb-4">Have a question or want styling advice? Fill out the form and we’ll get back to you within 24 hours with personalized tips and offers.</p>

        <?php if($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="" method="POST" class="contactUs-form">
          <div class="row">
            <div class="col-lg-6 col-sm-12 mb-3">
              <label for="f-name" class="mb-2">First Name *</label>
              <input type="text" id="f-name" name="first_name" class="form-control" placeholder="John" required value="<?php echo $_POST['first_name'] ?? ''; ?>">
            </div>
            <div class="col-lg-6 col-sm-12 mb-3">
              <label for="l-name" class="mb-2">Last Name *</label>
              <input type="text" id="l-name" name="last_name" class="form-control" placeholder="Doe" required value="<?php echo $_POST['last_name'] ?? ''; ?>">
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6 col-sm-12 mb-3">
              <label for="email" class="mb-2">Email Address *</label>
              <input type="email" id="email" name="email" class="form-control" placeholder="john@company.com" required value="<?php echo $_POST['email'] ?? ''; ?>">
            </div>
            <div class="col-lg-6 col-sm-12 mb-3">
              <label for="c-name" class="mb-2">City</label>
              <input type="text" id="c-name" name="city" class="form-control" placeholder="Your City" value="<?php echo $_POST['city'] ?? ''; ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="select1" class="mb-2">Focus Area</label>
            <select name="interest" id="select1" class="form-select">
              <option value="">Select your interest</option>
              <option value="Clothing" >Clothing</option>
              <option value="Sneakers" >Sneakers</option>
              <option value="Bags & Accessories" >Bags & Accessories</option>
              <option value="Styling Advice" >Styling Advice</option>
              <option value="Collaboration / Partnership"  >Collaboration / Partnership</option>
            </select>
          </div>

          <div class="row mb-3">
            <label for="select2" class="mb-2">When Would You Like to Start?</label>
            <select name="timeline" id="select2" class="form-select">
              <option value="">Select timeline</option>
              <option value="Immediately" >Immediately</option>
              <option value="Within 1 week" >Within 1 week</option>
              <option value="Within 1 month" >Within 1 month</option>
              <option value="Just browsing" >Just browsing</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="notes" class="mb-2">Tell Us What You’re Looking For</label>
            <textarea name="message" id="notes" class="form-control" rows="5" placeholder="Describe the styles or products you’re looking for…"><?php echo $_POST['message'] ?? '' ; ?></textarea>
          </div>

          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="checkbox" name="agree_marketing" value="1" <?php echo isset($_POST['agree_marketing'])?'checked':''; ?>>
            <label class="form-check-label" for="checkbox">I agree to receive updates, offers, and styling tips from <strong>Urbanix</strong>.</label>
          </div>

          <button type="submit" class="btn btn-primary w-100 p-3 fw-bold rounded">Get My Styling Advice</button>
        </form>
      </div>

       <!-- Right Side Features -->
      <div class="col-lg-4 p-5 r-form text-white">
        <h4 class="fw-bold">Why Choose Urbanix?</h4>

        <div class="row">
          <div class="col-md-12 mt-4">

            <div class="feature-box d-flex mb-4">
              <div class="icon-box rounded-3 me-3">
                <i class="fa-solid fa-clock"></i>
              </div>
              <div>
                <h6 class="fw-bold">Quick Response</h6>
                <p class="mb-0 para-form">We reply to your questions within 24 hours.</p>
              </div>
            </div>

            <div class="feature-box d-flex mb-4">
              <div class="icon-box rounded-3 me-3">
                <i class="fa-solid fa-shield-heart"></i>
              </div>
              <div>
                <h6 class="fw-bold">Satisfaction Guaranteed</h6>
                <p class="mb-0 para-form">Love our style or get helpful alternatives tailored for you.</p>
              </div>
            </div>

            <div class="feature-box d-flex mb-4">
              <div class="icon-box rounded-3 me-3">
                <i class="fa-solid fa-users"></i>
              </div>
              <div>
                <h6 class="fw-bold">Expert Stylists</h6>
                <p class="mb-0 para-form">Our team knows the latest trends and how to mix & match for every look.</p>
              </div>
            </div>

            <hr class="my-5">

            <h6 class="fw-bold mb-4">Direct Contact</h6>
            <p class="mb-1 para-form"><i class="fa-solid fa-phone me-2"></i> +1 (555) 123-4567</p>
            <p class="mb-1 para-form"><i class="fa-solid fa-envelope me-2"></i> hello@urbanix.com</p>
            <p class="mb-0 para-form"><i class="fa-solid fa-location-dot me-2"></i> San Francisco, CA</p>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>
 <!-- footerrrrrr -->
        <footer class=" pb-2 pt-5 border border-top-1 border-secondary">
          <div class="container-fluid px-5">

  <div class="d-flex justify-content-between align-items-start flex-wrap">

    <div class="mb-4">
      <div class="d-flex align-items-center gap-2">
        <h4 class="f-logo fw-bold m-0">URBANIX</h4>
      </div>

      <p class="mt-3 text-muted w-75" >
        Redefining urban fashion with pieces that fit your lifestyle
      </p>
    </div>

    
    <div class="d-flex gap-3">
      <div class="footer-icon-box d-flex justify-content-center align-items-center rounded-3"><i class="fa-brands fa-tiktok"></i></div>
      <div class="footer-icon-box d-flex justify-content-center align-items-center rounded-3"><i class="fa-brands fa-twitter"></i></div>
      <div class="footer-icon-box d-flex justify-content-center align-items-center rounded-3"><i class="fa-brands fa-facebook"></i></div>
      <div class="footer-icon-box d-flex justify-content-center align-items-center rounded-3"><i class="fa-brands fa-instagram"></i></div>
    </div>

  </div>

  <hr class="my-4 border-light">

  <div class="text-center text-muted">
    © 2025 URBANIX. All rights reserved. <br>
    Made with <i class="fa-solid fa-heart" style="color:#d9591d;"></i> for amazing SHOPPING 
  </div>

  </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
