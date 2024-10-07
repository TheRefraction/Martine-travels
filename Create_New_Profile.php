<html>
    <head>

    </head>
    <body>
    <h1>Creation of a new account</h1>
    <form method="post" action="add_client.php">
        <label>
            FirstName : <input type="text" name="first_name" />
        </label>
        <br>
        <label>
            Name : <input type="text" name="name" />
        </label>
        <br>
        <label>
            Email : <input type="email" placeholder="email@domain.com" name="email" required="required" />
        </label>
        <br>
        <label>
            Phone number : <input type="number" placeholder="0545654751" name="phone_number" required="required" />
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
        <label>
            J'accepte de recevoir des infos et des pubs
            <input type="checkbox" name="pub" />
        </label>
        <br>
        <input type="submit" value="Submit" />
        </form>
    </body>




</html>

