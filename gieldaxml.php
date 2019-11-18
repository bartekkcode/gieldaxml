<?php
/* 2018 TWOJAGIELDA.COM
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author twojagielda.com 
*  @version  Release: 1.8
*/

if (!defined('_PS_VERSION_'))
    exit;
class gieldaxml extends Module
{
    
    const CHARSET = 'UTF-8';
    const REPLACE_FLAGS = ENT_COMPAT;
    private $sql_checks = array();
    function __construct()
    {
        $this->name    = 'gieldaxml';
        $this->tab     = 'export';
        $this->version = '1.8';
        $this->author  = 'twojagielda.com';
        
        parent::__construct();
        
        $this->page        = basename(__FILE__, '.php');
        $this->displayName = 'Gielda Pro xml';
        $this->xmldescriptiongielda = 'Eksport produktów do pliku xml - Twoja Gielda';
        $this->confirmUninstall = 'Jesteś pewien, że chcesz odinstalować?';
        $this->need_instance          = 0;
        $this->ps_versions_compliancy = array(
            'min' => '1.5',
            'max' => '1.8'
        );
        
       $this->uri = ToolsCore::getCurrentUrlProtocolPrefix() . $this->context->shop->domain_ssl . $this->context->shop->physical_uri;
    }
    
    function install()
    {
        if (!parent::install()) {
            return false;
        }
        return true;
    }
    public function uninstall()
{
  if (!parent::uninstall() ||
  !Configuration::deleteByName('gieldaxml'))
  return false;
  return true;
}
    
    
    public function getContent()
    {
			if (isset($_POST['generate'])) {
			//xmllimitgielda
            if (isset($_POST['xmllimitgielda'])) {
                Configuration::updateValue('xmllimitgielda', $_POST['xmllimitgielda']);
                
            }
            //xmlcategorygielda
            if (isset($_POST['xmlcategorygielda'])) {
                Configuration::updateValue('xmlcategorygielda', $_POST['xmlcategorygielda']);
                
            }
            //xmlmangielda
            if (isset($_POST['xmlmangielda'])) {
                Configuration::updateValue('xmlmangielda', $_POST['xmlmangielda']);
                
            }
            //xmliloscgielda
            if (isset($_POST['xmliloscgielda'])) {
                Configuration::updateValue('xmliloscgielda', $_POST['xmliloscgielda']);
                
            }
             //xmlcategoriesgielda
            if (isset($_POST['xmlcategoriesgielda'])) {
                Configuration::updateValue('xmlcategoriesgielda', $_POST['xmlcategoriesgielda']);
                
            }
            //xmlgroupnamegielda
            if (isset($_POST['xmlgroupnamegielda'])) {
                Configuration::updateValue('xmlgroupnamegielda', $_POST['xmlgroupnamegielda']);
                
            }
            //image type
            if (isset($_POST['image'])) {
                Configuration::updateValue('xmlimagegielda', $_POST['image']);
            }
            
            //country
            if (isset($_POST['xmlavailablegielda'])) {
                Configuration::updateValue('xmlavailablegielda', $_POST['xmlavailablegielda']);
            }
            
            // Get installed languages
            $languages = Language::getLanguages();
            $category = Db::getInstance()->executeS('SELECT `id_category` FROM `'._DB_PREFIX_.'category` WHERE `active` = 1 AND id_category > 1');
            foreach ($languages as $i => $lang) {
            foreach ($category as $i => $row) {
			 $cname = Db::getInstance()->executeS('SELECT `name` FROM `'._DB_PREFIX_.'category_lang` WHERE `id_category` =' . $row['id_category']. ' AND id_lang ='. $lang['id_lang']); 
				 foreach ($cname as $i => $ws) {
                if (isset($_POST['xmlcategorytypegielda' . $lang['iso_code'].$row['id_category']])) {
                    Configuration::updateValue('xmlcategorytypegielda' . $lang['iso_code'].$row['id_category'], $_POST['xmlcategorytypegielda'.$lang['iso_code'].$row['id_category']]);
						}
					}
                }
            }
            // Get generation file route
            if (isset($_POST['generate_root']) && $_POST['generate_root'] === "on") {
                Configuration::updateValue('xmlgieldaroot', intval(1));
                
            } else {
                Configuration::updateValue('xmlgieldaroot', intval(0));
                @mkdir($path_parts["dirname"] . '/file_exports', 0755, true);
                @chmod($path_parts["dirname"] . '/file_exports', 0755);
            }
            
            //Code EAN13
            if (isset($_POST['xmlgtingielda']) && $_POST['xmlgtingielda'] === "on") {
                Configuration::updateValue('xmlgtingielda', intval(1));
            } else {
                Configuration::updateValue('xmlgtingielda', intval(0));
            }
            
            //Manufacturer Part Number (xmlmpmgielda)
            if (isset($_POST['xmlmpmgielda']) && $_POST['xmlmpmgielda'] === "on") {
                Configuration::updateValue('xmlmpmgielda', intval(1));
            } else {
                Configuration::updateValue('xmlmpmgielda', intval(0));
            }
            
            // QTY
            if (isset($_POST['xmlquantitygielda']) && $_POST['xmlquantitygielda'] === "on") {
                Configuration::updateValue('xmlquantitygielda', intval(1));
            } else {
                Configuration::updateValue('xmlquantitygielda', intval(0));
            }
            // warehouse
            if (isset($_POST['xmlmagazyngielda']) && $_POST['xmlmagazyngielda'] === "on") {
                Configuration::updateValue('xmlmagazyngielda', intval(1));
            } else {
                Configuration::updateValue('xmlmagazyngielda', intval(0));
            }
            
            // xmlbrandgielda
            if (isset($_POST['xmlbrandgielda']) && $_POST['xmlbrandgielda'] === "on") {
                Configuration::updateValue('xmlbrandgielda', intval(1));
            } else {
                Configuration::updateValue('xmlbrandgielda', intval(0));
            }
            // xmldescriptiongielda
            if (isset($_POST['xmldescriptiongielda']) && $_POST['xmldescriptiongielda'] != 0) {
                Configuration::updateValue('xmldescriptiongielda', intval($_POST['xmldescriptiongielda']));
            }
            
            //weight products
            if (isset($_POST['xmlweightgielda']) && $_POST['xmlweightgielda'] === "on") {
                Configuration::updateValue('xmlweightgielda', intval(1));
            } else {
                Configuration::updateValue('xmlweightgielda', intval(0));
            }
            if (isset($_POST['xmlbasketgielda']) && $_POST['xmlbasketgielda'] === "on") {
                Configuration::updateValue('xmlbasketgielda', intval(1));
            } else {
                Configuration::updateValue('xmlbasketgielda', intval(0));
            }
            if (isset($_POST['xmlfeaturegielda']) && $_POST['xmlfeaturegielda'] === "on") {
                Configuration::updateValue('xmlfeaturegielda', intval(1));
            } else {
                Configuration::updateValue('xmlfeaturegielda', intval(0));
            }
            //zaokr
           if (isset($_POST['xmlshopzaokrgielda'])) {
                Configuration::updateValue('xmlshopzaokrgielda', $_POST['xmlshopzaokrgielda']);
            }       
            $this->generateFileList();
        }
        
        $output = '<h2>' . 'XML Strona konfiguracyjna' . '</h2>';
        $output .= $this->_displayFormGIELDA();
        $output .= $this->_displayForm();
              
        // Link to generated files
        $output .= '<fieldset class="space width3">
        <legend>Pliki</legend>
        <p><b>Generuj linki do plików</b></p>';
        if (Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE')) {
        $id_shop = $this->context->shop->id;
        } else {
            $id_shop = 0;
        }
        // Get active langs on shop
        $xmlshopzaokrgielda = Configuration::get('xmlshopzaokrgielda');
        $languages = Language::getLanguages();
        $xmlcategorygielda = Configuration::get('xmlcategorygielda');
        $xmlmangielda = Configuration::get('xmlmangielda');
        foreach ($languages as $i => $lang) {
            if (Configuration::get('xmlgieldaroot') == 1) {
                $get_file_url = $this->uri .'gieldaxml-'.$id_shop.'-'.$lang['iso_code'].'-'.$xmlcategorygielda .'-'.$xmlmangielda.'.xml';
            } else {
                $get_file_url = $this->uri . 'modules/' . $this->getName() . '/file_exports/gieldaxml'.$id_shop.'-'. $lang['iso_code'] . '-' . $xmlcategorygielda . '-' . $xmlmangielda .'.xml';
            }
            
            $output .= '<a href="' . $get_file_url . '">' . $get_file_url . '</a><br />';
         }
       
        
        $output .= '<hr>';
        $output .= '<p><b>Automatyczne generowanie pliku</b></p>';
        $output .= 'Aktualizuj plik poprzez CRON';
        $output .= '<br/>';
        $output .= $this->uri . 'modules/' . $this->getName() . '/cron.php' . '</p>';
        $output .= '</fieldset>';
        
        
        return $output;
    }
    private function _displayFormGIELDA()
	{
		$form = '
         <form action="' . $_SERVER['REQUEST_URI'] . '" method="post" target="formresponsegieldacat">
         <fieldset class="space width3">
         <legend>Kategorie Twoja Giełda</legend>
         </br>
		<center><input name="formresponsegieldacat" type="submit" value="Pobierz aktualne kategorie"></center>
		</fieldset>
		</form>
		';
	$form .= '
	<iframe name="formresponsegielda" width="1" height="1">'.self::_getcatGIELDA().'</iframe>
	';
	return $form;
	}
    
