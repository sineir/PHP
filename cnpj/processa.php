<?php
// Criado por Marcos Peli
// ultima atualização 24/02/2018 - Scripts alterados para utilização do captcha sonoro, unica opção após a atualização da receita com recaptcha do google
// o objetivo dos scripts deste repositório é integrar consultas de CNPJ e CPF diretamente da receita federal
// para dentro de aplicações web que necessitem da resposta destas consultas para proseguirem, como e-comerce e afins.

require('funcoes.php');
$field[0] = "cnpj";
$field[1] = "dat_ini";
$field[2] = "razao";
$field[3] = "fantasia";
$field[4] = "cnae1";
$field[5] = "cnae2";
$field[6] = "nat";
$field[7] = "log";
$field[8] = "num";
$field[9] = "comp";
$field[10] = "cep";
$field[11] = "bairro";
$field[12] = "mun";
$field[13] = "uf";
$field[14] = "email";
$field[15] = "tel";
$field[16] = "efr";
$field[17] = "sit";
$field[18] = "dat_sit";
$field[19] = "mot_sit";
$field[20] = "sit_esp";
$field[21] = "dat_sit_esp";
$field['status'] = "status";

// dados da postagem de formulário de CNPJ
$cnpj = $_POST['cnpj'];						// Entradas POST devem ser tratadas para evitar injections
$captcha_cnpj = $_POST['captcha_cnpj'];		// Entradas POST devem ser tratadas para evitar injections

// dados da postagem do formulario de CPF
$cpf = $_POST['cpf'];						// Entradas POST devem ser tratadas para evitar injections
$datanascim = $_POST['txtDataNascimento'];	// Entradas POST devem ser tratadas para evitar injections
$captcha_cpf = $_POST['captcha_cpf'];		// Entradas POST devem ser tratadas para evitar injections

if($cnpj AND $captcha_cnpj)
{
	$getHtmlCNPJ = getHtmlCNPJ($cnpj, $captcha_cnpj);
	$campos = parseHtmlCNPJ($getHtmlCNPJ);
}
if($cpf AND $datanascim AND $captcha_cpf)
{
	$getHtmlCPF = getHtmlCPF($cpf, $datanascim, $captcha_cpf);
	$campos = parseHtmlCPF($getHtmlCPF);
}
//print_r($campos);

$sql = "insert into cnpj (";
foreach($field as $value){
	$sql .= $virg.$value;
	$virg=",";
}
$sql .=") values (";

echo "<table border=1>\r\n";
$virg="";
foreach ($campos as $key=>$value){
echo "<tr><td>$key:".$field[$key];
echo "<td>\r\n";
if (is_array($value)) {
	$xsql = "";
	foreach ($value as $kk=>$vv){
		//echo $pular.$vv;
		echo $pular.tirar($key,$vv);
		$xsql .= $pular.tirar($key,$vv);
		$pular = ",";
	}
	}else{	
	//echo "$value\r\n";
	echo tirar($key,$value);
	$xsql = tirar($key,$value);
	}
	$sql .= $virg . chr(34) . $xsql . chr(34) ;
	$virg=",";
}
$sql .= ");";
echo "</table><br><br>$sql";

function tirar($chave,$text){
	$arg = str_replace("-","",$text);
	$arg = str_replace(".","",$arg);
	$arg = str_replace("/","",$arg);
	$arg = str_replace("(","",$arg);
	$arg = str_replace(")","",$arg);
	$arg = str_replace("*","",$arg);
	
	switch ($chave) {
		case 0; //cnpj len 14
		case 3; //fantasia sem '*'
		case 10; //cep len 8
		case 15; //tel only numbers
		case 16; //eft sem '*'
		case 20; //sit esp sem '*'
		return $arg;
		break;
		case 1; //datas yyyy-mm-dd
		case 18;
		case 21;
		if ($arg !="" and substr($arg,0,1)!="*"){
			$arg = substr($arg,-4)."-".substr($arg,2,2)."-".substr($arg,0,2);
		}else{
			$arg = "";
		}
		return $arg;
		break;
		case 4; //cnae's len 7
		case 5;
		return substr($arg,0,7);
		break;
		case 6; //nat jur len 4
		return substr($arg,0,4);
		break;
		default:
		return $text; // demais original
	}
}
/*

  id,cnpj,dat_ini,razao,fantasia,cnae1,cnae2,nat,log,num,comp,cep,bairro,
  mun,uf,email,tel,efr,sit,dat_sit,mot_sit,sit_esp,dat_sit_esp,status


CREATE TABLE IF NOT EXISTS `cnpj` (
  `id` bigint(20) NOT NULL,
  `cnpj` varchar(14) DEFAULT NULL,
  `dat_ini` datetime DEFAULT NULL,  
  `razao` varchar(50) DEFAULT NULL,
  `fantasia` varchar(50) DEFAULT NULL,
  `cnae1` varchar(7) DEFAULT NULL,
  `cnae2` varchar(50) DEFAULT NULL,
  `nat` varchar(4) DEFAULT NULL,
  `log` varchar(50) DEFAULT NULL,
  `num` varchar(20) DEFAULT NULL,
  `comp` varchar(20) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `mun` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `tel` varchar(12) DEFAULT NULL,
  `efr` varchar(20) DEFAULT NULL,
  `sit` varchar(30) DEFAULT NULL,
  `dat_sit` datetime DEFAULT NULL,
  `mot_sit` varchar(30) DEFAULT NULL,
  `sit_esp` varchar(30) DEFAULT NULL,
  `dat_sit_esp` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

*/

?>