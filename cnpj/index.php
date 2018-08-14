<?php
// Criado por Marcos Peli
// ultima atualização 24/02/2018 - Scripts alterados para utilização do captcha sonoro, unica opção após a atualização da receita com recaptcha do google
// o objetivo dos scripts deste repositório é integrar consultas de CNPJ e CPF diretamente da receita federal
// para dentro de aplicações web que necessitem da resposta destas consultas para proseguirem, como e-comerce e afins.
// importante, CPF e DATA de NASCIM. devem ser digitados no formato ###.###.###-##  e  dd/mm/aaaa
// CNPJ devem ser digitados só NUMEROS   ###########  (sem ponto ou hifem)
// essas entradas nâo foram tratadas, pois o objetivo é apenas a implementaçâo da soluçao das consulta e testes

include("getcaptcha.php");
$cnpj = $_REQUEST['cnpj'];
?>
<html>

<head>
<title>CNPJ e Captcha</title>
</head>

<body onload="document.getElementById('cnpj').focus(); "> <center><br><br><br>
<table border=1>
	<form id="receita_cnpj" name="receita_cnpj" method="post" action="processa.php">
		<tr><td align=center><span class="titleCats">CNPJ e Captcha</span>
			<tr><td align=center>
			<b style="color: red">CNPJ</b>
			<tr><td align=center>
			<input name="cnpj" id="cnpj" type="text" maxlength="14" value="<?=$cnpj?>" required /> 
			<tr><td align=center>
			<b style="color: red">Digite o texto da imagem</b>
			<tr><td align=center>
			<img id="captcha_cnpj" src="<?php echo $imagem_cnpj; ?>" border="0">
			<tr><td align=center>
			<input name="captcha_cnpj" type="text" maxlength="6" required />
		<tr><td align=center>
			<input id="enviar" name="enviar" type="submit" value="Consultar"/>
		
	</form>
        
<!--
	<form id="receita_cpf" name="receita_cpf" method="post" action="processa.php">
		<p><span class="titleCats">CPF e Captcha</span>
			<br />
			<input type="text" name="cpf" maxlength="14" minlength="14" required /> 
			<b style="color: red">CPF xxx.xxx.xxx-xx</b>
			<br />
			<input type="text" name="txtDataNascimento" maxlength="10" minlength="10" required /> 
			<b style="color: red">Data Nascim. dd/mm/aaaa</b>
			<br />                           
			<img id="captcha_cpf" src="<?php echo $imagem_cpf; ?>" border="0">
			<br />
			<input type="text" name="captcha_cpf" minlength="6" maxlength="6" required />
			<b style="color: red">O que vê na imagem acima?</b>
			<br />
		</p>
		<p>
			<input id="enviar" name="enviar" type="submit" value="Consultar"/>
		</p>
		<p>
			_____________________________________________________
		</p>

	</form>
-->
</body>

</html>