<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   // $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   // $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   // $number = filter_var($number, FILTER_SANITIZE_STRING);
   $reason = $_POST['reason'];
   // $reason = filter_var($reason, FILTER_SANITIZE_STRING);
   $brandName = $_POST['brandName'];
   $modelName = $_POST['modelName'];
   $modelImei = $_POST['modelImei'];
   $price = $_POST['price'];
   $address = $_POST['address'];

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ? AND brand_name= ? AND model_name = ? AND model_imei = ? AND price = ? AND address = ?");
   $select_message->execute([$name, $email, $number, $reason, $brandName, $modelName, $modelImei, $price, $address]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message, brand_name, model_name, model_imei, price, address) VALUES(?,?,?,?,?,?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $reason, $brandName, $modelName, $modelImei, $price, $address]);

      $message[] = 'sent message successfully!';

   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">

   <form action="" method="post">
      <h3>Get in touch.</h3>
      <input type="text" name="name" placeholder="enter your name" required maxlength="20" class="box">
      <input type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
      <input type="number" name="number" min="0" max="9999999999" placeholder="enter your contact number" required onkeypress="if(this.value.length == 10) return false;" class="box">
      <input type="text" name="brandName" placeholder="enter your phone brand name" required maxlength="10" class="box">
      <input type="text" name="modelName" placeholder="enter your phone model name" required maxlength="10" class="box">
      <input type="text" name="modelImei" placeholder="enter your phone's imei number" required maxlength="20" class="box">
      <input type="text" name="price" placeholder="enter your asking price" required maxlength="10" class="box">
      <textarea name="address" class="box" placeholder="enter your address" cols="30" rows="10"></textarea>
      <input type="text" name="reason" placeholder="Reason for selling" required maxlength="30" class="box">
      <input type="submit" value="Sell Phone" name="send" class="btn">
   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>