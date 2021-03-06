<?php

/**************************************************************************************************************
*  TIL INFORMASJON:                                                                                           *
*                                                                                                             *
* I denne filen ligger det kode vi har bygget videre på fra Tutorials Class: PHP Simple Login                 * 
* and Registration Script og tilpasset egen løsning fra kildene nedenfor.                                     * 
* Dette er også dokumentert under "Kommentarer til kildebruk" i rapporten og markert i selve koden.           *
* Grunnen til dette er basert på “best practice”  måter å programmere på.                                     *
* Vi har gjennom en rekke eksempler via dokumenterte kilder lært oss hvordan php språket fungerer. 	      *
*                                                                                                             *
* Kilder:                                                                                                     * 
*                                                                                                             * 
*  https://www.youtube.com/watch?v=3bGDe0rbImY&t=635s                                                         *
*  https://gitlab.com/tutorialsclass/php-simple-login-registration-script                                     * 
*  https://getbootstrap.com/docs/4.0/components/buttons/#button-tags                                          *
*  https://stackoverflow.com/questions/35931377/get-id-for-a-specific-user-in-mysql-database-in-php           * 
*  https://drive.google.com/file/d/1WM7zpPmlS7JFFfdn6PfsdxlT2iS5zOSF/view                                     * 
*  https://www.youtube.com/watch?v=cgvDMUrQ3vA                                                                * 
*                                                                                                             *
*                                                                                                             *
* Kodet og tilpasset av  Henrik Solnør Johansen, Andreas Knutsen og Anders Koo                                *
*                                                                                                             *
**************************************************************************************************************/

include('lang-config.php'); // Inkluderer oppsett for flere språk 
ob_start();                 // Skrur på output buffering (forhindrer header warning)
?>  

<!DOCTYPE html>
<html lang="en">

        
    <?php include('includes/header_login.php');?> <!-- Inkluderer header_login.php -->
    <body>
        <form class="form-signin text-center" id="my_form" action="login.php" method="POST" name="form1">
            <h1 class="logo_title">re:sub</h1>
            <div class="form-group">
            <img class="image_login" src="other/logo/logoSmall.png" alt="">
                <!-- Henter verdi fra et php-array(en.php/no.php) basert på verdien til $_SESSION['lang'] -->
                <input type="text" placeholder="<?php echo $lang_input['input-email']; ?>" name="email" class="">
                <!-- Henter verdi fra et php-array(en.php/no.php) basert på verdien til $_SESSION['lang'] -->
                <input type="password" placeholder="<?php echo $lang_input['input-password']; ?>" name="password" class="">
            </div>
            <!-- /* https://getbootstrap.com/docs/4.0/components/buttons/#button-tags */ -->
            <button class="btn btn-primary w-100" name="loginbtn"><?php echo $lang_button['loginbtn']; ?></button>
            <?php

                // Sjekker om session status er deklarert og ikke er en tom string
                if(isset($_SESSION['status']) && $_SESSION['status'] !='') {
                    // Viser info melding til bruker
                    echo '<h6 class="bg-warning text-white"> '.$_SESSION['status'].' </h6>';
                    // Resetter SESSION status variaber
                    unset($_SESSION['status']);
                // Sjekker om session status er deklarert og ikke er en tom string
                } else if (isset($_SESSION['success']) && $_SESSION['success'] !='') {
                    // Viser info melding til bruker
                    echo '<h6 class="bg-success text-white"> '.$_SESSION['success'].' </h6>';
                    // Resetter SESSION success variaber
                    unset($_SESSION['success']);
                }
            ?>
        </form>

    </body>

<?php include('includes/scripts.php');?><!-- Inkluderer scripts.php -->

</html>


