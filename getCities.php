<?php

    include "config.php";

    if(isset($_POST['prov_id'])){

        $province_id = $_POST['prov_id'];
    
        $sql = "SELECT * FROM cities WHERE province_id=$province_id";
    
        $result = mysqli_query($con, $sql);
    
        $city_response = array();
    
        while ($row = mysqli_fetch_assoc($result)) {
            $city_id = $row['id'];
            $city_name = $row['city_name'];
    
            $city_response[] = array('city_id' => $city_id, 'city_name' => $city_name);
    
        }
    
        echo json_encode($city_response);
        exit;
    }

    if(isset($_POST['city_id'])){

        $city_id = $_POST['city_id'];
    
        $sql = "SELECT * FROM barangay WHERE city_id=$city_id";
    
        $result = mysqli_query($con, $sql);
    
        $barangay_response = array();
    
        while ($row = mysqli_fetch_assoc($result)) {
            $barangay_id = $row['id'];
            $barangay_name = $row['barangay_name'];
    
            $barangay_response[] = array('barangay_id' => $barangay_id, 'barangay_name' => $barangay_name);
    
        }
    
        echo json_encode($barangay_response);
        exit;
    }

?>