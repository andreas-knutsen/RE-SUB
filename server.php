<?php
/************************************************************************************************************
* TIL INFORMASJON:                                                                                          * 
*                                                                                                           *    
* I denne filen ligger det gjenbrukt og tilpasset kode som er funnet på linkene oppsummert under.           *
* Dette er også dokumentert under kildebruk i rapporten.                                                    * 
* Grunnen til dette er basert på “best practice”  måter å programmere på.                                   *
* Vi har gjennom en rekke eksempler lært oss hvordan php språket fungerer.                                  *
* Vi ser først på en demo av hvordan et eksempel virker,  koder oss gjennom guiden for å lære hva som skjer.* 
* Etter dette gjør vi en vurdering om å bruke, tilpasse og implementere eksempelet i vår kode eller ikke.   *
*                                                                                                           *
* Kilde:                                                                                                    * 
* https://www.youtube.com/playlist?list=PLRheCL1cXHrvTkUenAc5GdEvqIpVX-2JJ                                  *
*                                                                                                           *
************************************************************************************************************/ 

// Medlemmer som har bidratt: Anders Koo

// --------------------------------------------------------------------------------------------------//
// START                                                                                             //
// Alle CRUD operasjonene har vi lært oss via eksempler fra Youtube kanalen Funda Of Web IT.         //
// Denne koden er hentet fra og tilpasset egen løsning fra denne Youtube kanalen, part 1-6           //
// Kilde: https://www.youtube.com/playlist?list=PLRheCL1cXHrvTkUenAc5GdEvqIpVX-2JJ                   //
// --------------------------------------------------------------------------------------------------//

// ----------------------------------------------------------------------------------------------------
// Oppretter unik session for bruker
// ----------------------------------------------------------------------------------------------------

session_start();

// ----------------------------------------------------------------------------------------------------
// Setter opp forbindelse med databasen
// ----------------------------------------------------------------------------------------------------

include('db-config.php'); // Inkluderer db-config.php
if(isset($_POST['registerbtn'])) { // Sjekker at variabel er deklarert og at registerbtn knappen er klikket på 
    // Informasjon om abonnement

    $description = mysqli_real_escape_string($mysqli, $_POST['description']);   // Sjekker at variabel er deklarert og sikrer mot SQL injection
    $start_date = mysqli_real_escape_string($mysqli, $_POST['start_date']);     // Sjekker at variabel er deklarert og sikrer mot SQL injection
    $end_date =  mysqli_real_escape_string($mysqli, $_POST['end_date']);         // Sjekker at variabel er deklarert og sikrer mot SQL injection
    $user_id = $_SESSION['id']; // Oppretter user_id variabel og gir den verdien id fra session. 


    // ----------------------------------------------------------------------------------------------------
    // Setter opp spørrevariabel for registrering av abonnement
    // ----------------------------------------------------------------------------------------------------

    // Spørring som setter inn nytt abonnement i databasen
    $queryReg = "INSERT INTO cards (description, start_date, end_date, user_id) VALUES ('$description', '$start_date','$end_date', '$user_id')"; //  Spørring som setter inn data i databasen
    $queryDB = mysqli_query($mysqli, $queryReg); // mysqli_query er en funksjon som utfører spørring mot databasen


    // Om spørringen er vellyket blir bruker videresendt tilbake til dashbord
    if($queryDB) {   

        header('Location: dashboard.php');    

    } else{
        // Hvis ikke blir det presentert en feilmelding
        echo "Something went wrong/Noe gikk galt";
    }

} 



// ----------------------------------------------------------------------------------------------------
// Redigeringsknapp
// ----------------------------------------------------------------------------------------------------

if(isset($_POST['edit_btn'])) { // Sjekker at variabel er deklarert og at edit_btn knappen er klikket på 
    $id = $_POST['edit_id'];    // Sjekker at variabel er deklarert
    $queryReg = "SELECT * FROM cards WHERE id='$id' ";  // Spørring som henter spesifikk abonnement fra databasen
    $queryDB = mysqli_query($mysqli , $query);       // Utfører spørring mot databasen
}

// ----------------------------------------------------------------------------------------------------
// Oppdateringsknapp
// ----------------------------------------------------------------------------------------------------
if(isset($_POST['updatebtn'])) {    // Sjekker at variabel er deklarert og at updatebtn knappen er klikket på 
    $id = $_POST['edit_id'];        // Sjekker at variabel er deklarert
   
   // Informasjon om abonnement
    $description = mysqli_real_escape_string($mysqli , $_POST['edit_description']);   // Sjekker at variabel er deklarert og sikrer mot SQL injection
    $start_date = mysqli_real_escape_string($mysqli , $_POST['edit_date_from']);      // Sjekker at variabel er deklarert og sikrer mot SQL injection
    $end_date = mysqli_real_escape_string($mysqli , $_POST['edit_date_to']);          // Sjekker at variabel er deklarert og sikrer mot SQL injection

    // Spørring som oppdaterer spesifikt abonnement i databasen
    $queryEdit = "UPDATE cards SET description='$description', start_date='$start_date', end_date='$end_date' WHERE id='$id' ";
    $queryDB = mysqli_query($mysqli , $queryEdit); // mysqli_query er en funksjon som utfører spørring mot databasen

    // Om spørringen er vellyket blir bruker videresendt tilbake til dashbord
    if($queryDB) {

        header('Location: dashboard.php');

    } else{
        // Hvis ikke blir det presentert en feilmelding
        echo "Something went wrong/Noe gikk galt";
    }
    

}


// ----------------------------------------------------------------------------------------------------
// Sletteknapp
// ----------------------------------------------------------------------------------------------------
if(isset($_POST['delete_btn'])) { // Sjekker at variabel er deklarert og at updatebtn knappen er klikket på 
    $id = $_POST['delete_id'];  // Sjekker at variabel er deklarert

    $queryDelete = "DELETE FROM cards WHERE id='$id'";  // Spørring som sletter spesifikt abonnement fra databasen
    $queryDB = mysqli_query($mysqli , $queryDelete); // mysqli_query er en funksjon som utfører spørring mot databasen

    // Om spørringen er vellyket blir bruker videresendt tilbake til dashbord
    if($queryDB) {

        header('Location: dashboard.php');
        
    }  else{
        // Hvis ikke blir det presentert en feilmelding
        echo "Something went wrong/Noe gikk galt";
    }

}

// --------------------------------------------------------------------------------------------------//
// STOPP                                                                                             //
// Alle CRUD operasjonene har vi lært oss via eksempler fra Youtube kanalen Funda Of Web IT.         //
// Denne koden er hentet fra og tilpasset egen løsning fra denne Youtube kanalen, part 1-6           //
// --------------------------------------------------------------------------------------------------//
?>