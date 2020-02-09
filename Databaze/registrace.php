<?php

require_once "config.php";

$jmeno = $_POST["jmeno"];
$heslo = $_POST["heslo"];
$heslo_znova = $_POST["heslo_znova"];

$spojeni = mysqli_connect(dbhost, dbuser, dbpass, dbname);
$data = mysqli_query($spojeni, "SELECT * FROM prihlaseni WHERE jmeno = '$jmeno'");

if(mysqli_num_rows($data) == 0)
{
   if ($heslo == $heslo_znova and $heslo != null)
    {
       $heslo = password_hash($heslo, PASSWORD_DEFAULT);
       mysqli_query($spojeni, "INSERT INTO prihlaseni (jmeno,heslo)VALUES('$jmeno','$heslo')");  
       echo "<p>Účet byl vytvořen.</p>";
       $data = mysqli_query($spojeni, "SELECT * FROM prihlaseni WHERE jmeno = '$jmeno'");
       $uzivatel = mysqli_fetch_assoc($data);
       session_start();
       $_SESSION["prihlaseny_uzivatel"] = $uzivatel["jmeno"];
       header("location:profil.php");
    }

   else
   {
    echo "<p>Uživateli se neshodují hesla.</p>";
   }

}

else
{

   echo "<p>Uživatel se jménem <b>$jmeno</b> již existuje.</p>";

}