<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?= $this->lang->line('dtr-slogan')?></title>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans+Condensed:300" rel="stylesheet">
		<style type="text/css">
			body{
				/*background: #FFFFFF;*/
				font-family:sans-serif; 
				font-size:18px;
				color:#222222;
				font-family: 'Open Sans Condensed', sans-serif;
			}
			a{
				color: #0074D9;
				font-weight: bold;
			}
			a:hover{
				color:#666666;
			}
			table thead, table tfoot{
                background: #007BFF
			}

			.box-shadow{
				box-shadow: 2px 2px 1px #CCCCCC;
			}
			table{
				border-radius: 5px;
				border: 1px solid #333333;
				width: 90%;
				margin-right: 5%;
				margin-left: 5%;
				padding: 0;
				border:0;
				float: left
			}
			table td{
				padding: 5px
			}
			.signature{
				padding: 10px 0;
				color: white;
			}
			.altbody{
				background: #DDDDDD;
			}
		</style>
	</head>

	<body>

		<table class="box-shadow" width="100%" border="0" cellspacing="5" cellpadding="0">
			<thead>
				<tr>
					<th class="foot">
						<?php $src= base_url().'imgs/logo-dtransporte.png'?>
						<img src="<?= $src?>" style="float:left; padding:5px">
					</th>
				</tr>
			</thead>
			<?php if(isset($tplSignature)):?>
			<tfoot>
				<tr>
					<td class="foot">
						<span class="signature"><?= $tplSignature?></span>
					</td>
				</tr>
			</tfoot>
			<?php endif?>

			<tbody>
				<tr>
					<td><?= $tplHeader?></td>
				</tr>
				<tr>
					<td>
						<?= $tplContent?>
						<?php if(isset($tplAltBody)):?>
							<p class="alert altbody"><?= $tplAltBody?></p>
						<?php endif?>
					</td>
				</tr>
				
			</tbody>
		</table>
	</body>
</html>
