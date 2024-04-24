<?php
# Form validation function
function is_empty($var, $text, $location, $ms, $data)
{
	if (empty($var)) {
		# Envia un mensaje de error requiriendo los datos a llenar
		$em = "Se Requiere " . $text;
		header("Location: $location?$ms=$em&$data");
		exit;
	}
	return 0;
}