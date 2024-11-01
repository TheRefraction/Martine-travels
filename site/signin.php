<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Martine Travels - Sign in</title>
        <link href ="css/style.css" rel="stylesheet">
    </head>
	
    <body>
        <?php include_once('header.php');?>

        <section class="login_section">
            <h1>Sign in</h1>

            <form method="post" action="process_signin.php">
                <label>
                    Email : <input type="email" name="email" class="input-field" required="required" pattern="[A-Za-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$"/>
                </label> <br>

                <label>
                    Password : <input type="password" name="password" class="input-field" required="required"  />
                </label> <br>

                <input type="submit" value="Sign in" class="submit-btn"/>
            </form>

            <p class="signup-prompt">Don't have an account? Sign up <a href="signup.php">here</a></p>
        </section>
    </body>
</html>