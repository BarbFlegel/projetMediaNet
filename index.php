<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<title>association medianet</title>
	<link rel="stylesheet" href="/projetmedianet/view/style.css">
</head>
<body>
<?php 
$var===1;
require("modele/User.php");
require("modele/Article.php");
require("controller/Dao.php");
$action = explode ("/",parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$action=end($action);
$existe=1;
if (isset($existeuser)) echo "bonjour".$existeuser;

if ($action=="create") {
    $nom=$_GET["nom"];
    $prenom=$_GET["prenom"];
    $datenaiss=$_GET["datenaiss"];
    $login=$_GET["login"];
    $password=$_GET["password"];
    $email=$_GET["email"];
    $utilisateur=new User($nom,$prenom,$datenaiss,$login,$password,$email);
    $dao=Dao::getPdoGsb();
    $existeuser=$dao->verifierUser($utilisateur);
    if (!$existeuser){
    $dao->ajouterUser($utilisateur);
    include("view/login.php");
    }else {
    include("view/enregistrement.php");
    }
}

if ($action=="enregistrer"){
    include("view/enregistrement.php");
}

if ($action=="login"){
    $login=$_GET["login"];
    $password=$_GET["password"];
    $dao=Dao::getPdoGsb();
    $user=$dao->getInfosUser($login, $password);
    if ($user!=null){
        $liste=$dao->getLesArticles();
        $_SESSION["iduser"]=$user->getId();
        include("view/accueil.php");
    }else{
        $existe=0;
        include("view/login.php");
    }
}

if ($action=="index.php"){
    include("view/login.php");
}

if ($action=="details"){
    $id=$_GET["id"];
    $dao=Dao::getPdoGsb();
    $article=$dao->getArticleById($id);
    if ($article!=null){
        include("view/details.php");
    }
}
if ($action=="ajouterpost"){
            
        include("view/ajouterpost.php");
}
if ($action=="insererpost"){
    $dao=Dao::getPdoGsb();
    $titre=$_GET["titre"];
    $date=$_GET["date"];
    $idauteur=$_GET["idauteur"];
    $article=$_GET["post"];
    $post=new Article($titre,$date,$idauteur,$article);
    $dao->ajouterArticle($post);
    $liste=$dao->getLesArticles();
    include("view/accueil.php");
}
if ($action=="accueil"){
    $dao=Dao::getPdoGsb();
    $liste=$dao->getLesArticles();
    include("view/accueil.php");

}
/* $dao=Dao::getPdoGsb();
 $liste=$dao->getLesUtilisateur();
 foreach($liste as $user1){
 echo "nom : ".$user1->getNom()." prenom :".$user1->getPrenom();
 }
 */
?>
</body>
</html>








