<html>
    <head>

    </head>
    <body>
    <h1>Creation of a new account</h1>
    <form method="post" action="url">
        <label>
            FirstName : <input type="text" name="prenom" />
        </label>
        <br />
        <label>
            Name : <input type="text" name="nom" />
        </label>
        <br />

        <label>
            Email : <input type="email" placeholder="email@domain.com" name="email" required="required" />
        </label>
        </br>
        <label>
            Phone number : <input type="number" placeholder="05 45 65 47 51" name="Phone number" required="required" />
        </label>
        <br />
        <label>
            Country : <input type="text" name="country" />
        </label>
        </br>
        <label>
            Password : <input type="password" name="password" required="required" />
        </label>
        </br>
        <label>
            Password's Confirmation : <input type="password" name="password" required="required" />
        </label>
        <br />
        Genre : <br />
        <label>
            <input type="radio" name="genre" /> Homme
        </label>
        <br />
        <label>
            <input type="radio" name="genre" /> Femme
        </label>
        <br />
        <label>
            <input type="radio" name="genre" /> Autre
        </label>
        <br />
        <label>
            J'accepte de recevoir des infos et des pubs
            <input type="checkbox" name="pub" />
        </label>
        <br />
        <input type="submit" value="Submit" />
        </form>
    </body>




</html>

