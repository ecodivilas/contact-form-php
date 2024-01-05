<?php
    include('config.php');

    $name = $email = $phonenumber = $message = '';
    $errors = array('name' => '', 'email' => '', 'phonenumber' => '', 'message' => '');

    if(isset($_POST['submit'])){

        $phonenumber = $_POST['phonenumber'];
        $message = $_POST['message'];

        if(empty($_POST['name'])){
          $errors['name'] = "Name is required <br />";
        } else {
          $name = $_POST['name'];
          if(!preg_match('/^[a-zA-Z\d\s]{8,12}$/', $name)){
            $errors['name'] = "Name must not contain special characters and atleast 8 and max is 12 <br />";
          }
        }

        if(empty($_POST['email'])){
          $errors['email'] = "Email is required <br />";
        } else {
          $email = $_POST['email'];
          if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Should be a valid email <br />";
          }
        }

        if(empty($_POST['phonenumber'])){
          $errors['phonenumber'] = "Phone number is required <br />";
        } else {
          $name = $_POST['phonenumber'];
          if(!preg_match('/^\d{11}$/', $name)){
            $errors['phonenumber'] = "Name must not contain special characters and atleast 8 and max is 12 <br />";
          }
        }

        if(empty($_POST['barangay_id'])){
          $errors['barangay_id'] = "Barangay is required <br />";
        } else {
          $barangay_id = $_POST['barangay_id'];
        }

        if(empty($_POST['message'])){
          $errors['message'] = "Message is required <br />";
        } else {
          $message = $_POST['message'];
        }

        if(!array_filter($errors)) {
          $sql = "INSERT INTO client_contacts (name, email, contact_number, barangay_id)  VALUES ('$name', '$email', '$phonenumber', '$barangay_id')";
  
          if(mysqli_query($con, $sql)) {
              // Success
              header('Location: index.php');
              // echo 'Client Info Successfully Added!';
          } else {
              echo 'query error: ' . mysqli_error($con);
          }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Form</title>
  <script type="text/javascript" src="jquery-3.3.1.min.js"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="container">
    <h2>Contact Us</h2>
    <form action="add.php" method="post">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?= $name ?>">
      <div class="error-text"><?= $errors['name']; ?></div>
      
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?= $email ?>">
      <div class="error-text"><?= $errors['email']; ?></div>

      <label for="phonenumber">Phone Number:</label>
      <input type="phonenumber" id="phonenumber" name="phonenumber" value="<?= $phonenumber ?>">
      <div class="error-text"><?= $errors['phonenumber']; ?></div>

      <label for="province">Province:</label>
      <select id="sel_province" name="province">
        <option value="">Select Province</option>

        <?php
            $province_sql = "SELECT * FROM provinces";
            $province_data = mysqli_query($con, $province_sql);

            while ($row = mysqli_fetch_assoc($province_data)) {
                    $province_id = $row['id'];
                    $province_name = $row['province_name'];
                    echo "<option value='".$province_id."'>".$province_name."</option>";
            }
        ?>

        <!-- Add more options as needed -->
      </select>

      <label for="city">City:</label>
      <select id="sel_city" name="city">
        <option value="">Select City</option>
        <!-- Add more options as needed -->
      </select>

      <label for="barangay">Barangay:</label>
      <select id="sel_barangay" name="barangay_id">
        <option value="">Select Barangay</option>
        <!-- Add more options as needed -->
      </select>
      
      <label for="message">Message:</label>
      <textarea id="message" name="message" rows="4" value="<?= $message ?>"></textarea>
      <div class="error-text"><?= $errors['message']; ?></div>

      <button name="submit" type="submit">Submit</button>
    </form>

    <!-- Scripts -->

    <script type="text/javascript">
        $(document).ready(function() {
            $("#sel_province").change(function(){
                var prov_id = $(this).val();

                $('#sel_city').find('option').not(':first').remove();
                $('#sel_barangay').find('option').not(':first').remove();
                
                $.ajax({
                    url: "getCities.php",
                    type: "post",
                    data: {prov_id:prov_id},
                    dataType: "json",
                    success: function(res){
                        
                        var len = res.length;
                        console.log(res);

                        // $("#sel_city").empty();

                        for(var i=0; i<len; i++){
                            var id = res[i]['city_id'];
                            var city_name = res[i]['city_name'];
                            console.log(city_name);
                            $("#sel_city").append("<option value='"+id+"'>"+city_name+"</option>");
                        }

                    },
                    error: function(res){
                        console.log(res.responseText);
                    }
                });
            });

            $("#sel_city").change(function(){
                var city_id = $(this).val();
                
                $('#sel_barangay').find('option').not(':first').remove();

                $.ajax({
                    url: "getCities.php",
                    type: "post",
                    data: {city_id:city_id},
                    dataType: "json",
                    success: function(res){
                        
                        var len = res.length;
                        console.log(res);

                        // $("#sel_city").empty();

                        for(var i=0; i<len; i++){
                            var id = res[i]['barangay_id'];
                            var barangay_name = res[i]['barangay_name'];
                            console.log(barangay_name);
                            $("#sel_barangay").append("<option value='"+id+"'>"+barangay_name+"</option>");
                        }

                    },
                    error: function(res){
                        console.log(res.responseText);
                    }
                });
            });
        });
    </script>
  </div>

</body>
</html>


<!-- REGEX {
    telephone: /^\d{11}$/,
    username: /^[a-z\d]{5,12}$/i,
    password: /^[\w@-]{8,20}$/,
    slug: /^[a-z\d-]{8,20}$/,
    email: /^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/
}; -->