<?php
include_once('db-config.php'); // Inkluderer bare 'db-config.php' en gang, og scriptet vil avbrytes dersom include_once-funksjonen ikke finner filen.

    if (isset($_POST['loginbtn'])) { //Sjekker at variabel er deklarert og at knappen er klikket på
        $email    = mysqli_real_escape_string($mysqli, $_POST['email']);    //Sjekker at email er deklarert og sikrer mot sql injection
        $password = mysqli_real_escape_string($mysqli, $_POST['password']); //Sjekker at password er deklarert og sikrer mot sql injection

//------------------------------------------------------------------------------------------------------------------//
// START                                                                                                            //
// Denne koden er hentet fra og tilpasset egen løsning fra Youtube kanalen Coding Passive income.                   //
// Vi lærte hvordan man kan sammenligne input passord fra login skjema til å matche hashet passord i databasen.     //
// Dette for å sjekke at korrekt bruker med korrekt password ble logget inn.                                        //
//                                                                                                                  //
// Kilde: https://www.youtube.com/watch?v=3bGDe0rbImY&t=635s                                                        //
//                                                                                                                  //
// Denne kilden er brukt for å finne ut av hvordan man legger id fra register tabellen inn i en session variabel    //
// Kilde: https://stackoverflow.com/questions/35931377/get-id-for-a-specific-user-in-mysql-database-in-php          //
//------------------------------------------------------------------------------------------------------------------//

// Kodet og tilpasset av: Anders Koo og Andeas Knutsen START 

        // mysqli_query funksjon som utfører SELECT spørring mot database og sjekker om email matcher med input
        $sql = mysqli_query($mysqli, "SELECT id, password FROM register WHERE email='$email'"); 
        $user_matced = mysqli_num_rows($sql); // mysqli_num_rows funksjon som enter ut raden som matcher med email og legger denne i en variabel

        if ($user_matced > 0) { // Hvis user_matced returerner en verdi større en 0 fortsetter koden.
            $data = mysqli_fetch_array($sql); // Legger SELECT spørringen i tabell ved hjelp av funksjonen mysqli_fetch_array. Deretter legges denne spørringen i en variabel

//------------------------------------------------------------------------------------------------------------------//
// Denne kilden er brukt for å finne ut av hvordan man legger id fra register tabellen inn i en session variabel    //
// Kilde: https://stackoverflow.com/questions/35931377/get-id-for-a-specific-user-in-mysql-database-in-php          //
//------------------------------------------------------------------------------------------------------------------//
                
            $id = $data['id'];  // Henter ut bruker-id fra databasen og legger den i en variabel
            $_SESSION['id'] = $id;  // Legger id-variabelen inn i en session variabel. Dette for å identifisere bruker
            
        
            //password_verify er en funksjon som sammenligner input password med hashet passord i databasen fra $data variabel
            if(password_verify($password, $data['password'])) { 
                header('Location:dashboard.php'); // Header er en funksjon som viderefører brukeren til dashboard
                exit(); // exit er en funksjon som terminerer operasjonen 

            } else 
                header('Location:login.php');  // Header er en funksjon som viderefører brukeren til login
                $_SESSION['status'] = "Email or password is incorrect"; //Feilmelding til bruker
                exit(); // exit er en funksjon som terminerer operasjonen

        } else {
            header('Location:login.php'); // Header er en funksjon som viderefører brukeren til login
            $_SESSION['status'] = "Fields cannot be empty"; //Feilmelding til bruke
            exit(); // exit er en funksjon som terminerer operasjonen 
        }
    }
    //Kodet og tilpasset av: Anders Koo og Andeas Knutsen STOPP 


//------------------------------------------------------------------------------------------------------------------//
// STOPP                                                                                                            //
// Denne koden er hentet fra og tilpasset egen løsning fra Youtube kanalen Coding Passive income.                   //
// Vi lærte hvordan man kan sammenligne input passord fra login skjema til å matche hashet passord i databasen.     //
// Dette for å sjekke at korrekt bruker med korrekt password ble logget inn.                                        //
//                                                                                                                  //
// Kilde: https://www.youtube.com/watch?v=3bGDe0rbImY&t=635s                                                        //
//                                                                                                                  //
// Denne kilden er brukt for å finne ut av hvordan man legger id fra register tabellen inn i en session variabel    //
// Kilde: https://stackoverflow.com/questions/35931377/get-id-for-a-specific-user-in-mysql-database-in-php          //
//------------------------------------------------------------------------------------------------------------------//

ob_end_flush(); // Skrur av output buffering (forhindrer header warning)
?>
