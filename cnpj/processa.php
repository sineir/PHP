<?php
// Criado por Marcos Peli
// ultima atualização 24/02/2018 - Scripts alterados para utilização do captcha sonoro, unica opção após a atualização da receita com recaptcha do google
// o objetivo dos scripts deste repositório é integrar consultas de CNPJ e CPF diretamente da receita federal
// para dentro de aplicações web que necessitem da resposta destas consultas para proseguirem, como e-comerce e afins.

require('funcoes.php');
$field[0] = "CNPJ";
$field[1] = "Abertura";
$field[2] = "Nome Empresarial";
$field[3] = "Nome de Fantasia";
$field[4] = "Ativ. Principal";
$field[5] = "Ativ.Secundarias";
$field[6] = "Nat.Juridica";
$field[7] = "Logradouro";
$field[8] = "Numero";
$field[9] = "Complemento";
$field[10] = "Cep";
$field[11] = "Bairro";
$field[12] = "Municipio";
$field[13] = "UR";
$field[14] = "e-mail";
$field[15] = "Telefone";
$field[16] = "EFR";
$field[17] = "Situacao";
$field[18] = "Data Situacao";
$field[19] = "Motivo Situacao";
$field[20] = "Situacao Especial";
$field[21] = "Data Situacao Especial";
$field['status'] = "Status";

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

echo "<table border=1>\r\n";
foreach ($campos as $key=>$value){
echo "<tr><td>".$field[$key]."<td>\r\n";

if (is_array($value)) {
	foreach ($value as $kk=>$vv){
		echo $pular.$vv;
		$pular = "<br>";
	}
	}else{	
	echo "$value\r\n";
	}
}


?>