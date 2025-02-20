
<?php
function validateUser($conn, $username, $password){
    $sql="select password from user where username='{$username}'";
    $res=getForumData($conn,$sql);
    if($res != null){
        $row = $res->fetch(PDO::FETCH_ASSOC);
        return password_verify($password, $row["password"]);
}
else{
    return false;
}
}
?>