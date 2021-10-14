<?php
/**
 * Copyright (C) 2013-2021 Combodo SARL
 *
 * This file is part of iTop.
 *
 * iTop is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * iTop is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 */
define('APPROOT', dirname(__FILE__).'/../');
define('APPCONF', APPROOT.'/conf/');
require_once APPROOT.'/bootstrap.inc.php';

require_once(APPROOT.'/application\utils.inc.php');
$index = 0;
function testSanitize ($sValue, $sType, &$index ){
	$sDefaultVal = '!defaultVal!';
	$sSanitizedValue = utils::Sanitize($sValue, $sDefaultVal,$sType);
	echo('<tr id="'.$index.'"">');
	echo('<td>'.$sType.'</td>');
	echo('<td>'.$sValue.'</td>');
	echo('<td>'.$sSanitizedValue.'</td>');
	echo('<td class="testjs"><script>setTimeout( function() {$("#'.$index.'").find(".testjs").html(CombodoSanitizer.Sanitize("'.str_replace('"','\"',$sValue).'","'.$sDefaultVal.'","'.$sType.'"));}, 1000);</script></td>');
	echo('<td class="testok"><script>setTimeout( function() { let jsSanitedValue= CombodoSanitizer.Sanitize("'.str_replace('"','\"',$sValue).'","'.$sDefaultVal.'","'.$sType.'") ;	if(jsSanitedValue != "'.str_replace('"','\"',$sSanitizedValue).'"){		$("#'.$index.'").find(".testok").html("<font color=\"red\">KO</font>");}}, 1000);</script></td>');
	echo('</tr>');
	$index++;
}

$aValues = array(
	"test",
	"t;e-s_t$",
	"123test",
	"\"('èé&=hcb test",
	"<div>Hello!</div>",
	"*-+7464+guigez cfuze",
	"",
	"()=°²€",
	"éèç",
);

$aTypes = array(
	utils::ENUM_SANITIZATION_FILTER_PARAMETER,
	utils::ENUM_SANITIZATION_FILTER_CONTEXT_PARAM,
	utils::ENUM_SANITIZATION_FILTER_ELEMENT_IDENTIFIER,
	utils::ENUM_SANITIZATION_FILTER_FIELD_NAME,
	utils::ENUM_SANITIZATION_FILTER_INTEGER,
	utils::ENUM_SANITIZATION_FILTER_PARAMETER,
	utils::ENUM_SANITIZATION_FILTER_STRING,
	utils::ENUM_SANITIZATION_FILTER_TRANSACTION_ID,
	utils::ENUM_SANITIZATION_FILTER_VARIABLE_NAME,
);

?>
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/utils.js"></script>
	<style>
	table, tr, td{
		padding: 3px 10px;
		border :  1px solid lightgrey;
		border-collapse:collapse;
	}
	thead{
		font-weight: bold;
	}
	</style>
<table><thead><tr><td>Type</td><td>chaine initiale</td><td>chaine sanitize by php</td><td>chaine sanitize by js</td><td> status test</td></tr></thead>
<?php

	foreach ($aTypes as $sType){
		foreach ($aValues as $sValue){
			testSanitize ($sValue, $sType,$index);
		}
	}
?></table>