<?php
    require 'admin/database_exo.php';

    $nameError = $lnameError = $emailError = $passwordError = $name = $lname = $email = $password = "";
        
    if (!empty($_POST))
    {
        $name = checkInput($_POST['name']);
        $lname = checkInput($_POST['lname']);
        $email = checkInput($_POST['email']);
        $password = checkInput($_POST['password']);
        $isSuccess  = true;
        
        if(empty($name))
        {
            $nameError = "Je veux connaitre ton prénom !";
            $isSuccess = false;
        }
        if(empty($lname))
        {
            $lnameError = "Et oui je veux tout savoir. Même ton nom !";
            $isSuccess = false;
        }  
        if(empty($password))
        {
            $passwordError = "Le mot de passe doit comprendre au moins 8 cractères";
            $isSuccess = false;
        }   
        if (!IsEmail($email))
        {
            $emailError = "T'essaies de me rouler ? C'est pas un email ça";
            $isSuccess = false;
        }
        if($isSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO inscription_user (name,lname,email,password) VALUES(?, ?, ?, ?)");
            $statement->execute(array($name,$lname,$email,$password));
            Database::disconnect();
            header("Location: enregistrement.php");
        }
        
        echo json_encode($array);
    }
    function IsEmail($var)
    {
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>
<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>INSCRIPTION</title>
        <script>
            function resetFields(){
                document.getElementById('name').value="";
                document.getElementById('lname').value="";
                document.getElementById('email').value="";
                document.getElementById('password').value="";
                document.getElementById('passwordConfirm').value="";
                document.getElementById('select1').selectIndex=-1;
            }
        </script>
    </head>
    <body>
        <h1>INSCRIVEZ-VOUS</h1>
        <form id="envoie" action="" method="post" role="form">
            <fieldset>
                <legend>Nom </legend>
                    <div class="input-wrapper">
                        <label>Renseignez votre nom ici</label>
                        <div class="input-single ">
                            <input type="text" name="name" class="form-control" placeholder="Votre Nom" required="" value="" id="name" /><br>
                            <p class="comments"></p>
                        </div>
                    </div>
            </fieldset>
            
            <fieldset>
                <legend>Prénom </legend>
                <div class="input-wrapper">
                    <label>Renseignez votre prénom ici</label>
                    <div class="input-single ">
                        <input type="text" name="lname" class="form-control" placeholder="Votre Prénom" required="" value="" id="lname" /><br>
                        <p class="comments"></p>
                    </div>
                </div>
            </fieldset>
            
            <fieldset>
                <legend>Email </legend>
                <div class="input-wrapper">
                    <label>Renseignez votre nom ici</label>
                    <div class="input-single ">
                        <input type="email" name="email" class="form-control" placeholder="email&#64;example.org" required="" value="" id="email" maxlength="100" tabindex="1" /><br>
                        <p class="comments"></p>
                    </div>
                </div>
            </fieldset>
            
            <fieldset>
                <legend>Mot de passe</legend>
                <div class="input-wrapper">
                    <label>Doit comporter au moins 8 caractères et contenir au moins 1 chiffre et 1 lettre majuscule.</label>
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="input-single " id="passDiv">
                                <input type="password" name="password" class="form-control" value="" placeholder="Créer un mot de passe" required="" maxlength="32" tabindex="2" pattern="[^&#92;s]*[0-9][^&#92;s]*[A-Z][^&#92;s]*|[^&#92;s]*[A-Z][^&#92;s]*[0-9][^&#92;s]*" data-abide-validator="ntPassword" id="password" /><br>
                                <p class="comments"></p>
                            </div>
                        </div>

                        <div class="medium-6 columns">
                            <div class="input-single " id="confirmPassDiv">
                                <input type="password" name="passwordConfirm" class="form-control" value="" placeholder="Confirmer le mot de passe" required="" maxlength="32" tabindex="3" data-equalto="password" id="passwordConfirm" /><br>
                                <p class="comments"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset><br>
            <button type="button" onclick="resetFields()" id="bouttonReset" value="Reset">Envoyer</button>
        </form>
        <div id="load"></div>
    </body>
</html>