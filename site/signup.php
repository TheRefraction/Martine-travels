<html>
    <head>

    </head>
    <body>
    <h1>Creation of a new account</h1>
    <form method="post" action="process_signup.php">
        <label>
            First Name : <input type="text" name="First_name" />
        </label>
        <br>
        <label>
            Last Name : <input type="text" name="Last_name" />
        </label>
        <br>
        <label>
            Email : <input type="email" placeholder="email@domain.com" name="Email" required="required" />
        </label>
        <br>
        <label>
            Phone number : <input type="number" placeholder="0545654751" name="Phone" required="required" />
        </label>
        <br>
        <label>
            Birthdate : <input type="date" name="Birth_date" required="required" />
        </label>
        <br>
        <label>
            Password : <input type="password" name="password" required="required" />
        </label>
        <br>
        <label>
            Password's Confirmation : <input type="password" name="password_confirmation" required="required" />
        </label>
        <br>
        <br>
        <input type="submit" value="Submit" />
        </form>
    </body>
</html>

