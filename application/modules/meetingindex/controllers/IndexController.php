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
class Meetingindex_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
        $this->view->pageTitle='Group meeting';
        $this->view->adm = new App_Model_Adm();
        $this->view->dateconvert = new App_Model_dateConvertor();

        /* Initialize action controller here */
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data)
        {
            $this->_redirect('index/login'); // once session get expired it will redirect to Login page
        }
        $sessionName = new Zend_Session_Namespace('ourbank');
        $userid=$this->view->createdby = $sessionName->primaryuserid; // get the stored session id
        $globalsession=new App_Model_Users();
        $loginname=$globalsession->username($userid);
        foreach($loginname as $loginname) 
        {
            $this->view->username=$loginname['username']; // get the user name
        }

        $test = new DH_ClassInfo(APPLICATION_PATH . '/modules/meetingindex/controllers/');
        $module = $test->getControllerClassNames();
        $modulename = explode("_", $module[0]);
        $this->view->modulename = strtolower($modulename[0]);
    }

    public function indexAction(){
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
            $this->_redirect('index/login');
        }
        $this->view->title = "Group meeting";
        
        $searchForm = new Meeting_Form_Search();
        $this->view->form = $searchForm;
        
        $days = $this->view->adm->viewRecord("ourbank_master_weekdays","id","ASC");
        foreach($days as $days) {
            $searchForm->search_weekdays->addMultiOption($days['id'],$days['name']);
        }
        $meeting = new Meeting_Model_Meeting();
        $result = $meeting->fetchAllmeetingdetails();

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($result);
        $paginator->setItemCountPerPage(5);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;

        if ($this->_request->isPost() && $this->_request->getPost('Search')) {
            $formData = $this->_request->getPost();

                if ($searchForm->isValid($formData)) {
                    $meeting = new Meeting_Model_Meeting();
                    $result = $meeting->SearchMeeting($formData);
                    $page = $this->_getParam('page',1);
                    $paginator = Zend_Paginator::factory($result);
                    $paginator->setItemCountPerPage(5);
                    $paginator->setCurrentPageNumber($page);
                    $this->view->paginator = $paginator;
                }
        }
    }
}
         $this->view->paginator = $paginator;
// //                 }
// //         }
// //     }
// // }
  
        if($_POST)
            $postedvalues = $this->view->adm->commonsearchquery($_REQUEST,1);
	else
	   $postedvalues = $this->view->adm->commonsearchquery($_REQUEST,2); 

         $result = $meeting->SearchMeeting($postedvalues);

        $page = $this->_getParam('page',1);
        $this->view->paginator = $this->view->adm->commonsearch($result,$page);
        $this->view->requestvalues=$this->view->adm->encodedvalue($postedvalues);
         
	}
}	
	