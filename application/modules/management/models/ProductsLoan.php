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

class Management_Model_ProductsLoan extends Zend_Db_Table {

protected $_name = 'ourbank_productsloan';

public function Addproductsloan($post,$offerproduct_id)
{
  $data = array('offerproductupdate_id'=>$offerproduct_id,
                      'minmumloanamount'=>$post['minmumloanamount'],
                      'maximunloanamount'=>$post['maximunloanamount'],
                      'minimumfrequency'=>$post['minimumfrequency'],
                      'maximumfrequency'=>$post['maximumfrequency'],
                      'graceperiodnumber'=>$post['graceperiodnumber'],
                      'penal_Interest'=>$post['penal_Interest']);
 $this->insert($data);
}

    public function editloanProducts($post) { 
        $sessionName = new Zend_Session_Namespace('ourbank');
        $user_id = $sessionName->primaryuserid;
        $data = array('offerproductupdate_id'=>$offerproductupdate_id,
                      'minmumloanamount'=>$post['minmumloanamount'],
                      'maximunloanamount'=>$post['maximunloanamount'],
                      'minimumloaninterest'=>$post['minimumloaninterest'],
                      'maximunloaninterest'=>$post['maximunloaninterest'],
                      'penal_Interest'=>$post['penal_Interest'],
                      'minimumfrequency'=>$post['minimumfrequency'],
                      'maximumfrequency'=>$post['maximumfrequency'],
                      'graceperiodnumber'=>$post['maximumfrequency']);
        $this->insert($data);
                        
                                    }

}
