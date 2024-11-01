<?php
    include("connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $phone = $_POST['phone'];
    $passwd = $_POST['passwd'];
    $passwd_conf = $_POST['passwd_conf'];

    if ($passwd <> $passwd_conf) {
        echo "Passwords are not the same.\n";
        echo " Please try again <a href='signup.html'>Here</a>.";
    } else {
        $bdd = get_dbhandle();

        $req = $bdd->prepare("SELECT * FROM User WHERE Email = ?");
        $req->execute([$email]);
        $data = $req->fetch();

        if (!empty($data)) {
            echo "Email address already in use!\nPlease try again <a href='signup.html'>Here</a>.";
            exit();
        }

        $req = $bdd->prepare("SELECT * FROM User WHERE Phone = ?");
        $req->execute([$phone]);
        $data = $req->fetch();

        if (!empty($data)) {
            echo "Phone number already in use!\nPlease try again <a href='signup.html'>Here</a>.";
            exit();
        }

        $passwd_conf = password_hash($passwd, PASSWORD_BCRYPT);

        $req = $bdd->prepare("INSERT INTO User(First_name, Last_name, Email, Password, Phone, Birth_date) VALUES (?,?,?,?,?,?);");
        $req->execute([$fname, $lname, $email, $passwd_conf, $phone, $birthday]);

        echo "Registration successful.\n";
        echo "You may now <a href='signin.html'>log into your account</a>.";
    }
    die();
}
?>