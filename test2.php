<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Изучение CRM");
$APPLICATION->SetTitle("test2");

?>

<?

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/mail/include.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/arka/arka_classes.php");

////////////////////////////////////
// get last file type by dealid
$typ = CArkaCrm::GetDealStageByLastFile(2680);

echo 'typ ' . $typ  .'<br>';




/*
$cntp = CArkaCrm::CountPropsInDeal(1167);
$cnti = CArkaCrm::CountInvoicesInDeal(1167);
$cnt = CArkaCrm::CountPropsAndInvoicesInDeal(1167);
echo "cntp = $cntp<br>";
echo "cnti = $cnti<br>";
echo "cnt = $cnt<br>";
*/

/*
///////////////////////////////////////////
// поиск по пользовательскому полю

$arOrder = array("SORT"=>"ASC");
$arFilter = array("");
*/


/*
$rr = CarkaCrm::CreateCallbackMessage(337);
echo "$rr<br>";
*/

//$ar = CMailBox::GetList();
//print_r($ar);

/*
CMailError::ResetErrors();
$mb = new CMailbox();

if($mb->Connect(1)){
    echo "connected<br>";    
}
else{
    echo "not connected<br>";
}
*/

/*
// test array
$ar = CCrmDeal::GetByID(337);
foreach($ar as $kk => $vv)
{
    echo "key $kk --- val is $vv<br>";    
}
*/

/*
echo "<h1>Читаем польз поля из сделки 337</h1>";
$dealid = 337;
$arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields('CRM_DEAL',$dealid);
foreach($arUF as $kk => $vv)
{
    echo "key $kk --- val is " . ($vv['VALUE']) . "<br><br>";    
}
*/

/*
echo "<p>Company fields</p>";
$ar = CCrmCompany::GetByID(3132,false);
foreach($ar as $kk => $vv)
{
    echo "key $kk --- val is $vv<br>";    
}

$arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields('CRM_COMPANY',3132);
print_r($arUF);
*/
/*
echo "Test contact<br>";
$aa = array();
$filt = array('COMPANY_ID'=>965);

//$filt = array();

$rs = CCrmContact::GetList($aa,$filt);

while($aa = $rs->GetNext()){
    print_r($aa);
    echo "ok<br>";    
}
*/

/*
echo "exist<br>";
foreach($ar as $kk => $vv)
{
    echo "key $kk --- val is $vv<br>";    
}
*/

/*
echo "<p>Contact fields</p>";
$ar = CCrmContact::GetByID(1000);
foreach($ar as $kk => $vv)
{
    echo "key $kk --- val is $vv<br>";    
}
*/






?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>