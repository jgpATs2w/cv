<?php
require '/var/www/mod/markdown/Michelf/Markdown.php';

use \Michelf\Markdown;

$lang = $_GET['lang'] ? $_GET['lang'] : 'en';
$text = file_get_contents("cv_$lang.md");
$html = Markdown::defaultTransform($text);

$vcard = file_get_contents('jgp.vcf');
	$tmp = array();
	preg_match_all("/^.+:.+\n/m", $vcard, $tmp);
	$VCard = array();
	
	while($line = array_pop($tmp[0])){
		$kv = split(':', (string)$line, 2);
		$VCard[$kv[0]] = $kv[1];
	}
	$name=preg_replace('/(.*);(.*);(.*)/','$3 $2 $1',$VCard['N']);
	$bd = preg_replace('/(\d\d\d\d)(\d\d)(\d\d)/','$3/$2/$1',$VCard['BDAY']);
	$url = str_replace('\\', '', $VCard['URL']);
	
	$Dictio = array(
					"title" => array("en" => "Javier's Resume", "es" => "CV Javier Garcia Parra"),
					"switch_lang" => array("en" => "espa�ol", "es" => "english")
					);
					
	$pdf = array_key_exists( 'pdf',$_GET);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=UTF-8" http-equiv="Content-Type"/>
        <title><?=$Dictio['title'][$lang]?></title>
        <link rel="stylesheet" href="cv<?=$pdf?'_pdf':''?>.css"/>
    </head>
    <body>
    	<nav>
    	<? if (!array_key_exists( 'pdf',$_GET)): ?>
    		<a href="jgp.vcf">vcard</a> |
    		<a href="pdf.php?lang=<?=$lang?>">pdf</a> |
    		<a href="cv_<?=$lang == 'es'? 'en' : 'es'?>.html"><?=$Dictio['switch_lang'][$lang]?></a>
    	<? endif; ?>
    	</nav>	
    	<header>
    		<img src="perfil.jpg" width="100px" alt="foto perfil"/>
    		<address>
    			<header><?=$name?></header>
    			<p>Madrid, <?= $bd;?></p>
    			<?= str_replace(';',',', $VCard['ADR']) ?> | <?=$VCard['EMAIL;TYPE=internet,pref']?>  |
    			<?=
    				(!array_key_exists( 'pdf',$_GET)) ? str_replace('@', ' AT ', $VCard['EMAIL;TYPE=internet,pref']) : $VCard['EMAIL;TYPE=internet,pref']?> 
    				| <a href="<?=$url?>"><?=$url?></a>
    		</address>
    	</header>
		<?php echo $html; ?>
    </body>
</html>
