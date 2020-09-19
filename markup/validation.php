<?php
function test_input($data) {
    isset($data) ? $data = htmlspecialchars($data): $data=NULL;
    return $data;
}

function validation($pattern, $data, $error){
    (test_input($data) and preg_match($pattern, $data)) ? $res = test_input($data) : $res = "Invalid value of ".$error;
    return $res;
}
