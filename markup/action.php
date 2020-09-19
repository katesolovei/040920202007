<?php

include 'validation.php';
include 'config.php';

$address = '';
$address_array = [];
if($_POST['submit']){
    $addr_name = test_input($_POST['addr_name']);
    $city = test_input($_POST['city']);
    $area = test_input($_POST['area']);
    $street = test_input($_POST['street']);
    $house = test_input($_POST['house']);
    $add_info = test_input($_POST['add_info']);
    saveAddress($addr_name, $city, $area, $street, $house, $add_info);
    $address = getAddress();
    $address_array = getAddrName();
} else{
    $address = '';
    $address_array = [];
}
require_once('user_office_address.php');

// Save user address to DataBAse
function saveAddress($name, $city, $area, $street, $house, $info){
    $link = connection();

    $query = "INSERT INTO addresses(addr_name, city, area, street, house, add_info) VALUES ('$name','$city','$area','$street','$house','$info')";
    $res =  mysqli_query($link, $query);

    if(!$res){
        print("Something wrong");
    } 
}

// Get full user Address
function getAddress(){
    $link = connection();
    $addr_name = getAddrName();
    $result[] = '';

    foreach ($addr_name as $key=>$addr){
        $query = "SELECT city, area, street, house, add_info FROM addresses WHERE id = '$key'";
        $res = mysqli_query($link, $query);
        $row = mysqli_fetch_array($res);
        if($res){
            $result[$key] = $row['city'].", ".$row['area'].", ".$row['street'].", ".$row['house']."<br>".$row['add_info']."<br>";
        }
    }
    return $result;
}

// Get user Address Name and Id
function getAddrName(){
    $link = connection();

    $query = "SELECT id, addr_name FROM addresses";
    $res = mysqli_query($link, $query);

    if($res){
        while ($row = mysqli_fetch_array($res)) {
            $row_name[$row['id']] = $row['addr_name'];
        }
        asort($row_name);
        return $row_name;
    } else{
        print("Something wrong");
    }
}

// Connection to DataBase
function connection(){
    $host = DB_HOST;
    $user = DB_USER;
    $pass = DB_PASS;
    $db_name = DB_NAME;

    $link = mysqli_connect($host, $user, $pass, $db_name);

    if (!$link){
        $ans = "Error connection to MySQL " . mysqli_connect_error();
    }
    else {
        $ans = $link;
    }

    return $ans;
}