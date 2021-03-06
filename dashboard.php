<?php
/************************************************************************************************************
* TIL INFORMASJON: 	                   							            *
*													    *
* I denne filen ligger det kode som er hentet og tilpasset egen løsning fra kildene nedenfor.               *
* Dette er også dokumentert under "Kommentarer til kildebruk" i rapporten og markert i selve koden.  	    *
* Grunnen til dette er basert på “best practice”  måter å programmere på.  				    *
* Vi har gjennom en rekke eksempler via dokumenterte kilder lært oss hvordan php språket fungerer. 	    *
*												            *
*											                    *
* Kilder											            *
* https://www.youtube.com/playlist?list=PLRheCL1cXHrvTkUenAc5GdEvqIpVX-2JJ				    *
* https://www.youtube.com/watch?v=OePNkDd3Yb8							            * 
* https://www.youtube.com/watch?v=cgvDMUrQ3vA							            *	 
* https://getbootstrap.com/docs/4.3/components/card/							    * 
* https://getbootstrap.com/docs/4.3/utilities/spacing/#horizontal-centering				    * 
* https://drive.google.com/file/d/1Xz-ei5uWr-ZgBzBdHBUt0-0R3z3WsOW0/view				    * 
* https://drive.google.com/file/d/1WM7zpPmlS7JFFfdn6PfsdxlT2iS5zOSF/view				    * 
* https://stackoverflow.com/questions/35931377/get-id-for-a-specific-user-in-mysql-database-in-php	    *
*												            *
* Vi har med vilje laget informasjonsboksene i koden med ulike størrelser 				    * 
* for å kunne skille dem fra hverandre. 							            *
*												            *
* Kodet og tilpasset av: Henrik Solnør Johansen, Andreas Knutsen og Anders Koo				    *
*										                            *
*************************************************************************************************************/

// ---------------------------------------------------------------------------------------------------- //
// Setter opp session og includes									//
// ---------------------------------------------------------------------------------------------------- //
include_once('db-config.php'); 	// Inkluderer bare 'db-config.php' en gang, og scriptet vil avbrytes dersom include_once-funksjonen ikke finner filen.
include('lang-config.php');		// Inkluderer oppsett for flere språk


$id = $_SESSION["id"]; 

if(!isset($_SESSION['id'])){ // Hvis session ikke er satt blir brukeren videresendt til login.php
	header('Location:login.php'); 
}

// ---------------------------------------------------------------------------------------------------- //
// Setter opp database forbindelse med spørrring							//
// ---------------------------------------------------------------------------------------------------- //

$query = "SELECT * FROM cards WHERE user_id=$id"; // Henter data fra cards tabellen hvor user_id er identisk med id til bruker i register tabellen
$query_run = mysqli_query($mysqli, $query); // mysqli_query er en metode for å utføre forbindelse med database og spørring. $mysqli hentes fra config.php

?>


<!-- ---------------------------------------------------------------------------------------------------- -->
<!-- START 												  -->
<!-- For å sette opp modal med kalender funksjon har vi hentet og tilpasset kode fra Youtube kanalen 	  -->
<!-- Funda of Web IT.  		  									  -->																	 
<!-- Kilde: 												  -->
<!--	 https://www.youtube.com/watch?v=OePNkDd3Yb8							  -->
<!--												  	  -->
<!-- Kildekode for Admin Panel PHP: 								          -->
<!--     https://drive.google.com/file/d/1Xz-ei5uWr-ZgBzBdHBUt0-0R3z3WsOW0/view				  -->
<!-- ---------------------------------------------------------------------------------------------------- -->

<!DOCTYPE html>
<html lang="en">

<?php include('includes/header.php');?> <!-- Inkluderer header.php -->

	<body>

	<?php
	include('includes/navbar.php'); ?>  <!-- Inkluderer navbar.php -->

		<div class="content-dashboard">
			<div class="container">
				<div>

