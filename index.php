<html>
<head>
	<title>Bienvenue sur Internet !</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
	<?php $json = read_json("json/data.json"); ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
</head>
<body>
	<h1>Bienvenue sur Internet</h1>
	<hr></hr>
	<div id="sites">
		<?php foreach($json->sites as $site){ ?>
			<div class="site">
				<a href="<?php echo $site->url; ?>">
					<div class="image" style="background-color: <?php if($site->bg != "") print $site->bg; else print "None"; ?>">
						<img title="<?php echo $site->image; ?>" src="img/<?php echo $site->image; ?>.png"/>
					</div>
				</a>
				<div class="titre"><?php echo $site->titre; ?></div>
			</div>
		<?php } ?>
	</div>
</body>
</html>

<script>
	$(document).ready(function(){
		$("div:hidden").fadeIn("slow");
	});

	$(".site a").hover(function(){
		$img_tag = $(this).find("img");
		$image = $img_tag.attr("title");
		$src = "img/"+$image+"_alt.png";
		$.ajax({
		    url: $src,
		    type:'HEAD',
		    error: function(){
		    	$exists = false;
		    },
		    success: function(){
		        $img_tag.attr("src", $src);
		        $exists = true;
		    }
		});
	}, function(){
		$img_tag = $(this).find("img");
		if($exists){
			$image = $img_tag.attr("title");
			$img_tag.attr("src", "img/"+$image+".png");
		}
	});	
</script>

<?php
	// Lit un fichier JSON et renvoie un objet contenant l'ensemble de l'arborescence JSON
	function read_json($path){
		$file = fopen($path, "r") or die("Erreur d'ouverture:".getcwd()."<br>");
		$str = fread($file, filesize($path)) or die("Echec de lecture du fichier");
		fclose($file);
		return json_decode($str);
	}
?>
