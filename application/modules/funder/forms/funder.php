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
/*
 *  create form elements for funder
 */
class Funder_Form_funder extends Zend_Dojo_Form {

    public function init() {
	//description
        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
	//create instance of form fields
        $formfield = new App_Form_Field ();
        $code = $formfield->field('Text','code','','','','','','','','','','',0,0);
        $name = $formfield->field('Text','name','','','','','','','','','','',0,0);
        $type = $formfield->field('Select','type','','','','','','','','','','',0,0);
        $submit = new Zend_Form_Element_Submit('Search');

	// Add elements to form:
        $this->addElements(array($code,$name,$type,$submit));

    }
}
