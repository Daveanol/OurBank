<?php
/*
############################################################################
#  This file is part of OurBank.
############################################################################
#  OurBank is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as
#  published by the Free Software Foundation, either version 3 of the
#  License, or (at your option) any later version.
############################################################################
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
############################################################################
#  You should have received a copy of the GNU Affero General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
############################################################################
*/
?>

<?php
class Generalledger_IndexController extends Zend_Controller_Action
{
    function init()
    { 
        $this->view->pageTitle = "General Ledger";
        $this->view->title = "Reports";
        $this->view->type = "generalFields";
        $this->view->adm = new App_Model_Adm();
	$this->view->dateconvertor = new App_Model_dateConvertor();
    }
    
    function indexAction()
    { 
        $this->view->pageTitle = "General Ledger";
        $searchForm = new Generalledger_Form_Search();
        $this->view->form = $searchForm;
$officename = $this->view->adm->viewRecord("ourbank_glsubcode","id","DESC");
			foreach($officename as $officename){
				$searchForm->ledger->addMultiOption($officename['id'],$officename['glsubcode'].$officename['header']);
			}




        if ($this->_request->isPost() && $this->_request->getPost('Search')) {
 
        $formData = $this->_request->getPost();
        if ($searchForm->isValid($formData)) {
		$fromDate = $this->view->dateconvertor->mysqlformat($this->_request->getParam('datefrom'));
        $this->view->datefrom = $fromDate;

		$toDate = $this->view->dateconvertor->mysqlformat($this->_request->getParam('dateto'));
        $this->view->dateto = $toDate;

		$glsubcode =$this->_request->getParam('ledger');
        $this->view->search = 10;
        $generalLedger = new Generalledger_Model_Generalledger();
           //Lia
        $this->view->ledegerList = $generalLedger->generalLedger($fromDate,$toDate,$glsubcode);
        $this->view->openingCash = $generalLedger->openingBalance($fromDate,$glsubcode);

          // Assets
        $this->view->ledegerListAssets = $generalLedger->generalLedgerAssets($fromDate,$toDate,$glsubcode);
        $this->view->openingCashAssets = $generalLedger->openingBalanceAssets($fromDate,$glsubcode);
        if(!$glsubcode){      $generalLedger = new Generalledger_Model_Generalledger();
           //Lia
        $this->view->ledegerList = $generalLedger->generalLedgerempty($fromDate,$toDate);
        $this->view->openingCash = $generalLedger->openingBalanceempty($fromDate);

          // Assets
        $this->view->ledegerListAssets = $generalLedger->generalLedgerAssetsempty($fromDate,$toDate);
        $this->view->openingCashAssets = $generalLedger->openingBalanceAssetsempty($fromDate);          }
        } else {   $this->view->search = 0;
                   echo "<font color='red'><b> Record not found</b> </font>";
		        }
	        }
    	}
    public function reportdisplayAction() 
    {
        $this->_helper->layout->disableLayout();
        $file1 = $this->_request->getParam('file'); 
        $app = $this->view->baseUrl();
        $word=explode('/',$app);
        $projname = $word[1];
        $this->view->filename = "/".$projname."/reports/".$file1;    
    
    }
    public function pdfdisplayAction() 
    { 
       $date1 = $this->_request->getParam('date1'); 
       $date2 = $this->_request->getParam('date2');
       $glsubcode = $this->_request->getParam('ledger');


		$generalLedger = new Generalledger_Model_Generalledger();
             //Lia
        $this->view->ledegerList = $generalLedger->generalLedger($date1,$date2,$glsubcode);
        $openingCash = $generalLedger->openingBalance($date1,$glsubcode);
		    // Assets
        $this->view->ledegerListAssets = $generalLedger->generalLedgerAssets($date1,$date2,$glsubcode);
        $this->view->openingCashAssets = $generalLedger->openingBalanceAssets($date1,$glsubcode);
        if((!$this->view->ledegerListAssets) && (!$this->view->openingCashAssets)){        }
		 else {     $this->view->search = 0;
                   echo "<font color='red'><b> Record not found</b> </font>";
		       }
 		if(count($openingCash)) {
          foreach($openingCash as $openingCash) {
        if ($openingCash["glsubcode_id"] == $ledegerList["glsubcode_id"]) {
           $liabilityCash = $openingCash["openingCash"];
             }
           } 
         } 


        $pdf = new Zend_Pdf();
        $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $page;

        $app = $this->view->baseUrl();
        $word=explode('/',$app);
        $projname = $word[1];
        //Image
        $image_name = "/var/www/".$projname."/public/images/logo.jpg";
        $image = Zend_Pdf_Image::imageWithPath($image_name);
        //$page->drawImage($image, 25, 770, 570, 820);
        $page->drawImage($image, 30, 770, 130, 820);
        $page->setLineWidth(1)->drawLine(25, 25, 570, 25); //bottom horizontal
        $page->setLineWidth(1)->drawLine(25, 25, 25, 820); //left vertical
        $page->setLineWidth(1)->drawLine(570, 25, 570, 820); //right vertical
        $page->setLineWidth(1)->drawLine(570, 820, 25, 820); //top horizontal
        //set the font
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 8);
    	$this->view->search = 10;
        $text = array("Particular",
                     "debit",
                     "credit",
                     "balance","Opening balance");
        $x0 = 60; 
        $x1 = 200; 
        $x2 = 340; 
        $x3 = 480;

        $page->drawLine(50, 740, 550, 740);
        $page->drawLine(50, 720, 550, 720);
        $page->drawText($text[0], $x0, 725);
        $page->drawText($text[1], $x1, 725);
        $page->drawText($text[2], $x2, 725);
        $page->drawText($text[3], $x3, 725);
		$page->drawText($text[4], $x0, 700);
		foreach($openingCash as $openingCash) {
			$page->drawText($openingCash["openingCash"],$x3, 700);
		}
		$y1 = 725;


		$pdf->render();
        $pdf->save('/var/www/'.$projname.'/reports/GL.pdf');
		$path = '/var/www/'.$projname.'/reports/GL.pdf';
        chmod($path,0777);
}
}