<!-- -------------------------------------------------------------------------------------------------------------------- -->
<!-- START 													          -->
<!-- For å sette opp muligheter for både norsk og engelsk opppsett av vi hentet kode og tilpasset fra Youtube kanalen	  -->
<!-- Coding Passive Income: https://www.youtube.com/watch?v=cgvDMUrQ3vA						          -->
<!-- -------------------------------------------------------------------------------------------------------------------- -->				
																				<!-- Henter verdi fra et php-array(en.php/no.php) basert på verdien til $_SESSION['lang'] -->
					<button data-toggle="modal" data-target="#eexampleModal" class="btn btn-primary w-25" style="display: block; margin: 0 auto;"><?php echo $lang_button['subscriptionbtn']; ?></button>
				</div>
				<div class="row justify-content-center">
				<?php

				if(mysqli_num_rows($query_run) > 0) { // mysqli_num_rows funksjonen returnerer antall rader i databasen. Hvis mysqli_num_rows returnerer en verdi
				                              		  // som er større en 0 vil if-setningen fortsette. 

					while($row = mysqli_fetch_assoc($query_run)) { // mysqli_fetch_assoc er en funksjon som returnerer resulterende rad i en tabell og legger den i $row variabelen

					?>
<!-- -------------------------------------------------------------------------------------------------------------------- -->
<!-- START														  -->
<!-- Oppsett av cards er gjort ved hjelp av disse lenkene:							          -->
<!-- https://getbootstrap.com/docs/4.3/components/card/									  --> 
<!-- https://getbootstrap.com/docs/4.3/utilities/spacing/#horizontal-centering					          -->
<!-- -------------------------------------------------------------------------------------------------------------------- -->

					<div class="col-sm-4">
						<div class="card shadow mx-auto" style="width: 18rem;">
							<div class="card-header"><?php echo $row['description']; ?>
							</div>  
							<ul class="list-group list-group-flush">                                 
								<li class="list-group-item"><h6 class="card-text"><?php echo $lang_text['card-start-date']; ?></h6><?php echo $row['start_date']; ?></li> <!-- Henter ut start dato fra databasen  -->
								<li class="list-group-item"><h6 class="card-text"><?php echo $lang_text['card-end-date']; ?></h6><?php echo $row['end_date']; ?></li> <!-- Henter ut slutt dato fra databasen  -->
							</ul>
							
							<!-- EDIT FIELD -->
							<div class="card-body">
								<form action="edit.php" method="post" style="display:inline-block;">                                               
									<input type="hidden" name ="edit_id" value="<?php echo $row['id']; ?>"> <!-- Henter ut id dato fra databasen. Dette for å kunne identifisere spesifikt abonnement  -->
									<button class="btn btn-primary" name="edit_btn" data-toggle="modal"><?php echo $lang_button['editbtn']; ?></button> <!-- Henter verdi fra et php-array(en.php/no.php) basert på verdien til $_SESSION['lang'] -->
								</form>
								<!-- DELETE FIELD -->
								<form action="server.php" method="post" style="display:inline-block;">                                               
									<input type="hidden" name ="delete_id" value="<?php echo $row['id']; ?>"> <!-- Henter ut id dato fra databasen. Dette for å kunne identifisere spesifikt abonnement  -->
									<button class="btn btn-primary" name="delete_btn" data-toggle="modal"><?php echo $lang_button['deletebtn']; ?></button> <!-- Henter verdi fra et php-array(en.php/no.php) basert på verdien til $_SESSION['lang'] -->

								</form>    
							</div>
						</div>
					</div>

<!-- -------------------------------------------------------------------------------------------------------------------- -->
<!-- STOPP														  -->
<!-- Oppsett av cards er gjort ved hjelp av disse lenkene:								  -->
<!-- https://getbootstrap.com/docs/4.3/components/card/									  --> 
<!-- https://getbootstrap.com/docs/4.3/utilities/spacing/#horizontal-centering						  -->
<!-- -------------------------------------------------------------------------------------------------------------------- -->
				<?php } ?>
				</div>
			</div>
		</div>

				<?php
				}

				else { ?>

				<?php

					}

				?>

	<!-- -------------------------------------------------------------------- -->
	<!-- Modal for å sett inn informasjon og opprette nytt abonnement START	  -->
	<!-- -------------------------------------------------------------------- -->
		<div class="container">
			<div class="modal fade" id="eexampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"><?php echo $lang_text['card-header']; ?></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<form action="server.php" method="POST">
							<div class="modal-body">
								<div class="form-group">
									<!-- Henter verdi fra et php-array(en.php/no.php) basert på verdien til $_SESSION['lang'] -->
									<label><h6 class="card-text"><?php echo $lang_text['card-title']; ?></h6></label> 
									<input type="text" name="description" value=""  class="form-control" >
								</div>
								<div class="form-group">
									<!-- Henter verdi fra et php-array(en.php/no.php) basert på verdien til $_SESSION['lang'] -->
									<label><h6 class="card-text"><?php echo $lang_text['card-start-date']; ?></h6></label>
									<input type="date" name="start_date" value=""  class="form-control" >
								</div>
								<div class="form-group">
								    <!-- Henter verdi fra et php-array(en.php/no.php) basert på verdien til $_SESSION['lang'] -->
									<label><h6 class="card-text"><?php echo $lang_text['card-end-date']; ?></h6></label>
									<input type="date" name="end_date" value="" class="form-control">
								</div>

								<div class="modal-footer">
								   	<!-- Henter verdi fra et php-array(en.php/no.php) basert på verdien til $_SESSION['lang'] -->
									<button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo $lang_button['closebtn']; ?></button>
								    <!-- Henter verdi fra et php-array(en.php/no.php) basert på verdien til $_SESSION['lang'] -->
									<button type="submit" name="registerbtn" class="btn btn-primary"><?php echo $lang_button['savebtn']; ?></button>
								</div>

								
	<!-- -------------------------------------------------------------------- -->
	<!-- Modal for å sett inn informasjon og opprette nytt abonnement START   -->
	<!-- -------------------------------------------------------------------- -->
								
