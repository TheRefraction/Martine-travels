<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Martine Travels - Login</title>
    </head>
	
    <body>
        <h1> Log into your Martine Travels account</h1>
        <form method="post" action="process_login.php">
            <label>
                Email : <input type="text" name="login" />
            </label>
            <br />
            <label>
                Password : <input type="password" name="password" required="required" />
            </label>
            <br />
            <input type="submit" value="Submit" />
        </form>
        <p>New client ? <a href="signup.php"> Create an account </a></p>
    </body>

</html>
