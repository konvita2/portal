<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Изучение CRM");
$APPLICATION->SetTitle("test");

?>

<?

/*
echo $USER->GetID();
echo "<br>";
echo $USER->GetLastName();
*/

include_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/arka/arka_classes.php");

//CArkaSMS::SendSMS('380965468079','заказ 222 / цена 555');


$ID_DEAL = 165;
$obFieldsDeal = CCrmDeal::GetList(array(), array('ID' => $ID_DEAL));
					if($arFieldsDeal = $obFieldsDeal->Fetch())
					{
						$arResult['DEAL'] = $arFieldsDeal;
						//AddMessage2Log(serialize($arFieldsDeal),"CRON deal info arFieldsDeal");	                                                 
						print_r($arFieldsDeal);
					}

AddingFilesToDeal();                                        
                                        

//////////////////////////////////////
/*
розборка частини назви файла з адуло для визначення коду в скобках типу SMART(233)
*/
function GetDataTemplate($kod){
  
  $begin_str = strpos($kod, '(');
  $end_str = strrpos($kod, ')');
  $kod = substr($kod, ($begin_str + 1), ($end_str - $begin_str - 1));
  $kod = str_replace("," , ".", $kod);
  return $kod;
}

//////////////////////////////////////
function AddingFilesToDeal(){
    
        //deb
        AddMessage2Log("//////////////////////////////////////////////////////////////////////////","TESTPAGE");

	$dir = $_SERVER["DOCUMENT_ROOT"].'/upload/proscet/';
/*
	визначення полыв назви файла з кодами выдповыдних параметрыв
	
pred - Предложение
scet - Счет	
SM -предложение поле в сделке "Предложение для КП" ( там накапливаем все предложения)
ST - счета , поле в сделке "Счет для КП" ( там накапливаем все счета)
ND - номер документа ( для счета и предложения) накапливаем в поле "Номер предложения"
PNK - номер клиента в адуло - пока не пойму зачем мы его там применяли
DAT - Дата документа записываем последнюю дату последнего документа переписываем в поле "Дата документа(ов)"
KO - кол во окон переписываем в "кол во окон"
PO - кол во позиций -переписываем в "кол во позиций"
ObSum - Общая стоимость заказа переписываем с последнего документа в поле "Общая стоимость заказа"
Skid1 - Скидка 1 переписываем с последнего документа в поле "Скидка 1"
Skid2 - Скидка 1 переписываем с последнего документа в поле "Скидка 2"
ObSumSoSkid - общая сумма со скидкой - переписываем ее в сумму сделки (Станд поле)
Const -Конструктор кто последний считал перезаписываем в поле "Конструктор"
	
    [0] => pred
    [1] => StartCod
    [2] => SM()
    [3] => ND(232390)
    [4] => NK(662)
    [5] => PNK()
    [6] => DAT(13.03.2014)
    [7] => KO(1)
    [8] => PO(2)
    [9] => ObSum(1745.48)
    [10] => Skid1(523.64)
    [11] => Skid2()
    [12] => ObSumSoSkid(1221.84)
*/

	$arCODEFieldCRM = array(
		//"NP" => "UF_CRM_1371129747",
		//"NK" => "UF_CRM_1370699153",
		'pred' => 'UF_CRM_1389787932', // Предложение для КП
		'scet' => 'UF_CRM_1389787984', // Счет для КП
		'ND' => 'UF_CRM_1392800030', // Номер предложения (накоплюэмо?)
		'DAT' => 'UF_CRM_1392800324', // Дата документа(ов)
		'KO' => 'UF_CRM_1397335755', // Кол-во изделий
		'PO' => 'UF_CRM_1397335828', // Кол-во ПОЗИЦИЙ
		'ObSum' => 'UF_CRM_1392800556', // Общая стоимость заказа
		'Skid1' => 'UF_CRM_1392800748', // Скидка 1
		'Skid2' => 'UF_CRM_1392800769', // Скидка 2
		'ObSumSoSkid' => 'OPPORTUNITY', // (Станд поле)
	);
	
	$arPositionInName = array(
		'type_file' => '0',
		'StartCod' => '1',
		'SM' => '2',
		'ND' => '3',
		'NK' => '4',
		'PNK' => '5',
		'DAT' => '6',
		'KO' => '7',
		'PO' => '8',
		'ObSum' => '9',
		'Skid1' => '10',
		'Skid2' => '11',
		'ObSumSoSkid' => '12',
	);
	
	$arParams['STATUS_ADULO'] = 1760;
	$arParams['STATUS_PRED'] = 33103;
	$arParams['STATUS_ORDER'] = 1763;
	$arParams['ID_STATUS_PROP'] = 'UF_CRM_1392465232';

	$arResult = array();
	
	if ($handle = opendir($dir)) {

		if (!CModule::IncludeModule('crm'))
			return false;

		$CCrmDeal = new CCrmDeal(); 
		$arResult = array();		
		
		while (false !== ($file = readdir($handle))) {
    
                        //отбросить те, где нет номера смарта
                        if(strpos($file,'SM()') != FALSE)
                        {
                            continue;    
                        }
    
                        //deb
                        AddMessage2Log("file is:$file","TESTPAGE");
    
			if(substr_count($file, ".pdf") > 0){
	  	  
				$file_data = str_replace(".pdf", "", $file);
								
				$file_src = $_SERVER["DOCUMENT_ROOT"].'/upload/proscet/'.$file;
				/*
				$dir_dest = $_SERVER["DOCUMENT_ROOT"].'/docs/folder/files/adulo/'.$file;
				copy($file_src, $dir_dest);        
				*/	
				
				$arResult['NAME'] = explode("_", $file_data);								
				$ID_DEAL = IntVal(GetDataTemplate($arResult['NAME'][$arPositionInName['SM']]));				

				//deb
				//AddMessage2Log(serialize($ID_DEAL), "CRON AddingFilesToDeal /+++/");				
				
				if($ID_DEAL > 0){
					
					AddMessage2Log(serialize($ID_DEAL), "CRON AddingFilesToDeal /vvv/");									
						
					$obFieldsDeal = CCrmDeal::GetList(array(), array('ID' => $ID_DEAL));
					if($arFieldsDeal = $obFieldsDeal->Fetch())
					{
						$arResult['DEAL'] = $arFieldsDeal;
						AddMessage2Log(serialize($arFieldsDeal),"CRON deal info arFieldsDeal");	
					}
					//else AddMessage2Log(serialize($ID_DEAL), "CRON AddingFilesToDeal -> DEAL error");
					
					
				}		

				//AddMessage2Log(serialize($arResult['DEAL']), "CRON AddingFilesToDeal -> DEAL");
				
				if(is_array($arResult['DEAL']) && !empty($arResult['DEAL'])){				

					$time_add_file = time();
					$arFieldsProps = array();
				
					$arFieldsProps[$arCODEFieldCRM['DAT']] = GetDataTemplate($arResult['NAME'][$arPositionInName['DAT']]);
					$arFieldsProps[$arCODEFieldCRM['KO']] = GetDataTemplate($arResult['NAME'][$arPositionInName['KO']]);
					$arFieldsProps[$arCODEFieldCRM['PO']] = GetDataTemplate($arResult['NAME'][$arPositionInName['PO']]);

					$arFieldsProps[$arCODEFieldCRM['ObSum']] = GetDataTemplate($arResult['NAME'][$arPositionInName['ObSum']]);
					$arFieldsProps[$arCODEFieldCRM['Skid1']] = GetDataTemplate($arResult['NAME'][$arPositionInName['Skid1']]);
					$arFieldsProps[$arCODEFieldCRM['Skid2']] = GetDataTemplate($arResult['NAME'][$arPositionInName['Skid2']]);

					$arFieldsProps['OPPORTUNITY'] = GetDataTemplate($arResult['NAME'][$arPositionInName['ObSumSoSkid']]);
					
					if($arResult['NAME'][$arPositionInName['type_file']] == 'pred'){
					
						foreach($arResult['DEAL'][$arCODEFieldCRM['pred']] as $file_old){
							$arFieldsProps[$arCODEFieldCRM['pred']][] = CFile::MakeFileArray($file_old);
						}
          
						//deb
						AddMessage2Log($file_src,"CRON filesrc");
						
						$arFile = CFile::MakeFileArray($file_src);
						
						$arFile['name'] = $time_add_file;
						$arFile['name'] .= '_'.$arResult['NAME'][$arPositionInName['SM']];
						$arFile['name'] .= '_'.$arResult['NAME'][$arPositionInName['NK']];
						$arFile['name'] .= '_'.$arResult['NAME'][$arPositionInName['DAT']];
						$arFile['name'] .= '_'.$arResult['NAME'][$arPositionInName['ObSumSoSkid']];
						$arFile['name'] .= '.pdf';
						
						//deb
						AddMessage2Log($arFile['NAME'],"CRON file_name");
						
						$arFieldsProps[$arCODEFieldCRM['pred']][] = $arFile;
						
						$arFieldsProps['STAGE_ID'] = 'DETAILS'; 
		  
					}
					elseif($arResult['NAME'][$arPositionInName['type_file']] == 'scet'){
					
						foreach($arResult['DEAL'][$arCODEFieldCRM['scet']] as $file_old){
							$arFieldsProps[$arCODEFieldCRM['scet']][] = CFile::MakeFileArray($file_old);
						}
              
						$arFile = CFile::MakeFileArray($file_src);

						$arFile['name'] = $time_add_file;
						$arFile['name'] .= '_'.$arResult['NAME'][$arPositionInName['SM']];
						$arFile['name'] .= '_'.$arResult['NAME'][$arPositionInName['NK']];
						$arFile['name'] .= '_'.$arResult['NAME'][$arPositionInName['DAT']];
						$arFile['name'] .= '_'.$arResult['NAME'][$arPositionInName['ObSumSoSkid']];						
						$arFile['name'] .= '.pdf';
						
						$arFieldsProps[$arCODEFieldCRM['scet']][] = $arFile;
                    
						$arFieldsProps['STAGE_ID'] = 'PROPOSAL';
		  
					}
					
					// status ADULO 
					$arFieldsProps[$arParams['ID_STATUS_PROP']] = $arParams['STATUS_ADULO'];
					
//echo "<pre style='font:normal 7pt/9pt Arial; color:blue;'>Q ";print_r(htmlspecialcharsEx($arFieldsProps)); echo "</pre>";	
					
					//deb
					AddMessage2Log(gettype($arFile),"CRON gettype1");
					AddMessage2Log(count($arFile),"CRON gettype1 count");
					
					if(!is_null($arFile)){
						if($CCrmDeal->Update($arResult['DEAL']['ID'], $arFieldsProps)){
							unlink($file_src);
							$arResult['DEALS'][$arResult['DEAL']['ID']][] = $time_add_file;
						}	
					}
					
					UnSet($arFieldsProps);
				}	
	  /*
        if(strlen($arFieldsDeal[$arCODEFieldCRM['NP']]) > 0){
        
          if(substr_count($arFieldsDeal[$arCODEFieldCRM['NP']], $num_client) == 0){
            $arNP = explode(', ', $arFieldsDeal[$arCODEFieldCRM['NP']]);
            $arNP[] = $num_client;
            $arFieldsProps[$arCODEFieldCRM['NP']] = implode(', ', $arNP);
          }
        }
        else
          $arFieldsProps[$arCODEFieldCRM['NP']] = $num_client;
          
        $arFieldsProps[$arCODEFieldCRM['NK']] = GetDataTemplate($arName[4]);
		*/
			}
		}
		closedir($handle); 
	}
	return $arResult['DEALS'];
}



?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>