    private function _displayForm()
    {
        
        $options            = '';
        $xmlmpmgielda        = '';
        $xmlgieldaroot 		= '';
        $xmlquantitygielda   = '';
        $xmlmagazyngielda    = '';
        $xmlbrandgielda      = '';
        $xmlgtingielda       = '';
        $selected_short     = '';
        $selected_long      = '';
        $xmlweightgielda     = '';
        $xmlbasketgielda		='';
        $xmlfeaturegielda	='';
        $xmlshopzaokrgielda	= '';
               
        // Check if you want generate file on root
        if (Configuration::get('xmlgieldaroot') == 1) {
            $xmlgieldaroot = "checked";
        }
        
        // gielda optional tags
        if (Configuration::get('xmlgtingielda') == 1) {
            $xmlgtingielda = "checked";
        }
        if (Configuration::get('xmlmpmgielda') == 1) {
            $xmlmpmgielda = "checked";
        }
        if (Configuration::get('xmlquantitygielda') == 1) {
            $xmlquantitygielda = "checked";
        }
        if (Configuration::get('xmlmagazyngielda') == 1) {
            $xmlmagazyngielda = "checked";
        }
        if (Configuration::get('xmlbrandgielda') == 1) {
            $xmlbrandgielda = "checked";
        }
        if (Configuration::get('xmlweightgielda') == 1) {
            $xmlweightgielda = "checked";
        }
        if (Configuration::get('xmlbasketgielda') == 1) {
            $xmlbasketgielda = "checked";
        }
        if (Configuration::get('xmlfeaturegielda') == 1) {
            $xmlfeaturegielda = "checked";
        }
        
              
        (intval(Configuration::get('xmldescriptiongielda')) === intval(1)) ? $selected_short = "selected" : $selected_long = "selected";
        
    $path_parts = pathinfo(__FILE__);
	$string = $path_parts["dirname"] . '/file_import/gieldacat.xml';
	$xmlc = simplexml_load_file($string);
	$form ='';
    if (!empty($xmlc)) {
    $ccat = $xmlc ->xpath('//Name');
	$coma = implode('","',$ccat);
    $tmpjq = $this->uri . 'modules/' . $this->getName() . '/file_import/jquery-ui.min.js';
    $tmpcss = $this->uri . 'modules/' . $this->getName() . '/file_import/jquery.autocomplete.css';
    $form = '
<script src="'.$tmpjq.'"></script>
<link rel="stylesheet" href="'.$tmpcss.'">
<script>
  $(function() {
    var availableTags = ["'.$coma.'"];
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
	$( "#tags" )
      
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
          event.preventDefault();
        }
      })
    .autocomplete({
        minLength: 0,
        source: function( request, response ) {
          // delegate back to autocomplete, but extract the last term
          response( $.ui.autocomplete.filter(
            availableTags, extractLast( request.term ) ) );
        },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {
          var terms = split( this.value );
          // remove the current input
          terms.pop();
          // add the selected item
          terms.push( ui.item.value );
          // add placeholder to get the comma-and-space at the end
          terms.push( "" );
          this.value = terms.join( ", " );
          return false;
          }
      });
  });  
  </script>';
     }
     $form .= '
		<div id="sea">
           <fieldset>
           <legend>Informacje</legend>
           <p style="font-size: 1.5em; font-weight: bold; padding-bottom: 0">' . $this->displayName . ' ' . $this->version . '</p>
           <p style="clear: both">
            <br/>1. Seo&url - opcja musi być włączona w sklepie 
			<br/>2. Musisz wybrać kategorie. Wyszukaj je poniżej. 
			<br/>3. Instrukcja dla Twoja Giełda 
			<br/>4. Nazwa grupy - Informacja z jakiej branży pochodzą oferty. Możliwe do wyboru: Twoja Giełda, Giełda Biegowa, Giełda Rowerowa, Giełda Sportowa, Giełda Dom, Giełda Dziecko, Giełda Elektroniczna, Giełda Praca, Giełda Moto, Inne (pozostałe nie wymienione branże). Opcjonalnie 
			<br/>5. Typ zdjęcia - wybierz prawidłowy typ zdjęcia [z zakładki konfiguracja / zdjęcia] 
			<br/>6. Generuj plik XML dla strony sklepu - Twój plik będzie znajdował się do adresem www.yoursite.com/gieldaxml-iso.xml 
			<br/>7. Dostępność produktu: dostępność produktu. Dostępne opcje [1, 3, 7, 14, 99] gdzie: 1 – dostępny, sklep wyśle produkt w ciągu 24 godzin, 3 – sklep wyśle produkt do 3 dni, 7 – sklep wyśle produkt w ciągu tygodnia, 14 – produkt zostanie wysłany nie wcześniej niż za tydzień, 99 – brak informacji o dostępności – status „sprawdź w sklepie”. Podane wartości muszą być zgodnie ze stanem faktycznym, znacznik nie może pozostawać pusty czy też posiadać wartość „0”. 
			<br/>8. referencje produktu - pokaż referencje produktu. 
			<br/>9. Ilość produktu - stan magazynowy. Dostępne opcje [liczba] 
			<br/>10. Producent - Pokaż markę - nazwę producenta. 
			<br/>11. EAN13 - podaje kod kreskowy produktu. 
			<br/>12. Waga - podaje wagę produktu. 
			<br/>13. Polecane produkty - włącz tą opcję jeśli Twój sklep posiada polecane produkty 
			<br/>14. Limit - limit produktów w zapytaniu 
			<br/>15. ID Kategorii - tylko produkty ze wskazanej kategorii. Ustaw 0 dla wszystkich produktów 
			<br/>16. Ilość zdjęć - ustaw ilość zdjęć dostępnych dla produktu. Minimum to 1. 
			<br/>17. Magazyn - włącz tą opcję jeśli nie prowadzisz magazynu. Wszystkie produkty będą miały stan 1 
			<br/>18. Id producenta - id producenta dla którego ma pobrać produkty. Ustaw 0 aby wyłączyć. 
			<br/>19. Szukaj - Zacznij wpisywać kategorie. Po znalezieniu wszystkich kategorii skopiuj wartość tego pola do kategorii w sklepie. 
			<br/>20. Pobierz aktualne kategorie - naciśnij przycisk aby pobrać aktualne kategorie dla serwisu Twoja Giełda
			   </p>
		</fieldset>
		
		
		
       <fieldset class="space width3 right">
          <legend>Szukaj kategorii</legend>
				<p style="font-size: 1.5em; font-weight: bold; padding-bottom: 0"Szukaj kategorii dla serwisu Twoja Giełda:</p>
		<input type="text" id="tags" value="" style="width:100%;height:31px;">
		<legend style="font-size: 12px">Zacznij wpisywać nazwy kategorii. Po znalezieniu wszystkich kategorii skopiuj i wklej do odpowiedniej kategorii sklep</legend>
