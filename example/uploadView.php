<!DOCTYPE html>
<html>
<head>
		<title></title>
		<meta charset="UTF-8"></meta>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script type="text/javascript" src="js/jquery-2.1.4.js"></script>
		<script type="text/javascript" src="js/uploadphoto.js"></script>
</head>
	<body>
		<h1> Upload de fichier </h1>

		<?php

			if(isset($_POST['ch_dossier'])){
				include('../src/Upload.php');

				$file_ary = array();
				$file_count = count($_FILES['ch_file']['name']);
				$file_keys = array_keys($_FILES['ch_file']);

				for ($i=0; $i<$file_count; $i++) {
						foreach ($file_keys as $key) {
								$file_ary[$i][$key] = $_FILES['ch_file'][$key][$i];
						}
				}
				//$fileAllExtension= array('pdf', 'png', 'jpeg', 'jpg');


				foreach ($file_ary as $file) {
					$upload = new Upload($file['name'],$file['tmp_name'],$file['size'],$_POST['ch_size'],$file['type'],$_POST['ch_dossier'],$_POST['ch_rectangle_height'],$_POST['ch_rectangle_width'],$_POST['ch_carre_dim'],$_POST['ch_rectangle'],$_POST['ch_form'],$_POST['ch_ext'],$_POST['ch_custom_name']);
					$logs = $upload->getLogs();
					echo $logs;
					echo "<a href='../images/'>Accéder au dossier images contenant l'upload</a>";
				}


			}
		?>

		<div class="well">
		<form method="post" action="" id="myForm" enctype="multipart/form-data">

				<label for="ch_file"><b>Fichier :</b></label><br />
				<input type="file" name="ch_file[]" id="mon_fichier" required/><br />
				<div id="input-bloc"></div>
				<span class="glyphicon glyphicon-plus" id="plus" aria-hidden="true"></span>
				<span class="glyphicon glyphicon-minus" id="moins" aria-hidden="true"></span>
				<p id="text-plus"> Ajouter plus de photos </p>
				<div class="clear"></div>

				<p><b>Nom du fichier (par défaut une chaine de caractères aléatoire)</b></p>
					<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1">L</span>
					  <input type="text" name="ch_custom_name" class="form-control" placeholder="par exemple avatar-jean" aria-describedby="basic-addon1">
					</div>

				<p>	<b>Quelle forme voulez-vous comme images finales ?</b></p>
				<label class="radio-inline"><input type="radio" class="ch_rectangle" name="ch_rectangle" value="carre">Carré</label>
				<label class="radio-inline"><input type="radio" class="ch_rectangle" name="ch_rectangle" value="rectangle">Rectangle</label>

				<div id="ch_carre_dim">

					<p><b>De quelle taille voulez-vous l'image finale ?</b></p>
					<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1">C</span>
					  <input type="number" name="ch_carre_dim" class="form-control" placeholder="Dimension d'un côté" aria-describedby="basic-addon1">
					</div>

					<p>	<b>Si votre image est en paysage, voulez vous le rognage de l'image : </b></p>
					<label class="radio-inline"><input type="radio" class="ch_form" name="ch_form" value="gauche" checked="checked">A gauche</label>
					<label class="radio-inline"><input type="radio" class="ch_form" name="ch_form" value="centre">Centré</label>
					<label class="radio-inline"><input type="radio" class="ch_form" name="ch_form" value="droite">A droite</label>

				<p>	<b>Si votre image est en portrait, voulez vous le rognage de l'image : </b></p>
					<label class="radio-inline"><input type="radio" class="ch_form2" name="ch_form" value="haut">En haut</label>
					<label class="radio-inline"><input type="radio" class="ch_form2" name="ch_form" value="centre2">Centré</label>
					<label class="radio-inline"><input type="radio" class="ch_form2" name="ch_form" value="bas">En bas</label>

				</div>

				<div id="ch_rectangle_dim">

					<p><b>Si l'image est en format portrait, quelle est la hauteur que vous voulez qu'elle ait?</b></p>
					<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1">L</span>
					  <input type="number" name="ch_rectangle_height" class="form-control" placeholder="hauteur" aria-describedby="basic-addon1">
					</div>

					<p><b>Si l'image est en format paysage, quelle est la largeur que vous voulez qu'elle ait?</b></p>
					<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1">l</span>
					  <input type="number" name="ch_rectangle_width" class="form-control" placeholder="largeur" aria-describedby="basic-addon1">
					</div>

				</div>

				<p><b>Dans quel dossier voulez-vous uploader les images ? (indiquez le chemin) </b></p>
				<div class="input-group">
				  <span class="input-group-addon" id="basic-addon1">l</span>
				  <input type="text" name="ch_dossier" class="form-control" placeholder="../images pour l'exemple" aria-describedby="basic-addon1" >
				</div>

				<p><b>Taille Maximale de la pièce jointe</b></p>
					<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1">L</span>
					  <input type="number" name="ch_size" class="form-control" placeholder="taille en octets" aria-describedby="basic-addon1">
					</div>

				<p><b>Formats de fichier autorisés (séparer par une virgule)</b></p>
				<div class="input-group">
				  <span class="input-group-addon" id="basic-addon1">L</span>
				  <input type="text" name="ch_ext" class="form-control" placeholder="extension autorisés" aria-describedby="basic-addon1">
				</div>

				<input type="submit" class="btn-primary" name="submit" value="Uploader" />

		</form>
		</div>
	</body>
</html>
