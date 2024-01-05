<?php
    include('config.php');

    if(isset($_POST['submit'])){

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $barangay_id = $_POST['barangay_id'];

        // echo $name . $email . $phonenumber . $barangay_id;

        $sql = "INSERT INTO client_contacts (name, email, contact_number, barangay_id)  VALUES ('$name', '$email', '$phonenumber', '$barangay_id') RETURN *";

        if(mysqli_query($con, $sql)) {
            // Success
            header('Location: index.php');
            // echo 'Client Info Successfully Added!';
        } else {
            echo 'query error: ' . mysqli_error($con);
        }

        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      background-color: #f4f4f4;
    }

    .container {
      max-width: 600px;
      margin: 20px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #333;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-bottom: 8px;
      font-weight: bold;
    }

    input, textarea {
      padding: 10px;
      margin-bottom: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      width: 100%;
    }

    button {
      background-color: #4caf50;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background-color: #45a049;
    }

    select {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        letter-spacing: 1px;
        margin-bottom: 15px;
    }
  </style>
  <title>Contact Form</title>
  <script type="text/javascript" src="jquery-3.3.1.min.js"></script>
</head>
<body>

  <div class="container">
    <h2>Contact Us</h2>
    <form action="add.php" method="post">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>
      
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="phonenumber">Phone Number:</label>
      <input type="phonenumber" id="phonenumber" name="phonenumber" required>

      <label for="province">Province:</label>
      <select id="sel_province" name="province" required>
        <option value="0">Select Province</option>

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
      <select id="sel_city" name="city" required>
        <option value="0">Select City</option>
        <!-- Add more options as needed -->
      </select>

      <label for="barangay">Barangay:</label>
      <select id="sel_barangay" name="barangay_id" required>
        <option value="0">Select Barangay</option>
        <!-- Add more options as needed -->
      </select>
      
      <label for="message">Message:</label>
      <textarea id="message" name="message" rows="4" required></textarea>

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