</fieldset>	
		
       <fieldset class="space width3">
          <legend>Parametry</legend>';
           $form .= '
          <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
          <label>' . 'Typ opisu' . ' </label>
          <div class="margin-form">
            <select name="xmldescriptiongielda">
               <option value="1" ' . $selected_short . '>Krótki opis</option>
               <option value="2" ' . $selected_long . '>Długi opis</option>
           </select>
       </div>';
        
        $languages = Language::getLanguages();
        $category = Db::getInstance()->executeS('SELECT `id_category` FROM `'._DB_PREFIX_.'category` WHERE `active` = 1 AND id_category > 1');
         foreach ($languages as $i => $lang) {
			foreach ($category as $j => $row) {
			 $cname = Db::getInstance()->executeS('SELECT `name` FROM `'._DB_PREFIX_.'category_lang` WHERE `id_category` =' . $row['id_category']. ' AND id_lang ='. $lang['id_lang']); 
				 foreach ($cname as $k => $ws) {
            $form .= '<label title="product_type_' . $lang['iso_code'] . '">Kategoria Giełdy w ' . strtoupper($lang['iso_code']) . ' ' . $ws['name'] . '</label>
            <div class="margin-form">
            <input type="text" name="xmlcategorytypegielda' . $lang['iso_code'].''.$row['id_category'] . '" value="' . (Configuration::get('xmlcategorytypegielda' . $lang['iso_code'].''.$row['id_category'])).'" size="80">
        </div>';
				}
			}
        }
        $form .= '<label title="[xmlgroupnamegielda]">Nazwa grupy </label>
    <div class="margin-form">
        <input type="text" name="xmlgroupnamegielda" value="' . ((Configuration::get('xmlgroupnamegielda')!= '')? (Configuration::get('xmlgroupnamegielda')) : 'other') .'">
		<legend>Informacja z jakiej branży pochodzą oferty. Możliwe: Twoja Giełda, Giełda Biegowa, Giełda Rowerowa, Giełda Sportowa, Giełda Dom, Giełda Dziecko, Giełda Elektroniczna, Giełda Praca, Giełda Moto, Inne (pozostałe nie wymienione branże). Opcjonalnie </legend>
    </div>

    <label title="Available">Dostępne</label>
    <div class="margin-form">
        <input type="text" name="xmlavailablegielda" value="' . ((Configuration::get('xmlavailablegielda') != '') ? (Configuration::get('xmlavailablegielda')) : '1') . '">
		<legend>dostepnosc produktów. Dostepne opcje [1, 3, 7, 14, 99] gdzie: 1 - dostępny, sklep wyśle produkt w ciągu 24 godzin, 3 - sklep wyśle produkt do 3 dni, 7 - sklep wyśle produkt w ciągu tygodnia, 14 - produkt zostanie wysłany nie wcześniej niż w tygodniu 99 - brak informacji o dostępności - status „brak w magazynie"</legend> 
    </div>

    <label title="[image]">Zdjęcie typ </label>
    <div class="margin-form">
        <input type="text" name="image" value="' . ((Configuration::get('xmlimagegielda') != '') ? (Configuration::get('xmlimagegielda')) : 'large_default') . '">
    </div>
    
    <hr>
    
    <label title="[xmllimitgielda]">Limit </label>
    <div class="margin-form">
        <input type="text" name="xmllimitgielda" value="' . ((Configuration::get('xmllimitgielda')!= '')? (Configuration::get('xmllimitgielda')) : '100') .'">
    </div>
     <label title="[xmlcategorygielda]">Kategoria </label>
    <div class="margin-form">
        <input type="text" name="xmlcategorygielda" value="' . ((Configuration::get('xmlcategorygielda')!= '')? (Configuration::get('xmlcategorygielda')) : '0') .'">
    </div> 
     <label title="[xmlcategoriesgielda]"> WYKLUCZ kategorie</label>
    <div class="margin-form">
        <input type="text" name="xmlcategoriesgielda" value="' . ((Configuration::get('xmlcategoriesgielda')!= '')? (Configuration::get('xmlcategoriesgielda')) : '0') .'">
        <legend>Ustaw 0, aby wyłączyć funkcję lub wprowadź wartości rozdzielane przecinkami: 2,5,6</legend>     
    </div> 
     <label title="[xmlmangielda]"> Id producenta </label>
    <div class="margin-form">
        <input type="text" name="xmlmangielda" value="' . ((Configuration::get('xmlmangielda')!= '')? (Configuration::get('xmlmangielda')) : '0') .'">
    </div> 
    <label title="[xmliloscgielda]">Ilośc zdjęć</label>
     <div class="margin-form">
        <input type="text" name="xmliloscgielda" value="' . ((Configuration::get('xmliloscgielda')!= '')? (Configuration::get('xmliloscgielda')) : '5') .'">
    </div> 
    <label title="[xmlshopzaokrgielda]">Rodzaj zaokrąglenia</label>
     <div class="margin-form">
        <input type="text" name="xmlshopzaokrgielda" value="' . ((Configuration::get('xmlshopzaokrgielda')!= '')? (Configuration::get('xmlshopzaokrgielda')) : '2') .'">
    </div> 
    <hr>

    <table>
        <tr>
           <td><label>Wygeneruj pliki do katalogu głównego witryny</label></td>
           <td><input type="checkbox" name="generate_root" ' . $xmlgieldaroot . '></td>
       </tr>
       <tr>
           <td><label title="[xmlbrandgielda]">Marka</label></td>
           <td><input type="checkbox" name="xmlbrandgielda" ' . $xmlbrandgielda . ' title="Polecane"></td>
       </tr>
   </table>
   <br>
   <center><input name="generate" type="submit" value="Generuj"></center>