<!-- -------------------------------------------------------------------------------------------------------------------- -->
<!-- STOPP														  -->
<!-- For å sette opp muligheter for både norsk og engelsk opppsett av vi hentet kode og tilpasset fra Youtube kanalen	  -->
<!-- Coding Passive Income: https://www.youtube.com/watch?v=cgvDMUrQ3vA							  -->
<!-- -------------------------------------------------------------------------------------------------------------------- -->	

							</div>
					</form>
				</div>
			</div>
		</div>
	</div>               

<!-- ---------------------------------------------------------------------------------------------------- -->
<!-- STOPP												  -->
<!-- For å sette opp modal med kalender funksjon har vi hentet og tilpasset kode fra Youtube kanalen	  -->
<!-- Funda of Web IT.											  -->																	 
<!-- Kilde:												  -->
<!--	 https://www.youtube.com/watch?v=OePNkDd3Yb8							  -->
<!--													  -->
<!-- Kildekode for Admin Panel PHP:								          -->
<!--     https://drive.google.com/file/d/1Xz-ei5uWr-ZgBzBdHBUt0-0R3z3WsOW0/view				  -->
<!-- ---------------------------------------------------------------------------------------------------- -->


<!-- ---------------------------------------------------------------------------------------------------- 
Footer START
----------------------------------------------------------------------------------------------------- -->

<?php include('includes/footer.php');?> <!-- Inkluderer footer.php -->

<!-- ---------------------------------------------------------------------------------------------------- 
Footer STOPP
----------------------------------------------------------------------------------------------------- -->

</body> 
</html>
<!-- ---------------------------------------------------------------------------------------------------- 
Henter script filer (JS, JQUERY, BOOTSTRAP)
----------------------------------------------------------------------------------------------------- -->

<?php include('includes/scripts.php');?>

<!-- ---------------------------------------------------------------------------------------------------- 
Henter script filer (JS, JQUERY, BOOTSTRAP)
----------------------------------------------------------------------------------------------------- -->
