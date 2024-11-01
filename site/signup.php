<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Martine Travels - Sign up</title>
        <link href ="css/style.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once('header.php');?>

        <section class=login_section>
            <h1>Sign up</h1>

            <form method="post" action="process_signup.php" class="login-form">
                <label>
                    First name : <input type="text" name="fname" class="input-field" required="required" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\-]+" title ="Must contain only letters or hyphens"/>
                </label> <br>

                <label>
                    Last name : <input type="text" name="lname" class="input-field" required="required" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\-]+" title ="Must contain only letters or hyphens"/>
                </label> <br>

                <label>
                    Email : <input type="email" placeholder="email@domain.com" name="email" class="input-field" required="required" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$"/>
                </label> <br>

                <label>
                    Birthdate : <input type="date" id="birthday" name="birthday" class="input-field" required="required" min="1900-01-01"/>
                </label> <br>

                <label>
                    Phone number : <input type="tel" placeholder="0545654751" name="phone" class="input-field" required="required"/>
                </label> <br>

                <label>
                    Password : <input type="password" name="passwd" class="input-field" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,128}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"/>
                </label> <br>

                <label>
                    Confirm password : <input type="password" name="passwd_conf" class="input-field" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,128}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"/>
                </label> <br>

                <br>
                <input type="submit" value="Sign up"/>
            </form>
        </section>

        <script>
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();

            if (dd < 10) {
                dd = '0' + dd;
            }

            if (mm < 10) {
                mm = '0' + mm;
            }

            today = yyyy + '-' + mm + '-' + dd;
            document.getElementById("birthday").setAttribute("max", today);
        </script>
    </body>
</html>