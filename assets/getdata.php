
<?php
function getForumData($conn, $sql){
    $result = $conn -> query($sql);

    if ($result -> num_rows > 0){
        $conn=null;
        return $result;
}
return null;
}
function insertData($conn, $sql){
    $result = $conn -> query($sql);
    if ($result -> num_rows > 0){
        $conn=null;
        return $result;

}
return 0;
}

function updateData($conn, $sql){
    if($conn->query($sql)){
        return 1;
}
return 0;
}
?>