</fieldset>
</form>
';
        return $form;
    }
    
    public function getName()
    {
        $output = $this->name;
        return $output;
    }
    

    
    public function generateFileList()
    {
        // Get all shop languages
        $languages = Language::getLanguages();
        foreach ($languages as $i => $lang) {
            $this->generateFile($lang);
        }
    }
    
    private function rip_tags($string)
    {
        
        // ----- remove HTML TAGs ----- 
        $string = preg_replace('/<[^>]*>/', ' ', $string);
        
        // ----- remove control characters ----- 
        $string = str_replace("\r", '', $string); // --- replace with empty space
        $string = str_replace("\n", ' ', $string); // --- replace with space
        $string = str_replace("\t", ' ', $string); // --- replace with space
        
      
        $string = trim(preg_replace('/ {2,}/', ' ', $string));
        
        return $string;
        
    }
	 private function generateFile($lang)
    {
        $path_parts = pathinfo(__FILE__);
        $xmllimitgielda = Configuration::get('xmllimitgielda');
        $xmlcategorygielda = Configuration::get('xmlcategorygielda');
        $xmlmangielda = Configuration::get('xmlmangielda');
        $xmlshopzaokrgielda = Configuration::get('xmlshopzaokrgielda');
        $xmlWriter = new XMLWriter();
		$xmlWriter->openMemory();
        if (Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE')) {
            $id_shop = $this->context->shop->id;
        } else {
            $id_shop = 0;
        }
        
        if (Configuration::get('xmlgieldaroot')) {
            $generate_file_path = $path_parts["dirname"] .'/../../gieldaxml-'. $id_shop. '-'.$lang['iso_code'].'-'.$xmlcategorygielda. '-' . $xmlmangielda .'.xml';
            unlink($generate_file_path);
        } else {
            $generate_file_path = $path_parts["dirname"] . '/file_exports/gieldaxml'. $id_shop. '-' . $lang['iso_code'] . '-' .$xmlcategorygielda. '-' . $xmlmangielda .'.xml';
            unlink($generate_file_path);
        }
        file_put_contents($generate_file_path, $xmlWriter->flush(), FILE_APPEND);
		$xmlWriter->startDocument('1.0', 'UTF-8');
		$xmlWriter->text('<offers xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="1">');
		$xmlcat = Configuration::get('xmlcategorygielda');
		$xmlmangielda = Configuration::get('xmlmangielda');
		$xmlcategoriesgielda = Configuration::get('xmlcategoriesgielda');
		$xmlWriter->startElement('group');
		$xmlWriter->writeattribute("name",Configuration::get('xmlgroupnamegielda'));
		$id_product = 0;
		if ($xmlcategoriesgielda == 0) {
			if ($xmlcat == 0 and $xmlmangielda == 0) {
			$sql = 'SELECT p.id_product, p. id_manufacturer, p.reference, p.weight, p.on_sale, pl.id_lang, p.id_category_default, pl.link_rewrite, p.ean13, pl. name, pl.description, pl.description_short FROM ' . _DB_PREFIX_ . 'product p' . ' INNER JOIN ' . _DB_PREFIX_ . 'product_lang pl ON p.id_product = pl.id_product' . ' WHERE p.active = 1 AND p.`id_product` > '.(int)$id_product.(($this->tableColumnExists(_DB_PREFIX_.'product_lang', 'id_shop')) ? ' AND pl.`id_shop` = '.(int)$this->context->shop->id : ''). ' AND pl.`id_lang` = '.(int)$lang['id_lang'].' ORDER BY `id_product` ASC LIMIT ' . $xmllimitgielda;
			} elseif ($xmlcat != 0 AND $xmlmangielda == 0) {
			$sql = 'SELECT p.id_product, p. id_manufacturer, p.reference, p.weight, p.on_sale, pl.id_lang, p.id_category_default, pl.link_rewrite, p.ean13, pl. name, pl.description, pl.description_short FROM ' . _DB_PREFIX_ . 'product p' . ' INNER JOIN ' . _DB_PREFIX_ . 'product_lang pl ON p.id_product = pl.id_product' . ' WHERE p.active = 1 AND p.`id_product` > '.(int)$id_product.(($this->tableColumnExists(_DB_PREFIX_.'product_lang', 'id_shop')) ? ' AND pl.`id_shop` = '.(int)$this->context->shop->id : ''). ' AND pl.`id_lang` = '.(int)$lang['id_lang']. ' AND p.id_category_default = ' . $xmlcategorygielda . ' ORDER BY `id_product` ASC LIMIT ' . $xmllimitgielda;
			} elseif ($xmlcat == 0 AND $xmlmangielda != 0) {
			$sql = 'SELECT p.id_product, p. id_manufacturer, p.reference, p.weight, p.on_sale, pl.id_lang, p.id_category_default, pl.link_rewrite, p.ean13, pl. name, pl.description, pl.description_short FROM ' . _DB_PREFIX_ . 'product p' . ' INNER JOIN ' . _DB_PREFIX_ . 'product_lang pl ON p.id_product = pl.id_product' . ' WHERE p.active = 1 AND p.`id_product` > '.(int)$id_product.(($this->tableColumnExists(_DB_PREFIX_.'product_lang', 'id_shop')) ? ' AND pl.`id_shop` = '.(int)$this->context->shop->id : ''). ' AND pl.`id_lang` = '.(int)$lang['id_lang'].  ' AND p.id_manufacturer = ' . $xmlmangielda . ' ORDER BY `id_product` ASC LIMIT ' . $xmllimitgielda;
			} elseif ($xmlcat != 0 AND $xmlmangielda != 0) {
			$sql = 'SELECT p.id_product, p. id_manufacturer, p.reference, p.weight, p.on_sale, pl.id_lang, p.id_category_default, pl.link_rewrite, p.ean13, pl. name, pl.description, pl.description_short FROM ' . _DB_PREFIX_ . 'product p' . ' INNER JOIN ' . _DB_PREFIX_ . 'product_lang pl ON p.id_product = pl.id_product' . ' WHERE p.active = 1 AND p.`id_product` > '.(int)$id_product.(($this->tableColumnExists(_DB_PREFIX_.'product_lang', 'id_shop')) ? ' AND pl.`id_shop` = '.(int)$this->context->shop->id : ''). ' AND pl.`id_lang` = '.(int)$lang['id_lang'].  ' AND p.id_manufacturer = ' . $xmlmangielda . ' AND p.id_category_default = ' . $xmlcat . ' ORDER BY `id_product` ASC LIMIT ' . $xmllimitgielda;
			}
        }else{
			if ($xmlcat == 0 and $xmlmangielda == 0) {
			$sql = 'SELECT p.id_product, p. id_manufacturer, p.reference, p.weight, p.on_sale, pl.id_lang, p.id_category_default, pl.link_rewrite, p.ean13, pl. name, pl.description, pl.description_short FROM ' . _DB_PREFIX_ . 'product p' . ' INNER JOIN ' . _DB_PREFIX_ . 'product_lang pl ON p.id_product = pl.id_product' . ' WHERE p.id_category_default NOT IN ('.$xmlcategoriesgielda.') AND p.active = 1 AND p.`id_product` > '.(int)$id_product.(($this->tableColumnExists(_DB_PREFIX_.'product_lang', 'id_shop')) ? ' AND pl.`id_shop` = '.(int)$this->context->shop->id : ''). ' AND pl.`id_lang` = '.(int)$lang['id_lang'].' ORDER BY `id_product` ASC LIMIT ' . $xmllimitgielda;
			} elseif ($xmlcat != 0 AND $xmlmangielda == 0) {
			$sql = 'SELECT p.id_product, p. id_manufacturer, p.reference, p.weight, p.on_sale, pl.id_lang, p.id_category_default, pl.link_rewrite, p.ean13, pl. name, pl.description, pl.description_short FROM ' . _DB_PREFIX_ . 'product p' . ' INNER JOIN ' . _DB_PREFIX_ . 'product_lang pl ON p.id_product = pl.id_product' . ' WHERE p.id_category_default NOT IN ('.$xmlcategoriesgielda.') AND p.active = 1 AND p.`id_product` > '.(int)$id_product.(($this->tableColumnExists(_DB_PREFIX_.'product_lang', 'id_shop')) ? ' AND pl.`id_shop` = '.(int)$this->context->shop->id : ''). ' AND pl.`id_lang` = '.(int)$lang['id_lang']. ' AND p.id_category_default = ' . $xmlcategorygielda . ' ORDER BY `id_product` ASC LIMIT ' . $xmllimitgielda;
			} elseif ($xmlcat == 0 AND $xmlmangielda != 0) {
			$sql = 'SELECT p.id_product, p. id_manufacturer, p.reference, p.weight, p.on_sale, pl.id_lang, p.id_category_default, pl.link_rewrite, p.ean13, pl. name, pl.description, pl.description_short FROM ' . _DB_PREFIX_ . 'product p' . ' INNER JOIN ' . _DB_PREFIX_ . 'product_lang pl ON p.id_product = pl.id_product' . ' WHERE p.id_category_default NOT IN ('.$xmlcategoriesgielda.') AND p.active = 1 AND p.`id_product` > '.(int)$id_product.(($this->tableColumnExists(_DB_PREFIX_.'product_lang', 'id_shop')) ? ' AND pl.`id_shop` = '.(int)$this->context->shop->id : ''). ' AND pl.`id_lang` = '.(int)$lang['id_lang'].  ' AND p.id_manufacturer = ' . $xmlmangielda . ' ORDER BY `id_product` ASC LIMIT ' . $xmllimitgielda;
			} elseif ($xmlcat != 0 AND $xmlmangielda != 0) {
			$sql = 'SELECT p.id_product, p. id_manufacturer, p.reference, p.weight, p.on_sale, pl.id_lang, p.id_category_default, pl.link_rewrite, p.ean13, pl. name, pl.description, pl.description_short FROM ' . _DB_PREFIX_ . 'product p' . ' INNER JOIN ' . _DB_PREFIX_ . 'product_lang pl ON p.id_product = pl.id_product' . ' WHERE p.id_category_default NOT IN ('.$xmlcategoriesgielda.') AND p.active = 1 AND p.`id_product` > '.(int)$id_product.(($this->tableColumnExists(_DB_PREFIX_.'product_lang', 'id_shop')) ? ' AND pl.`id_shop` = '.(int)$this->context->shop->id : ''). ' AND pl.`id_lang` = '.(int)$lang['id_lang'].  ' AND p.id_manufacturer = ' . $xmlmangielda . ' AND p.id_category_default = ' . $xmlcat . ' ORDER BY `id_product` ASC LIMIT ' . $xmllimitgielda;
			}
	    }
        $products = Db::getInstance()->ExecuteS($sql);
        
        $title_limit       = 70;
        $description_limit = 10000;
        
        $languages     = Language::getLanguages();
        $tailleTabLang = sizeof($languages);
        
        foreach ($products as $product) {
			$cat_link_rew       = Category::getLinkRewrite($product['id_category_default'], intval($lang));    
            //continue if product not have price
            $price = Product::getPriceStatic($product['id_product'], true, NULL,$xmlshopzaokrgielda);
            if (empty($price)) {
                continue;
            }
            $product_link = $this->context->link->getProductLink((int) ($product['id_product']), $product['link_rewrite'], $cat_link_rew, $product['ean13'], (int) ($product['id_lang']),$id_shop, 0, true);
            
            $title_crop = $product['name'];
            $title_crop = strip_tags($title_crop);
            if (strlen($product['name']) > $title_limit) {
                $title_crop = substr($title_crop, 0, ($title_limit - 1));
                $title_crop = substr($title_crop, 0, strrpos($title_crop, " "));
            }
            
            if (intval(Configuration::get('xmldescriptiongielda')) === intval(2)) {
                $description_crop = $product['description'];
            } else {
                $description_crop = $product['description_short'];
            }
            $description_crop = $this->rip_tags($description_crop);
                if (strlen($description_crop) > $description_limit) {
                $description_crop = substr($description_crop, 0, ($description_limit - 1));
                $description_crop = substr($description_crop, 0, strrpos($description_crop, " "));
                }
			  $xmlWriter->startElement('o');
			 $xmlWriter->writeattribute("id",$product['id_product']);
			 $xmlWriter->writeattribute("url",htmlspecialchars($product_link, self::REPLACE_FLAGS, self::CHARSET, false));
			 $xmlWriter->writeattribute("price",$price);
			 $xmlWriter->writeattribute("avail",Configuration::get('xmlavailablegielda'));
			 
            // Category gielda
                $xmlWriter->startElement('na');
        if (Configuration::get('xmlcategorytypegielda' . $lang['iso_code'].$product['id_category_default'])) {
                $product_type = Configuration::get('xmlcategorytypegielda' . $lang['iso_code'].$product['id_category_default']);
			    $product_type = explode(',', $product_type);
               
			   	$string = $path_parts["dirname"] . '/file_import/gieldacat.xml';
	$div = simplexml_load_file($string);
 $res =  $div->xpath('//Category[Name = "'.$product_type[0].'"]');
   
        $xmlWriter->writeattribute("cat", $res[0]->Id);

                }
            $title_crop = $product['name'];
            $title_crop = strip_tags($title_crop);
            if (strlen($product['name']) > $title_limit) {
                $title_crop = substr($title_crop, 0, ($title_limit - 1));
                $title_crop = substr($title_crop, 0, strrpos($title_crop, " "));
                }
            $xmlWriter->writeCData(htmlspecialchars(ucfirst(mb_strtolower($title_crop, self::CHARSET)), self::REPLACE_FLAGS, self::CHARSET));
            $xmlWriter->endElement();
            
            $images = Image::getImages($lang['id_lang'], $product['id_product']);
            $indexTabLang = 0;
            if ($tailleTabLang > 1) {
                while (sizeof($images) < 1 && $indexTabLang < $tailleTabLang) {
                    if ($languages[$indexTabLang]['id_lang'] != $lang['id_lang']) {
                        $images = Image::getImages($languages[$indexTabLang]['id_lang'], $product['id_product']);
                    }
                    $indexTabLang++;
                }
            }
            $nbimages   = 0;
            $imgcover = Image::getCover($product['id_product']);
            $image_type = Configuration::get('xmlimagegielda');
            $xmliloscimg = Configuration::get('xmliloscgielda');
			
				$images2='';

            if ($image_type == '')
            $image_type = 'large_default';
            		$image = $this->context->link->getImageLink($product['link_rewrite'], $product['id_product'] . '-' . $imgcover['id_image'], $image_type);
					$image = preg_replace('*http://'.Tools::getHttpHost().'/*',$this->uri,$image);
					$images2.=trim($image).'|';
				
                foreach ($images as $im) {
                if($im['cover'] != '1'){	
                $image = $this->context->link->getImageLink($product['link_rewrite'], $product['id_product'] . '-' . $im['id_image'], $image_type);
                $image = preg_replace('*http://'.Tools::getHttpHost().'/*',$this->uri,$image);

				$images2.=trim($image).'|';

                }
                if (++$nbimages == $xmliloscimg)
                    break;
                }  

$xmlWriter->writeElement("img", $images2);



            if(!empty($description_crop)){
            $xmlWriter->startElement('de');
			$xmlWriter->writeCData(htmlspecialchars($description_crop, self::REPLACE_FLAGS, self::CHARSET));
			$xmlWriter->endElement();
			}
			

			    if (Configuration::get('xmlbrandgielda') && !empty($product['id_manufacturer'])) {
                $xmlWriter->startElement('br');
                $xmlWriter->writeCData(htmlspecialchars(Manufacturer::getNameById(intval($product['id_manufacturer'])), self::REPLACE_FLAGS, self::CHARSET, false));
                $xmlWriter->endElement();
               }
			   
            if (Configuration::get('xmlmpmgielda') && !empty($product['reference'])) {
                $xmlWriter->startElement('a');
                $xmlWriter->writeattribute('name','Kod_producenta');
                $xmlWriter->writeCData(htmlspecialchars($product['reference'], self::REPLACE_FLAGS, self::CHARSET));
                $xmlWriter->endElement();
               }
            if (Configuration::get('xmlgtingielda') && !empty($product['ean13'])) {
                $xmlWriter->startElement('a');
                $xmlWriter->writeattribute('name','EAN');
                $xmlWriter->writeCData(htmlspecialchars($product['ean13'], self::REPLACE_FLAGS, self::CHARSET));
                $xmlWriter->endElement();
                }

            if (Configuration::get('xmlfeaturegielda') == 1) {
			$fs = Product::getFrontFeaturesStatic($lang['id_lang'],$product['id_product']);
			foreach ($fs as $rows) {
			$xmlWriter->startElement('a');
			$xmlWriter->writeattribute('name',str_replace(' ', '',$rows['name']));
			$xmlWriter->writeCData(htmlspecialchars($rows['value'], self::REPLACE_FLAGS, self::CHARSET));
			$xmlWriter->endElement();
			}
			}//f
			// type
			
	
	
	//SELECT * FROM `ps_product_attribute` WHERE `id_product`='2' limit 1
	
/*			 $sql = 'SELECT id_product_attribute FROM ' . _DB_PREFIX_ . 'product_attribute WHERE id_product="'.$product['id_product'].'" limit 1';
 $products2=NULL;

        $products2 = Db::getInstance()->ExecuteS($sql);




			$xmlWriter->startElement('type');
		if($products2==NULL){
            $quantity = StockAvailable::getQuantityAvailableByProduct($product['id_product'], 0);
            $xmlWriter->writeattribute("item",$quantity);
			$xmlWriter->writeCData('simple');
		}

		
		if($products2!=NULL){
$product = new Product($product['id_product']);
$id_lang = Context::getContext()->language->id;
$combinations = $product->getAttributeCombinations((int)$id_lang, true);

$allti= count($combinations);		


foreach ($combinations as $c){
 $result2[$c['id_product_attribute']][] = $c;
		}

$ilegrup0=count($result2);

$xmlWriter->writeattribute("item",$ilegrup0);

			$xmlWriter->writeCData('nosimple');
		
 $ilegrup= ($allti/count($result2))-1;
 

$fvall='';
for ($i = 1; $i <= count($result2); $i++) {

for ($a = 0; $a <= count($ilegrup); $a++) {
	if($a < count($ilegrup)){
$fvall.=$result2[$i][$a]['attribute_name'];
	}
else {
$fvall.=', '.$result2[$i][$a]['attribute_name'];
}
}
$fvall.= '|';
}
		}
*/

 $sql = 'SELECT id_product_attribute FROM ' . _DB_PREFIX_ . 'product_attribute WHERE id_product="'.$product['id_product'].'" limit 1';
 $products2=NULL;
$product_id=(int)$product['id_product'];
        $products2 = Db::getInstance()->ExecuteS($sql);




			$xmlWriter->startElement('type');
		if($products2==NULL){
            $quantity = StockAvailable::getQuantityAvailableByProduct($product['id_product'], 0);
            $xmlWriter->writeattribute("item",$quantity);
			$xmlWriter->writeCData('simple');
		}

		
		if($products2!=NULL){
$product = new Product($product['id_product']);
$id_lang = Context::getContext()->language->id;
$combinations = $product->getAttributeCombinations((int)$id_lang, true);

$allti= count($combinations);		


$arr = array();
foreach ($result2 as $key => $item) {
   $arr[$item['id_product']][$key] = $item;
}


$fvall=NULL;
foreach ($combinations as $c){
	$arr[$c['id_product_attribute']][] = $c;
		}
		
$arr = array_values($arr);		

ksort($arr, SORT_NUMERIC);

$ilegrup= ($allti/count($arr))-1;

	for ($i = 1; $i <= count($arr); $i++) {
	
		for ($a = 0; $a <= $ilegrup; $a++) {
			if($a==$ilegrup){
				$fvall.= $arr[$i][$a]['attribute_name'].'|';
			}else{
				$fvall.= $arr[$i][$a]['attribute_name'].', ';
			}
		}
	}


}





		 
			$xmlWriter->endElement();
	if(!empty($fvall)){	
	$fvall=str_replace('|, |','',$fvall);
	$fvall=str_replace('||','',$fvall);
		 
$xmlWriter->writeElement("va", $fvall);
	}
	$fvall=NULL;		
			$xmlWriter->endElement(); //o
		}//end generateFile
		$xmlWriter->endElement();  //g	
		$xmlWriter->text('</offers>');
		
		file_put_contents($generate_file_path, $xmlWriter->flush(), FILE_APPEND);
			@chmod($generate_file_path, 0777);
			return true;
			}
			
