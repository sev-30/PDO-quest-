<?php


require_once 'connec.php';
$pdo = new PDO(DSN, USER, PASS);


$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_ASSOC);

if ('POST' === $_SERVER ['REQUEST_METHOD']) // Insert into envoyé au serveur 
{
$errors = [];


$data = array_map('trim', $_POST);
var_dump($data);

$firstname = $data['firstname'];
$lastname = $data['lastname'];

/*Lorsque tu soumets le formulaire, un nouveau personnage doit être inséré dans la base de données, 
via une requête préparée. insert into = envoyer données vers serveur */

if(empty ($errors)){
    $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname);";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':firstname', $firstname, PDO::PARAM_STR);
    $statement->bindValue(':lastname', $lastname, PDO::PARAM_STR);
    $statement->execute(); // Execute a prepared request
        
header("location : index.php");
   
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FRIENDS</title>
    <link rel="stylesheet" href='style.css' type="text/css"/>
</head>
<body>
<h1>list of Friends</h1>
<ul>
<?php foreach ($friends as $friend) : ?>
<li>
<a><?= $friend ['firstname'] .' '. $friend ['lastname'] ?></a> 
</li>
<?php endforeach; ?>
</ul>


<form action="" method="POST">

   <label  for="firstname">Firstname: </label> 
         <input  type="text"  id="firstname" name="firstname" required>
    <label  for="lastname">Lastname: </label>
         <input  type="text"  id="lastname"  name="lastname" required>
     <div  class="button">
         <button  type="submit">Add your friend</button>
     </div>

     </form>
   </body>
</html>
