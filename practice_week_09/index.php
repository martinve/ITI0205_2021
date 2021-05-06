<!DOCTYPE html>
<html>
    <head>
        <title>My Title</title>
        <meta charset="utf-8">

        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    </head>
    <body>
        <?php include "menu.php"; ?>

        <div class="container" role="main">
            <h1>Minu Teenus :)</h1>
            <form method="post">
                <fieldset>
                    <caption>Sinu isikuandmed:</caption>

                    <label for="first_name">Eesnimi:</label>
                    <input type="text" id="first_name" name="first_name" aria-required="true" required="required">

                    <input type="submit" value="Submit Name" aria-disabled="true" disabled="disabled">

                </fieldset>
            </form>

            <a class="btn btn-primary" href="#" role="button">Nupp</a>

        </div>

    </body>
</html>