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
class Management_Model_Loanamounttypes extends Zend_Db_Table {
	protected $_name = 'ourbank_loanamount_typedetails';


	public function fetchAllloanamounttypes() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('p' => 'ourbank_loanamount_typedetails'),array('loanamount_type_id'))
			->where('p.intereststatus_id = 3 or p.intereststatus_id=1')
			->join(array('q' => 'ourbank_loanamount_types'),'p.loanamount_type_id=q.loanamount_type_id');
			$result = $this->fetchAll($select);
			return $result->toArray();
	}

	public function getloanamounttypeDetails() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('p' => 'ourbank_loanamount_types'),array('loanamount_type_id'));
			$result = $this->fetchAll($select);
			return $result->toArray();
	}

	public function fetchloanamounttypename_id($laonamount_type_description) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('p' => 'ourbank_loanamount_types'),array('loanamount_type_id'))
			->where('p.loanamount_type_id = ?',$laonamount_type_description);
			$result = $this->fetchAll($select);
			return $result->toArray();
	}

	public function Searchloanamounttypes($post = array()) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('b' => 'ourbank_loanamount_typedetails'),array('loanamount_type_id'))
			->where('b.intereststatus_id = 3 OR b.intereststatus_id = 1')
			->join(array('a' => 'ourbank_loanamount_types'),'b.loanamount_type_id = a.loanamount_type_id')
			->where('a.loanamount_type_id like "%" ? "%"',$post['field1'])
			->where('b.loan_amount_from like "%" ? "%"',$post['field2']);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function viewloanamounttypes($loanamount_type_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_loanamount_typedetails'),array('product_id'))
			->where('a.loanamount_type_id = ?',$loanamount_type_id)
			->where('a.intereststatus_id = 3 or a.intereststatus_id = 1')
			->join(array('b' => 'ourbank_loanamount_types'),'a.loanamount_type_id = b.loanamount_type_id');
	          $result = $this->fetchAll($select);
	          return $result->toArray();
  		//die($select->__toString($select));
	}

        public function delete_viewloanamounttypes($loanamount_type_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_loanamount_typedetails'),array('product_id'))
			->where('a.loanamount_typedetails_id = ?',$loanamount_type_id)
			->where('a.intereststatus_id = 3 or a.intereststatus_id = 1')
			->join(array('b' => 'ourbank_loanamount_types'),'a.loanamount_type_id = b.loanamount_type_id');
		$result = $this->fetchAll($select);
		return $result->toArray();
  		die($select->__toString($select));
	}

	public function insertloanamounttypedetails($input = array())
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->db->insert('ourbank_loanamount_typedetails',$input);
	}

	public function deleteloanamounttypes($loanamount_type_id,$remarks) {
		$data = array('intereststatus_id'=> 5,'remarks'=>$remarks);
		$where = 'loanamount_typedetails_id = '.$loanamount_type_id;
		$this->update($data , $where );
	}

	public function interesttypesUpdate($loanamount_type_id)
	{
		$input1=  array('intereststatus_id' => '2');
		$where = "loanamount_type_id = $loanamount_type_id";
		$this->update($input1 , $where);
	} 

}
