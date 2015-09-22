<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Изучение CRM");
$APPLICATION->SetTitle("test");

?>

<?

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/mail/include.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/arka/arka_classes.php");

echo "<br/>";

/*
// прочитать стоимость сделки
$ar = CArkaCrm::GetDealCostOriginal(4450);
echo $ar;
*/

/*
//////////////////////////
// прочитать тип документа
$arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields('CRM_DEAL',548);
echo "before is " . $arUF['UF_CRM_1392456515']['VALUE'];
echo "<br>";

echo "update<br>";
CArkaCrm::SetDealDocumentType(548,2);

$arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields('CRM_DEAL',548);
echo "after is " . $arUF['UF_CRM_1392456515']['VALUE'];
echo "<br>";
*/

/*
//////////////////////////
// проверить преобразование
$orig = CArkaCrm::GetDealStageOriginal(512);
$new = CArkaCrm::TranslateDealStage($orig);
echo "orig is [$orig]<br>";
echo "new is $new<br>";

$rr = $orig;
        if($rr == "DETAILS"){
			echo "p1<br>";
            $res = "Предварительная";
        }                        
        elseif($rr == "NEW"){
			echo "p2<br>";
            $res = "Новая";
        }
        elseif($rr == "PROPOSAL"){
			echo "p3<br>";
            $res = "Предложение";
        }
        elseif($rr == "NEGOTIATION"){
			echo "p4<br>";
            $res = "Выставлен счет";
        }
        elseif($rr == "WON"){
			echo "p5<br>";
            $res = "Сделка завершена успешно!";
        }
        elseif($rr == "LOSE"){
			echo "p6<br>";
            $res = "Сделка завершена неудачно";
        }
        elseif($rr == "ON_HOLD"){
			echo "p7<br>";
            $res = "Сделка приостановлена";
        }

echo "res is $res<br>";
*/

/*
//////////////////////////
// получить массив полей сделки
$ar = CCrmDeal::GetByID(512);
foreach($ar as $kk=>$vv){
	echo "kk:$kk /// vv:$vv<br>";
}
echo "<br>---<br>";
*/

/*
//////////////////////////
// получить массив описание файлов предложений из множественного поля сделки
$arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields('CRM_DEAL',480);		
$resultAr = $arUF['UF_CRM_1389787932'];
foreach($resultAr['VALUE'] as $kk => $vv)
{
	echo "<br>file $vv description<br>";
	$arFile = CFile::MakeFileArray($vv);
	foreach($arFile as $fkey=>$fval){
		echo "   fkey is $fkey     ---- fval is $fval" . "<br>";
	}
	
}
*/

/*
//////////////////////////
// получить количество предложений
// в сделке через метод класса
echo "Props is " . CArkaCrm::CountPropsInDeal(456);
*/

/*
//////////////////////////////////////
// поле с множеств значением, 
// определить количество значений
// в данном случае - кво предложений

$arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields('CRM_DEAL',456);
$arFL = $arUF['UF_CRM_1389787932'];
echo "Elements " . count($arFL['VALUE']);
*/


/*
/////////////////////////////////////////
// get company fields

$ar = CArkaCrm::GetCompanyPhoneByID(7241);
print_r($ar);
*/

/*
/////////////////////////////////////////
// trying to update stop time
$res = CArkaConstrWork::RegisterStop(490,404);
if($res){
	echo "success<br/>";
}
else{
	echo "fail<br/>";
}
*/

/*
 * получить список компаний которые только дилеры
 */
echo "Get dealers list<br/>";

$res = CCrmCompany::GetListEx(array(), array("COMPANY_TYPE" => "RESELLER"));
$i = 1;
while($ob = $res->GetNext()){
		echo $i++ . " " . $ob['TITLE'];
		echo "<br/>";
}

/*
/////////////////////////////////////////
// update company
echo "Update company info<br/>";

$ar = array("ASSIGNED_BY_ID" => 553);
$com = new CCrmCompany();
$res = $com->Update(4586, $ar);

/////////////////////////////////////////
// reading company info
echo "Reading company info<br/>";
$res = CCrmCompany::GetListEx(array(), array("ID"=>4586));
while($ob = $res->GetNext())
{
	echo $ob;
	//$ff = $ob->Fetch();

	foreach($ob as $kk=>$vv){
		echo "key $kk --- val $vv<br>"; 
	}

	echo "<br/>";
}
*/


/*
$cnt = CArkaCrm::SendUnsentEmailsByDealID(382,'pred');
echo "$cnt files were sent<br/>";
*/

/*
$res = CArkaConstrWork::RegisterStart(490,404,'test calc AAA');
$res = CArkaConstrWork::RegisterStart(491,405,'test calc BBB');
$res = CArkaConstrWork::RegisterStart(494,406,'test calc CCC');
echo "res is $res<br>";
*/


/*
/////////////////////////////////////
echo "Reading IB<br/>";

$arFilter = array(
"IBLOCK_ID"=>65,
"PROPERTY_USER" => "490",
"PROPERTY_DEAL" => 401,
);


$rsItems = CIBlockElement::GetList(array("SORT"=>"ASC"), $arFilter,false,false,array());

while($ob = $rsItems->GetNextElement()){
	$arFields = $ob->GetFields();
	print_r($arFields);
	echo "<br/>";

	echo "---" . $arFields["NAME"] . "<BR/>";
	$arProps = $ob->GetProperties();
	foreach($arProps as $kk => $vv){
		$cod = $vv["CODE"];
		$nam = $vv["NAME"];
		$val = $vv["VALUE"];

		echo "Code is $cod Name is $nam value is $val";

		if($cod == 'timestop')
		{
			echo "type is " . gettype($val) . "<br/>";
		}

		echo "<br/>"; 

	}
	echo "<hr/>";
}

*/

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>