private function tableColumnExists($table_name, $column = null)
	{
		if (array_key_exists($table_name, $this->sql_checks))
			if (!empty($column) && array_key_exists($column, $this->sql_checks[$table_name]))
				return $this->sql_checks[$table_name][$column];
			else
				return $this->sql_checks[$table_name];

		$table = Db::getInstance()->ExecuteS('SHOW TABLES LIKE \''.$table_name.'\'');
		if (empty($column))
			if (count($table) < 1)
				return $this->sql_checks[$table_name] = false;
			else
				$this->sql_checks[$table_name] = true;

		else
		{
			$table = Db::getInstance()->ExecuteS('SELECT * FROM `'.$table_name.'` LIMIT 1');
			return $this->sql_checks[$table_name][$column] = array_key_exists($column, current($table));
		}
		return true;
	}
	public function _getcatGIELDA()
	{
	$path_parts = pathinfo(__FILE__);
	$cencats = file_get_contents("https://twojagielda.com/wp-content/xmlfile/xml_gielda.xml");
	@mkdir($path_parts["dirname"] . '/file_import', 0755, true);
    @chmod($path_parts["dirname"] . '/file_import', 0755);
    $cenurl = $path_parts["dirname"] . '/file_import/gieldacat.xml';
    unlink($cenurl);
    file_put_contents($cenurl, $cencats, FILE_APPEND);
    }
}//end fille
?>