<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Изучение CRM");
$APPLICATION->SetTitle("test");
?>

<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/mail/include.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/arka/arka_classes.php");

echo "<br/>";

return; //  !!! need to secure

/**
 * страница для изменения ответственного за компанию
 * в дилерах COMPANY_TYPE - RESELLER
 * на руслану майданик 553
 */

$ar = array('ASSIGNED_BY_ID' => 553); // руслана
$com = new CCrmCompany();

// select companies
$res = CCrmCompany::GetListEx(array(), array("COMPANY_TYPE" => "RESELLER"));
$i = 1;
while($ob = $res->GetNext()){
    $id = $ob['ID'];
    echo $i++ . " " . $ob['ID'] . " " . $ob['TITLE'];
    echo "<br/>";

    // chng ASSSIGNED
    $com->Update($id, $ar);

}

echo "<br/>OK!<br/>";




