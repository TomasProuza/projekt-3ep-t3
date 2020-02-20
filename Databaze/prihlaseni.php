<?php
require_once "config.php";
$jmeno = $_POST["jmeno"];
$heslo = $_POST["heslo"];

$spojeni = mysqli_connect(dbhost, dbuser, dbpass, dbname);
$data = mysqli_query($spojeni, "SELECT * FROM stranka WHERE jmeno = '$jmeno'");

if(mysqli_num_rows($data) == 0)
{
    echo "<p>Uživatel se jménem <b>$jmeno</b> neexistuje.</p>";
}
else
{
    echo "<p>Uživatel se jménem <b>$jmeno</b> existuje.</p>";
    $uzivatel = mysqli_fetch_assoc($data);
    if(password_verify($heslo, $uzivatel["heslo"]))
    {
        echo "<p>Zadané heslo je <b>správně</b>.</p>";
        session_start();
        $_SESSION["prihlaseny_uzivatel"] = $uzivatel["id"];
        $_SESSION["prihlaseny_uzivatel_jmeno"] = $jmeno;
        header("location:profil.php");
    }
    else
    {
        echo "<p>Zadané heslo je <b>špatně</b>.</p>";
    }
}
mysqli_close($spojeni);