<!-- 
$errors = array();
try {
    $conn = new PDO("localhost", 'forum', 'forum');
} catch (PDOException $e) {
    echo ''. $e->getMessage();
}
if (isset($_POST['submit'])){
    //Deklarerar en vektor för att spara felmeddelanden
    
    $username =$_POST['username'];
    $password =$_POST['password'];
    $name =$_POST['name'];
    $email =$_POST['email'];
    $stmt = $conn->prepare('SELECT username, email FROM username = ? OR email = ?');
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        errors[] ='denna användare eller mail finns redan';
    } else { 
        $stmt = $conn->prepare("INSERT INTO 'user'('username, name, password,  email') VALUES (?,?,?,?)");
        $stmt->bind_param('ssss', $username, $name, $password, $email);
        $stmt->execute();
        $stmt-> close();
    }
    //Kontrollerar om fälten användarnamn och lösenord är tomma
    if (empty($_POST['username'])||
    empty($_POST['password']) ||
    empty($_POST['email']) ||
    empty($_POST['name'])){
        //Skapar ett felmeddelande
        $errors[] = 'Fyll i fälten för användarnamn och lösenord';
    }
}
-->