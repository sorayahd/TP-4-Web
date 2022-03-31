
<P>
<B>DEBUTTTTTT DU PROCESSUS :</B>
<BR>
<?php echo " ", date ("h:i:s"); ?>
</P>
<?php

// limite le temps maximal d'execution du script à 500 seconde 
set_time_limit (500);
$path= "docs";

//  fonction qui permet d'explorer un répertoire
explorerDir($path);

function explorerDir($path)
{
			
	//ouvrir le dossier et pose un pointeur dessus on lui foursnissant le chemin vers "docs"
	//un repertoire (parents) /docs

	
	$folder = opendir($path);

	//la fonction renvoie le nom de l’entrée suivante dans un répertoire. ou un false si ya plus de dossier
	while($entree = readdir($folder))
	{	
		
		//on ingore les valeur . et .. 
		if($entree != "." && $entree != "..")
		{
			$file = $path."/".$entree;
			//vérifie si le fichier est bien un dossier
			if(is_dir($path."/".$entree)) 
			{

				//sauvgarde le chemin path  de le fichier parent (sav_path)
				$sav_path = $path; 

				//ajout le nom du dossier fils au path
				$path .= "/".$entree; 

				//effectue un appel récursive à la fonction exploreDir avec le nouveau chemin path	
				
						echo "<img src=./icons/folder.JPG width='20px'  />".$path."<br>";
					print_files($path);
			
				
				explorerDir($path); //docs/sub1 2 //docs/sub1/sub1_2
				
				// écrase le path avec le path parent original
				$path = $sav_path; // docs // //docs/sub1
				
			}
			else
			{
				
//Dans ce cas on se retrouve avec un path qui n'est pas un dossier mais un fichier de type docs/fichier.extension
				$path_source = $path."/".$entree;				
				require './config.php';
				$extension = pathinfo($path_source, PATHINFO_EXTENSION);
				list($width, $height, $type, $attr) = getimagesize($path_source);
				$imagesize = $width*$height;// taille de l'image
				if(@is_array(getimagesize($path_source))){
					// insert les info relatives au photo dans la base de données
   				 $req = "INSERT INTO file (name, extension, size) VALUES ('".$path_source."', '".$extension."', '".$imagesize."')";
  				 $db->query($req);
   				
				}
				
			}
		}
	}
	// ferme le repertoir ( le pointeur sur le repertoire)
	closedir($folder);
}
function print_files($path){
	$folder = opendir($path);	
	while($entree = readdir($folder))
	{	
		//ingore les veleur . et .. 
		if($entree != "." && $entree != "..")
		{
			$file = $path."/".$entree;

			// vérifie si le fichier est  un dossier
			if(!is_dir($path."/".$entree)) {
				echo "-  <img src=./icons/fichier.PNG width ='15px' />  ".$entree."<br>";
			}
}}}
?>
<P>
<B>FINNNNNN DU PROCESSUS :</B>
<BR>
<?php echo " ", date ("h:i:s"); ?>
</P>
