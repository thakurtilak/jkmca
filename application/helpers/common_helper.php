<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function matchInArray($haystack, $needles) {
    foreach($needles as $needle){
        if (strpos($haystack, $needle) !== false) {
            return true;
        }
    }
    return false;
}
if ( ! function_exists('isLoggedIn')){
    function isLoggedIn(){
        $CI =& get_instance();
        $user = $CI->session->userdata('user');
        $permissions = $CI->session->userdata('userPermission');
        $currentURL = $CI->uri->uri_string();
        if($CI->uri->segment(3)) {
            $allParts =  explode('/', $currentURL);
            array_pop($allParts);
            $currentURL = implode('/', $allParts);
        }
        $excludes = array('invoice/generate-invoice', 'invoice/invoice-approval', 'dashboard/pending', 'orders/cancel-order', 'projections/downloads');
        if(empty($user)){
            redirect(base_url('login'));
        }elseif(1){
            return (bool)$user;
        } else if($CI->input->is_ajax_request()) { /*Allow all Ajax request with check permission*/
            return (bool)$user;
        } else {
            show_error('You do not have permissions to access this!');
        }
    }
}


if ( ! function_exists('getCurrentUser')){
    function getCurrentUser(){
        $CI =& get_instance();
        $user = $CI->session->userdata('user');
        if(empty($user)){
            redirect(base_url('login'));
        }else{
            return $user;
        }
    }
}


if ( ! function_exists('getCurrentUsersId')){
    function getCurrentUsersId(){
        $CI =& get_instance();
        $user = $CI->session->userdata('user');
        if(empty($user)){
            redirect(base_url('login'));
        }else{
            return $user->id;
        }
    }
}

/*
 * hasApprover
 * Purpose - Check if user has approver or not
 */
function hasApprover($userId){
    $CI =& get_instance();
    //$user = $CI->session->userdata('user');
    $where = array('id' => $userId);
    $userDetail = $CI->common_model->getRecord(TBL_USER, array('is_approver'), $where);
    if($userDetail->is_approver) {
        return true;
    } else {
        return false;
    }
}

/*
 * isApprover
 * Purpose - Check if user has approver of any user or not
 */
function isApprover($userId){
    $CI =& get_instance();
    //$user = $CI->session->userdata('user');
    $where = array('approver_user_id' => $userId);
    $userDetail = $CI->common_model->getRecords(TBL_USER, array('is_approver'), $where);
    if(count($userDetail)) {
        return true;
    } else {
        return false;
    }
}


/*
 * getApprover
 * Purpose - Return the object of approver user
 */
function getApprover($userId){
    $CI =& get_instance();
    //$user = $CI->session->userdata('user');
    $where = array('id' => $userId);
    $userDetail = $CI->common_model->getRecord(TBL_USER, array('is_approver', 'approver_user_id'), $where);
    if($userDetail->is_approver) {
        $where = array('id' => $userDetail->approver_user_id);
        $approverDetail = $CI->common_model->getRecord(TBL_USER, array('*'), $where);
        return $approverDetail;
    } else {
        return false;
    }
}


/*
 * getUserInfo
 * Purpose - Return the object of User record
 */
function getUserInfo($userId){
    $CI =& get_instance();
    $where = array('id' => $userId);
    $userDetail = $CI->common_model->getRecord(TBL_USER, array('*'), $where);
    if($userDetail) {
        return $userDetail;
    } else {
        return false;
    }
}


function getApprovalID($userId){
    $CI =& get_instance();
    $where = array('id' => $userId);
    $approverID = $CI->common_model->getRecord(TBL_USER, array('approver_user_id'), $where);
    if($approverID) {
        return $approverID;
    } else {
        return false;
    }
}

/*
 * getCategoryInfo
 * Purpose - Return the object of Category
 */
function getCategoryInfo($categoryId){
    $CI =& get_instance();
    $where = array('id' => $categoryId);
    $categoryRecord = $CI->common_model->getRecord(TBL_CATEGORY_MASTER, '*', $where);
    if($categoryRecord) {
        return $categoryRecord;
    } else {
        return false;
    }
}

/*
 * getClientInfo
 * Purpose - Return the object of Client
 */
function getClientInfo($clientId){
    $CI =& get_instance();
    $where = array('client_id' => $clientId);
    $clientDetails = $CI->common_model->getRecord(TBL_CLIENT_MASTER, array('client_name', 'address1', 'address2'), $where);
    if($clientDetails) {
        return $clientDetails;
    } else {
        return false;
    }
}

/*
 * getClientSalesPersonInfo
 * Purpose - Return the object of Client's sales manager info
 */
function getClientSalesPersonInfo($salesPersonId){
    $CI =& get_instance();
    $where = array('salesperson_id' => $salesPersonId);
    $salespersonDetails = $CI->common_model->getRecord(TBL_CLIENT_SALESPERSON, array('sales_person_name', 'sales_contact_no', 'sales_person_email'), $where);
    if($salespersonDetails) {
        return $salespersonDetails;
    } else {
        return false;
    }
}


/*
 * getClientAccountPersonInfo
 * Purpose - Return the object of Client's account person
 */
function getClientAccountPersonInfo($accountPersonId){
    $CI =& get_instance();
    $where = array('account_id' => $accountPersonId);
    $accountPersonDetails = $CI->common_model->getRecord(TBL_CLIENT_ACCOUNTPERSON, array('account_person_name', 'account_contact_no', 'account_person_email'), $where);
    if($accountPersonDetails) {
        return $accountPersonDetails;
    } else {
        return false;
    }
}

function getGeneratorsEmailByCategory($category_id){
    $CI =& get_instance();
    $where = array('category_id' => $category_id);
    $generatorIds = $CI->common_model->getRecords(TBL_INVOICE_CATEGORY_GEN_MAPPER, array('generator_user_id'), $where);
    $genIds = array();
    if(count($generatorIds)) {
        foreach($generatorIds as $genId) {
            $genIds[] = $genId->generator_user_id;
        }
    }
    if($genIds) {
        $where = "id IN (".implode(',', $genIds).") AND status= 'A'";
        //$where = array($whereIn);
        $generators = $CI->common_model->getRecords(TBL_USER, array('id','email'), $where);

    }
    $emails = array();
    if(count($generators)) {
        foreach($generators as $gen) {
            $emails[] = $gen->email;
        }
    }

    $where = "FIND_IN_SET( '".GENERATERROLEID."' , role_id) AND status= 'A' AND is_approver IS NULL";
    $generatorsAppr = $CI->common_model->getRecords(TBL_USER, array('id','email'), $where);
    if(count($generatorsAppr)) {
        foreach($generatorsAppr as $genAppr) {

            if(!in_array($genAppr->email, $emails)){
                $emails[] = $genAppr->email;
            }

        }
    }

    if(ENVIRONMENT == 'development') {
        $emails[] = "dharmendra.thakur@webdunia.net";
    }

    return $emails;
}

function getAdministratorEmail(){
    $CI =& get_instance();
    $where = array('role_id'=> SUPERADMINROLEID);
    $administrators = $CI->common_model->getRecords(TBL_USER, array('id','email'), $where);
    $emails = array();
    if(count($administrators)) {
        foreach($administrators as $user) {
            if($user->email != 'dthakur29@gmail.com') {
                $emails[] = $user->email;
            }
        }
    }

    /*$where = "FIND_IN_SET( '".GENERATERROLEID."' , role_id) AND status= 'A' AND is_approver IS NULL";
    $generatorsAppr = $CI->common_model->getRecords(TBL_USER, array('id','email'), $where);
    if(count($generatorsAppr)) {
        foreach($generatorsAppr as $genAppr) {

            if(!in_array($genAppr->email, $emails)){
                $emails[] = $genAppr->email;
            }

        }
    }*/
    //$emails = array();
    if(ENVIRONMENT == 'development') {
        $emails[] = "dthakur29@gmail.com";
    }
    return $emails;
}

function getCompanyDetailById($companyId) {
    $CI =& get_instance();
    $where = array('company_id' => $companyId);
    $companyDetails = $CI->common_model->getRecord(TBL_COMPANY_MASTER, array('*'), $where);
    return $companyDetails;
}


function taxColumn($invoiceDetail, $companyId = 1) {
    $CI =& get_instance();
    $isSelfState = false;
    if($invoiceDetail->state == '14') {
        /**MP State ID is 14 that's why we added it here*/
        $isSelfState = true;
    }

    $cmp_dtl = getCompanyDetailById($companyId);
    $currentMonth = date('n');
    $currentYear = date('Y');
    $newYear = date('Y');
    $today = date('j');
    $startMonthTexual = getConfiguration('financial_year_start_month');
    $financial_year_start_month = date('n', strtotime($startMonthTexual));
    if ($currentMonth < $financial_year_start_month) {
        $year = $currentYear - 1;
        $fin_year = $year . "-" .$currentYear;
    } else {
        if ($currentYear == 4 && $today == 1) {
            $newYear = $currentYear + 1;
            $fin_year = $currentYear . "-" . $newYear;
        } else {
            $newYear = $currentYear + 1;
            $fin_year = $currentYear . "-" . $newYear;
        }
    }
    if($isSelfState) {
        $taxWhere = array('financial_year' => $fin_year, 'is_state' => 'Y' );
    } else {
        $taxWhere = array('financial_year' => $fin_year, 'is_state' => 'N' );
    }

    $allTaxes = $CI->common_model->getRecords(TBL_TAX_MASTER, array('*'),$taxWhere);
    $tax_row = '<tbody>';
    $count = 1;
    $service_tax = 0;
    $include_tax = 0;
    $ser_tax = 0;
    $net_amt = $invoiceDetail->invoice_net_amount;
    $currncy = $invoiceDetail->currency_symbol;;
    foreach ( $allTaxes as $row ) {
        $tax = $row->tax;
        $tax_detail = $row->tax_detail;
        $include = $row->include_servtax;

        if ($cmp_dtl->include_tax == 'Y') {
            $tax_row .= '<tr>';
            if ($invoiceDetail->invoice_acceptance_status == "Accept")
                $tax_row .= '<td align="right"><div id="tax' . $count . '">' . $tax_detail . ' : &nbsp;' . $tax . '<input type="hidden" name="includestatus' . $count . '" id="includestatus' . $count . '" value="' . $include . '" />&nbsp;&nbsp;<input type="hidden" name="taxdtl' . $count . '" id="taxdtl' . $count . '" value="' . $tax_detail . '" /></div></td>';
            else {
                if ($include == 'N')
                    $tax_row .= '<td  align="right">' . $tax_detail . '  &nbsp;<input name="tax' . $count . '" type="text" size="5" id="tax' . $count . '" maxlength="6"  onkeyup="taxcalculation_gen(' . $count . ',\'' . $include . '\',' . $net_amt . ',\'' . $currncy . '\')" value="' . $tax . '" /><input type="hidden" name="includestatus' . $count . '" id="includestatus' . $count . '" value="' . $include . '" />&nbsp;&nbsp;<input type="hidden" name="taxdtl' . $count . '" id="taxdtl' . $count . '" value="' . $tax_detail . '" /></td>';
                else
                    $tax_row .= '<td  align="right">' . $tax_detail . ' &nbsp;<input name="tax' . $count . '" type="text" size="5" id="tax' . $count . '" maxlength="6"  onkeyup="taxcalculation_gen(' . $count . ',\'' . $include . '\',' . $net_amt . ',\'' . $currncy . '\')" value="' . $tax . '" /><input type="hidden" name="includestatus' . $count . '" id="includestatus' . $count . '" value="' . $include . '" />&nbsp;&nbsp;<input type="hidden" name="taxdtl' . $count . '" id="taxdtl' . $count . '" value="' . $tax_detail . '" /></td>';
            }
            if ($include == 'N') {
                $ser_tax = $ser_tax + $tax;
                $amount = $net_amt * ($tax / 100);
                $tax_row .= '<td  align="right"><div id="display_amt' . $count . '">' . $currncy . ' ' . formatAmount(round ( $amount, 2 )) . '</div><input type="hidden" name="taxamt' . $count . '" id="taxamt' . $count . '" value="' . $amount . '" /></td>';
            } else {
                $amount = $net_amt * (($ser_tax * $tax) / 10000);
                $tax_row .= '<td  align="right"><div id="display_amt' . $count . '">' . $currncy . ' ' . formatAmount(round ( $amount, 2 )) . '</div><input type="hidden" name="taxamt' . $count . '" id="taxamt' . $count . '" value="' . $amount . '" /></td>';
            }
            $tax_row .= '</tr>';
        }
        if ($include == 'N')
            $service_tax = $service_tax + $tax;
        else {
            $include_tax = $include_tax + $tax;
        }
        $count ++;
    } /*END FOREACH*/
    $total_tax = $service_tax + (($service_tax * $include_tax) / 100);
    $tax_amt = $net_amt * ($total_tax / 100);
    $gross_amt = $net_amt + $tax_amt;
    $gross_amt = round ( $gross_amt, 2 );

    if ($cmp_dtl->include_tax == 'Y') {
        $tax_row .= '<tr>';
        //$tax_row .= '<input type="hidden" name="include_tax" id="include_tax" value="' . $include_tax . '" /><input type="hidden" name="service_tax" id="service_tax" value="' . $service_tax . '" />';
        if ($invoiceDetail->invoice_acceptance_status == "Accept")
            $tax_row .= '<td align="right"><input type="hidden" name="include_tax" id="include_tax" value="' . $include_tax . '" /><input type="hidden" name="service_tax" id="service_tax" value="' . $service_tax . '" /><div id="total_tax">Total Tax (%) : &nbsp;' . $total_tax . '</div></td>';
        else
            $tax_row .= '<td align="right"><input type="hidden" name="include_tax" id="include_tax" value="' . $include_tax . '" /><input type="hidden" name="service_tax" id="service_tax" value="' . $service_tax . '" />Total Tax (%) : &nbsp;<input name="total_tax" type="text" size="5" id="total_tax" maxlength="6" onKeyPress="return numeralsOnly(event)" onkeyup="" value=' . $total_tax . ' style="margin-right:8px"/></td>';
        $tax_row .= '<td align="right"><div id="display_taxamt">' . $currncy . ' ' . formatAmount(round ( $tax_amt, 2 )) . '</div><input type="hidden" name="total_taxamt" id="total_taxamt" value="' . $tax_amt . '" /></td>';
        $tax_row .= '</tr>';
        $tax_row .= '<tr class="tb_bold">';
        $tax_row .= '<td align="right"><span class="boldFonts">Gross Amount : </span></td>';
        $tax_row .= '<td align="right"><div id="display_grossamt">' . $currncy . ' ' . formatAmount($gross_amt) . '</div><input type="hidden" name="grossamt" id="grossamt" value="' . $gross_amt . '" /></td>';
        $tax_row .= '<input type="hidden" name="taxcount" id="taxcount" value="' . $count . '" />';
        $tax_row .= '</tr>';
    } else if ($cmp_dtl->include_tax == 'N') {
        $tax_row .= '<tr class="tb_bold">';
        $tax_row .= '<td align="right"><span class="boldFonts">Gross Amount : </span></td>';
        $tax_row .= '<td align="right"><div id="display_grossamt">' . $currncy . ' ' . formatAmount($net_amt) . '</div><input type="hidden" name="grossamt" id="grossamt" value="' . $net_amt . '" /></td>';
        $tax_row .= '<input type="hidden" name="taxcount" id="taxcount" value="' . $count . '" />';
        $tax_row .= '</tr>';
    }

    $tax_row .= '</tbody>';
    return $tax_row;
}

function tax_column_appr_update($invoiceDetail, $companyid = 1)
    {
        /* Show service tax detail for webdunia.com */

        $CI =& get_instance();
        
        $isSelfState = false;
        $currncy = $invoiceDetail->currency_symbol;
        $net_amt = $invoiceDetail->invoice_net_amount;
        $invoice_status = $invoiceDetail->invoice_acceptance_status;

        if($invoiceDetail->state == '14') {
        /**MP State ID is 14 that's why we added it here*/
        $isSelfState = true;
        }

        $cmp_dtl = getCompanyDetailById($companyid);
        $currentMonth = date('n');
        $currentYear = date('Y');
        $newYear = date('Y');
        $today = date('j');
        $startMonthTexual = getConfiguration('financial_year_start_month');
        $financial_year_start_month = date('n', strtotime($startMonthTexual));

        if ($currentMonth < $financial_year_start_month) {
            $year = $currentYear - 1;
            $fin_year = $year . "-" .$currentYear;
        } else {
            if ($currentYear == 4 && $today == 1) {
                $newYear = $currentYear + 1;
                $fin_year = $currentYear . "-" . $newYear;
            } else {
                $newYear = $currentYear + 1;
                $fin_year = $currentYear . "-" . $newYear;
            }
        }

        if($isSelfState) {
            $taxWhere = array('financial_year' => $fin_year, 'is_state' => 'Y' );
        } else {
            $taxWhere = array('financial_year' => $fin_year, 'is_state' => 'N' );
        }
        // $query = "select * from tbl_invoice_taxdtl where financial_year='$fin_year' order by include_servtax";

        $allTaxes = $CI->common_model->getRecords(TBL_TAX_MASTER, array('*'),$taxWhere,'include_servtax');

        $tax_row = '';
        $count = 1;
        $service_tax = 0;
        $include_tax = 0;
        $ser_tax = 0;
        $tax_row.= '<table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" bgcolor="#AFBACF"  id="data">';
        $tax_row.= '<tr class="tb_bold">';
        $tax_row.= '<td align="right"><span class="boldFonts">Net Amount : </span></td>';
        $tax_row.= '<td align="right"><div id="display_netamt">' . $currncy . ' ' . formatAmount(round($net_amt, 2)) . '</div><input type="hidden" name="net_amt" id="net_amt" value="' . $net_amt . '" /></td>';
        $tax_row.= '</tr>';
      
        foreach ( $allTaxes as $row ) {
            $tax = $row->tax;
            $tax_detail = $row->tax_detail;
            $include = $row->include_servtax;
            if ($cmp_dtl->include_tax == 'Y') {
                $tax_row.= '<tr>';
                if ($include == 'N') $tax_row.= '<td align="right">' . $tax_detail . ' : &nbsp;<input name="tax' . $count . '" type="text" size="5" id="tax' . $count . '" maxlength="6" onKeyPress="return numeralsOnly(event)" onkeyup="taxcalculation_gen(' . $count . ',\'' . $include . '\',' . $net_amt . ',\'' . $currncy . '\')" value="' . $tax . '" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" name="includestatus' . $count . '" id="includestatus' . $count . '" value="' . $include . '" />&nbsp;&nbsp;<input type="hidden" name="taxdtl' . $count . '" id="taxdtl' . $count . '" value="' . $tax_detail . '" /></td>';
                else $tax_row.= '<td align="right">' . $tax_detail . ' : &nbsp;<input name="tax' . $count . '" type="text" size="5" id="tax' . $count . '" maxlength="6" onKeyPress="return numeralsOnly(event)" onkeyup="taxcalculation_gen(' . $count . ',\'' . $include . '\',' . $net_amt . ',\'' . $currncy . '\')" value="' . $tax . '" />&nbsp;of GST&nbsp;<input type="hidden" name="includestatus' . $count . '" id="includestatus' . $count . '" value="' . $include . '" />&nbsp;&nbsp;<input type="hidden" name="taxdtl' . $count . '" id="taxdtl' . $count . '" value="' . $tax_detail . '" /></td>';
                if ($include == 'N') {
                    $ser_tax = $ser_tax + $tax;
                    $amount = $net_amt * ($tax / 100);
                    $tax_row.= '<td align="right"><div id="display_amt' . $count . '">' . $currncy . ' ' . formatAmount(round($amount, 2)) . '</div><input type="hidden" name="taxamt' . $count . '" id="taxamt' . $count . '" value="' . $amount . '" /></td>';
                }
                else {
                    $amount = $net_amt * (($ser_tax * $tax) / 10000);
                    $tax_row.= '<td align="right"><div id="display_amt' . $count . '">' . $currncy . ' ' . formatAmount(round($amount, 2)) . '</div><input type="hidden" name="taxamt' . $count . '" id="taxamt' . $count . '" value="' . $amount . '" /></td>';
                }

                $tax_row.= '</tr>';
            }

            if ($include == 'N') $service_tax = $service_tax + $tax;
            else {
                $include_tax = $include_tax + $tax;
            }

            $count++;
        }

        $total_tax = $service_tax + (($service_tax * $include_tax) / 100);
        $tax_amt = $net_amt * ($total_tax / 100);
        $gross_amt = $net_amt + $tax_amt;
        $gross_amt = round($gross_amt, 2);
        if ($cmp_dtl->include_tax == 'Y') {
            $tax_row.= '<tr>';
            //$tax_row.= '<input type="hidden" name="include_tax" id="include_tax" value="' . $include_tax . '" /><input type="hidden" name="service_tax" id="service_tax" value="' . $service_tax . '" />';
            if ($invoice_status == "Accept") $tax_row.= '<td height="21" align="right" valign="middle" class="row1" style="padding-right:5px" width="761px"><input type="hidden" name="include_tax" id="include_tax" value="' . $include_tax . '" /><input type="hidden" name="service_tax" id="service_tax" value="' . $service_tax . '" /><div id="total_tax">Total Tax (%) : &nbsp;' . $total_tax . '<input type="hidden" value='.$total_tax.' name="hiddenTotalTax" ></div></td>';
            else $tax_row.= '<td align="right"><input type="hidden" name="include_tax" id="include_tax" value="' . $include_tax . '" /><input type="hidden" name="service_tax" id="service_tax" value="' . $service_tax . '" />Total Tax (%) : &nbsp;<input name="total_tax" type="text" size="5" id="total_tax" maxlength="6" onKeyPress="return numeralsOnly(event)" onkeyup="" value=' . $total_tax . ' style="margin-right:8px"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
            $tax_row.= '<td align="right"><div id="display_taxamt">' . $currncy . ' ' . formatAmount(round($tax_amt, 2)) . '</div><input type="hidden" name="total_taxamt" id="total_taxamt" value="' . $tax_amt . '" /></td>';
            $tax_row.= '</tr>';
            $tax_row.= '<tr class="tb_bold">';
            $tax_row.= '<td align="right"><span class="boldFonts">Gross Amount : </span></td>';
            $tax_row.= '<td align="right"><div id="display_grossamt">' . $currncy . ' ' . formatAmount($gross_amt) . '</div><input type="hidden" name="grossamt" id="grossamt" value="' . $gross_amt . '" /></td>';
            $tax_row.= '<input type="hidden" name="taxcount" id="taxcount" value="' . $count . '" />';
            $tax_row.= '</tr>';
        }
        else
        if ($cmp_dtl->include_tax == 'N') {
            $tax_row.= '<tr class="tb_bold">';
            $tax_row.= '<td align="right"><span class="boldFonts">Gross Amount : </span></td>';
            $tax_row.= '<td align="right"><div id="display_grossamt">' . $currncy . ' ' . formatAmount($net_amt) . '</div><input type="hidden" name="grossamt" id="grossamt" value="' . $net_amt . '" /></td>';
            $tax_row.= '<input type="hidden" name="taxcount" id="taxcount" value="' . $count . '" />';
            $tax_row.= '</tr>';
        }

        $tax_row.= '</table>';
        return $tax_row;
    }


function tax_column_accept($invoice_id, $currncy, $net_amt, $companyid = 1) {
    $CI =& get_instance();
    $tax_row = '';
    /* Show service tax detail for invoice no generate by webdunia.com */
    $cmp_dtl = getCompanyDetailById ( $companyid );
    $where = array('invoice_req_id'=>$invoice_id,'includestatus'!= '');
    $allTaxes = $CI->common_model->getRecords('ims_invoice_reqtax', array('*'),$where);

    $count = 1;
    $tax_row .= '<tbody>';

    foreach ( $allTaxes as $row ) {
        $tax_label = $row->tax_label;
        $include = $row->includestatus;
        $tax = $row->tax;
        $taxamt = $row->tax_amount;
        if ($cmp_dtl->include_tax == 'Y') {
            $tax_row .= '<tr>';
            $tax_row .= '<td  align="right"><div id="tax' . $count . '">' . $tax_label . ' : &nbsp;' . $tax . '<input type="hidden" name="includestatus' . $count . '" id="includestatus' . $count . '" value="' . $include . '" /><input type="hidden" name="taxdtl' . $count . '" id="taxdtl' . $count . '" value="' . $tax_label . '" /><input type="hidden" name="tax' . $count . '" id="tax' . $count . '" value="' . $tax . '" /></div></td>';
            $tax_row .= '<td  align="right"><div id="display_amt' . $count . '">' . $currncy . ' ' . formatAmount ( round ( $taxamt, 2 ) ) . '</div><input type="hidden" name="taxamt' . $count . '" id="taxamt' . $count . '" value="' . $taxamt . '" /></td>';
            $tax_row .= '</tr>';
        }
        $count ++;
    }
    $where = array('invoice_req_id'=>$invoice_id,'includestatus'=>'');
    $row = $CI->common_model->getRecords('ims_invoice_reqtax', array('*'),$where);
    
    if(count($row)>0){
    $total_taxlabel = $row->tax_label;
    $total_include = $row->includestatus;
    $total_tax = $row->tax;
    $total_taxamt = $row->tax_amount;
    $gross_amt = $net_amt + $total_taxamt;
    $gross_amt = round ( $gross_amt, 2 );
}

    /* Show service tax detail for invoice no generate by webdunia.com */
    if ($cmp_dtl->include_tax == 'Y') {
        $tax_row .= '<tr>';
        $tax_row .= '<td align="right"><div id="total_tax">Total Tax (%) : &nbsp;' . $total_tax . '</div></td>';
        $tax_row .= '<td align="right"><div id="display_taxamt">' . $currncy . ' ' . formatAmount ( round ( $total_taxamt, 2 ) ) . '</div><input type="hidden" name="total_taxamt" id="total_taxamt" value="' . $tax_amt . '" /></td>';
        $tax_row .= '</tr>';
        $tax_row .= '<tr class="tb_bold">';
        $tax_row .= '<td align="right"><span class="boldFonts">Gross Amount : </span></td>';
        $tax_row .= '<td align="right"><div id="display_grossamt">' . $currncy . ' ' . formatAmount ($gross_amt) . '</div><input type="hidden" name="grossamt" id="grossamt" value="' . $gross_amt . '" /></td>';
        $tax_row .= '<input type="hidden" name="taxcount" id="taxcount" value="' . $count . '" />';
        $tax_row .= '</tr>';
    } else if ($cmp_dtl->include_tax == "N") {
        $tax_row .= '<tr class="tb_bold">';
        $tax_row .= '<td align="right"><span class="boldFonts">Gross Amount : </span></td>';
        $tax_row .= '<td align="right"><div id="display_grossamt">' . $currncy . ' ' . formatAmount ($net_amt) . '</div><input type="hidden" name="grossamt" id="grossamt" value="' . $net_amt . '" /></td>';
        $tax_row .= '<input type="hidden" name="taxcount" id="taxcount" value="' . $count . '" />';
        $tax_row .= '</tr>';
    }
    $tax_row .= '</tbody>';
    return $tax_row;
}

function tax_column_appr($invoice_id, $currncy, $net_amt, $gross_amt, $companyid = 1){

        $CI =& get_instance();
        $cmp_dtl = getCompanyDetailById($companyid);
        $where = array('invoice_req_id'=>$invoice_id);
        $allTaxes = $CI->common_model->getRecords(TBL_INVOICE_REQTAX_MASTER, array('*'),$where);
        $tax_row = '<tbody>';
        $count = 1;
        //$tax_row.= '<table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" bgcolor="#AFBACF"  id="data">';
        $tax_row.= '<tr class="tb_bold">';
        $tax_row.= '<td align="right"><span class="boldFonts">Net Amount : </span></td>';
        $tax_row.= '<td align="right"><div id="display_netamt">' . $currncy . ' ' . formatAmount(round($net_amt, 2)) . '</div><input type="hidden" name="net_amt" id="net_amt" value="' . $net_amt . '" /><input type="hidden" name="tax_currency" id="tax_currency" value="'.$currncy.'"/></td>';
        $tax_row.= '</tr>';
        foreach ( $allTaxes as $row ) {
            $columnid = $row->id;
            $tax_label = $row->tax_label;
            $tax = $row->tax;
            $tax_amount = $row->tax_amount;
            $include = $row->includestatus;
            /* Show service tax detail for invoice no generate by webdunia.com */
            if ($cmp_dtl->include_tax == 'Y') {
                $tax_row.= '<tr>';
                if ($include == 'N' || $include == '') $tax_row.= '<td height="21" width="761px" align="right" valign="middle" class="row1" style="padding-right:5px"><div id="display_tax' . $count . '">' . $tax_label . ' : &nbsp;' . $tax . '</div><input type="hidden" name="includestatus' . $count . '" id="includestatus' . $count . '" value="' . $include . '" /><input type="hidden" name="taxdtl' . $count . '" id="taxdtl' . $count . '" value="' . $tax_label . '" /><input type="hidden" name="hiddentax' . $count . '" id="hiddentax' . $count . '" value="' . $tax . '" /><input type="hidden" name="tax' . $count . '" id="tax' . $count . '" value="' . $tax . '" /></td>';
                else $tax_row.= '<td align="right"><div id="display_tax' . $count . '">' . $tax_label . ' : &nbsp;' . $tax . '&nbsp;of GST&nbsp;</div><input type="hidden" name="includestatus' . $count . '" id="includestatus' . $count . '" value="' . $include . '" /><input type="hidden" name="taxdtl' . $count . '" id="taxdtl' . $count . '" value="' . $tax_label . '" /><input type="hidden" name="hiddentax' . $count . '" id="hiddentax' . $count . '" value="' . $tax . '" /><input type="hidden" name="tax' . $count . '" id="tax' . $count . '" value="' . $tax . '" /></td>';
                $tax_row.= '<td align="right"><div id="display_amt' . $count . '">' . $currncy . ' ' . formatAmount(round($tax_amount, 2) ). '</div><input type="hidden" name="taxamt' . $count . '" id="taxamt' . $count . '" value="' . $tax_amount . '" /><input type="hidden" name="org_taxamt' . $count . '" id="org_taxamt' . $count . '" value="' . $tax_amount . '" /><input type="hidden" name="columnid' . $count . '" id="columnid' . $count . '" value="' . $columnid . '" /></td>';
                $tax_row.= '</tr>';
            }

            $count++;
        }

        if ($cmp_dtl->include_tax == 'Y') {
            $tax_row.= '<tr class="tb_bold">';
            $tax_row.= '<td align="right"><span class="boldFonts">Gross Amount : </span></td>';
            $tax_row.= '<td align="right"><div id="display_grossamt">' . $currncy . ' ' . formatAmount(round($gross_amt, 2)) . '</div><input type="hidden" name="grossamt" id="grossamt" value="' . $gross_amt . '" /><input type="hidden" name="grossamt_org" id="grossamt_org" value="' . $gross_amt . '" /></td>';
            $tax_row.= '<input type="hidden" name="taxcount" id="taxcount" value="' . $count . '" />';
            $tax_row.= '</tr>';
        }
        else {
            $tax_row.= '<tr class="tb_bold">';
            $tax_row.= '<td align="right"><span class="boldFonts">Gross Amount : </span></td>';
            $tax_row.= '<td align="right"><div id="display_grossamt">' . $currncy . ' ' . formatAmount(round($net_amt, 2)) . '</div><input type="hidden" name="grossamt" id="grossamt" value="' . $net_amt . '" /></td>';
            $tax_row.= '<input type="hidden" name="taxcount" id="taxcount" value="' . $count . '" />';
            $tax_row.= '</tr>';
        }

        $tax_row.= '</tbody>';
        return $tax_row;
    }


function create_invoice_folder_html($html, $invoice_id, $company_short_code,$invoice_no,$invoice_pdf_generate=false){
    $CI =& get_instance();
   
    $yearfolder = getCurrentFinancialYear();
    $newfolder = "uploads/" . $yearfolder . "/" . $invoice_id;    
    
    $invoice_folder = $newfolder . "/invoice_folder/" . $company_short_code;
    if (!file_exists($invoice_folder)) {
    mkdir($invoice_folder, 0777, true);
    }  
    $filename = "Invoice_" . $invoice_id . ".html";
    $add = $invoice_folder . "/" . $filename; // upload directory path is set
    $handle = fopen($add, 'w');
    fwrite($handle, $html);
    fclose($handle);
    if($invoice_pdf_generate){
        $CI->load->library('imspdf');
        $html_filename = "Invoice_" . $invoice_id . ".html";
        $html_file = "$invoice_folder/$html_filename";
        $temp_pdffilename = str_replace("/", "_", $invoice_no);
        $pdf_filename = $temp_pdffilename . ".pdf";
        $pdf_file = "$invoice_folder/$pdf_filename";
        //var_dump($pdf_file);die;
        @unlink($pdf_file);
        $CI->imspdf->pdf->WriteHTML($html);
        $CI->imspdf->pdf->Output($pdf_file, "F");
        $add = $pdf_file;
    } 
    return $add; 
}

function convert_number($number){

        if (($number < 0) || ($number > 999999999)) {
            throw new Exception("Number is out of range");
        }

        $TCn = floor($number / 100000000); /* Ten Crore */
        $number-= $TCn * 100000000;
        $Cn = floor($number / 10000000); /* Crore */
        $number-= $Cn * 10000000;
        $TLn = floor($number / 1000000); /* Millions (giga) or Ten Lac */
        $number-= $TLn * 1000000;
        $Ln = floor($number / 100000); /* Lac () */
        $number-= $Ln * 100000;
        $kn = floor($number / 1000); /* Thousands (kilo) */
        $number-= $kn * 1000;
        $Hn = floor($number / 100); /* Hundreds (hecto) */
        $number-= $Hn * 100;
        $Dn = floor($number / 10); /* Tens (deca) */
        $n = $number % 10; /* Ones */
        $ones = array(
            "",
            "One",
            "Two",
            "Three",
            "Four",
            "Five",
            "Six",
            "Seven",
            "Eight",
            "Nine",
            "Ten",
            "Eleven",
            "Twelve",
            "Thirteen",
            "Fourteen",
            "Fifteen",
            "Sixteen",
            "Seventeen",
            "Eightteen",
            "Nineteen"
        );
        $tens = array(
            "",
            "",
            "Twenty",
            "Thirty",
            "Forty",
            "Fifty",
            "Sixty",
            "Seventy",
            "Eigthy",
            "Ninety"
        );
        $res = "";
        if ($TCn) {

           

            if ($TCn != 1) $res.= $tens[$TCn] . "-";
        }

        if ($Cn) {
            if ($TCn == 1) {
                $res.= (empty($res) ? "" : "") . convert_number($TCn . $Cn) . " Crore ";
            }
            else {
                $res.= (empty($res) ? "" : "") . convert_number($Cn) . " Crore ";
            }
        }

        

        if ($Ln || $TLn) {
            if ($TLn == 1) {
                $res.= (empty($res) ? "" : "") . convert_number($TLn . $Ln) . " Lac";
            }
            else {
                $res.= (empty($res) ? "" : "") . convert_number($Ln) . " Lac";
            }
        }

        if ($kn) {
            $res.= (empty($res) ? "" : " ") . convert_number($kn) . " Thousand";
        }

        if ($Hn) {
            $res.= (empty($res) ? "" : " ") . convert_number($Hn) . " Hundred";
        }

        if ($Dn || $n) {
            if (!empty($res)) {
                $res.= " and ";
            }

            if ($Dn < 2) {
                $res.= $ones[$Dn * 10 + $n];
            }
            else {
                $res.= $tens[$Dn];
                if ($n) {
                    $res.= "-" . $ones[$n];
                }
            }
        }

        if (empty($res)) {
            $res = "zero";
        }

        return $res;
    }

function convert_to_word($grossamt,$po_curr) {

    $CI =& get_instance();
    /*convert to words*/
    $where = array('currency_status'=>1);
    $currencyDetails = $CI->common_model->getRecords(TBL_CURRENCY_MASTER,array('currency_symbol','sub_currency','currency_name'),$where);

    $word_currency= array();
    $word_sub_currency = array();

    foreach ($currencyDetails as $key => $value) {

        $word_currency[$value->currency_symbol]=$value->currency_name;
        $word_sub_currency[$value->currency_symbol]=$value->sub_currency;
    }

    $find = strstr($grossamt, ".");

    if ($find == "") {
        $chequeamt = $grossamt;
        $cheque_amt1 = convert_number($chequeamt);
        $wordcurr = $word_currency[$po_curr];
        $cheque_amt = $wordcurr." ".$cheque_amt1;
    }
    else {
                   
        $chequeamt = explode(".", $grossamt);
        $cheque_amt1 = convert_number(trim($chequeamt[0]));
        $cheque_amt2 = convert_number(trim($chequeamt[1]));
        $wordcurr = $word_currency[$po_curr];
        $wordcurr1 = $word_sub_currency[$po_curr];    
        $cheque_amt = $wordcurr . " " . $cheque_amt1 . " & " . $cheque_amt2 . " " . $wordcurr1;
    }

    return $cheque_amt;

}


/*
 * getCurrentFinancialYear
 * Return the current financial year ex - 2017-2018
*/
function getCurrentFinancialYear(){
    $year = date('Y');
    $newyear = date('Y');
    $day = date('j');
    $month = date('n');
    $considerDate = 1;
    $startMonth = getConfiguration('financial_year_start_month');
    $startMonth = date('n', strtotime($startMonth));
    if(empty($startMonth) || 1) {
        $startMonth = 4;
    }
    if ($month < $startMonth) {
        $year = $year - 1;
        $yearfolder = $year . "-" . $newyear;
    }
    else {
        if ($month == $startMonth && $day < $considerDate ) {
            $year = $year - 1;
            $yearfolder = $year . "-" . $newyear;
        }
        else {
            if ($month == $startMonth && $day == ($considerDate + 1)) {
                $newyear = $year + 1;
                $yearfolder = $year . "-" . $newyear;
            } else {
                $newyear = $year + 1;
                $yearfolder = $year . "-" . $newyear;
            }
        }
    }
    return $yearfolder;
}

function getJobNumber($jobID) {
    $preFix = 'JKM';
    $financialYear = getCurrentFinancialYear();
    $jobNumber = $preFix."/".$financialYear."/".$jobID;
    return $jobNumber;
}

function getGeneratedInvoiceName($invoice_no){

    $generated_invoice = $invoice_no;
    $generated_invoice = str_replace("/", "_", $generated_invoice);
    $generated_invoice = $generated_invoice . ".pdf";
    return $generated_invoice;

}

function getCurrencySymbol($currency) {
    if($currency == '1') {
        $currencyClass = 'fa fa-dollar';
    } else if($currency == '2') {
        $currencyClass = 'fa fa-inr';
    }else if($currency == '3') {
        $currencyClass = 'fa fa-dollar';
    }else if($currency == '4') {
        $currencyClass = 'fa fa-dollar';
    }else if($currency == '5') {
        $currencyClass = 'fa fa-dollar';
    }else if($currency == '6') {
        $currencyClass = 'fa fa-euro';
    }else if($currency == '7') {
        $currencyClass = 'fa fa-gbp';
    }
    $currencySymbol = '<i class="'.$currencyClass.'" aria-hidden="true"></i>';
    return $currencySymbol;

}

function formatAmount($amount, $decimalPlaces = 2) {
    if($decimalPlaces == 0) {
        return current(explode('.', money_format('%!i',floatval($amount))) );
    }
    return money_format('%!i',floatval($amount));
    //return number_format(floatval($amount), $decimalPlaces);
}

/*
 * Will update it latter by Database table
*/
function getCurrencyConvertedAmount($currency, $amount, $month = false, $returnRate = false) {
    static $currencyRates = null;
    static $monthlyCurrencyRates = null;
    $flateRate = array(
        '1' => 60,
        '2' => 1,
        '3' => 49,
        '4' => 50,
        '5' => 47,
        '6' => 79,
        '7' => 90
    );

    /*If want get currency rate based on month*/
    if($month) {
        if($monthlyCurrencyRates === null) {
            $monthlyCurrencyRates = getMonthlycurrencyRates();
        }

        if(isset($monthlyCurrencyRates[$month])) {
            $rate = (isset($monthlyCurrencyRates[$month][$currency])) ? $monthlyCurrencyRates[$month][$currency] : ((isset($flateRate[$currency])) ? $flateRate[$currency]:"1");
        } else {
            $rate = $flateRate[$currency];
        }
    } else { /*Currency rate for current month*/

        if($currencyRates === null) {
            $currencyRates = getCurrentCurrencyRates();
        }
        $rate = (isset($currencyRates[$currency])) ? $currencyRates[$currency] :  $flateRate[$currency];;
    }

    if($returnRate) {
        return $rate;
    }

    if($amount != '') {
        $convertedAmt =  $amount * $rate;
    } else {
        $convertedAmt = '';
    }

    return $convertedAmt;
}

/*Get it from DB OR API*/
function getCurrentCurrencyRates($currentMonth  = false) {
    $CI =& get_instance();
    $month =  ($currentMonth) ? $currentMonth : date('Y-m-01');
    $currentMonthConversion = $CI->common_model->getRecords(TBL_CURRENCY_CONVERSIONS, array('id', 'currency_id', 'conversion_rate'), array('month'=> $month) );
    $currencyConversionArray = array();
    if($currentMonthConversion) {
        $currencyConversionArray['2'] = 1; //INR
        foreach($currentMonthConversion as $conversion) {
            $currencyConversionArray[$conversion->currency_id] = $conversion->conversion_rate;
        }
    }
    return $currencyConversionArray;
}

function getMonthlycurrencyRates() {
    $CI =& get_instance();
    $allMonthConversions = $CI->common_model->getRecords(TBL_CURRENCY_CONVERSIONS, array('id', 'month', 'currency_id', 'conversion_rate'));
    $monthlyConversionArray = array();
    if($allMonthConversions) {
        //$currencyConversionArray['2'] = 1; //INR
        foreach($allMonthConversions as $conversion) {
            $M = date('Y-m-d', strtotime($conversion->month));
            if(!isset($monthlyConversionArray[$M])) {
                $monthlyConversionArray[$M][2] = 1;
            }
            $monthlyConversionArray[$M][$conversion->currency_id] = $conversion->conversion_rate;
        }
    }
    return $monthlyConversionArray;
}

/*To get Configuration value*/
function getConfiguration($specific = false) {
    static $configurations = null;
    $CI =& get_instance();
    if($configurations === null){
        $configurationsRecords = $CI->common_model->getRecords(TBL_CONFIGURATIONS);
        if($configurationsRecords) {
            foreach($configurationsRecords as $config) {
                $configurations[$config->config_unique_code] = $config->config_value;
            }
        }
    }

    if($configurations) {
        if($specific) {
            return isset($configurations[$specific]) ? $configurations[$specific] : "";
        } else {
            return $configurations;
        }
    }
}

if ( ! function_exists('money_format')) {
    function money_format($format, $number)
    {
        error_reporting(~E_NOTICE);
        $negative = "";
        if (strstr($number, "-")) {
            $number = str_replace("-", "", $number);
            $negative = "-";
        }

        $split_number = @explode(".", $number);

        $rupee = $split_number[0];
        $paise = @$split_number[1];

        if (@strlen($rupee) > 3) {
            $hundreds = substr($rupee, strlen($rupee) - 3);
            $thousands_in_reverse = strrev(substr($rupee, 0, strlen($rupee) - 3));
            $thousands = '';
            for ($i = 0; $i < (strlen($thousands_in_reverse)); $i = $i + 2) {
                $thousands .= $thousands_in_reverse[$i] . $thousands_in_reverse[$i + 1] . ",";
            }
            $thousands = strrev(trim($thousands, ","));
            $formatted_rupee = $thousands . "," . $hundreds;

        } else {
            $formatted_rupee = $rupee;
        }
        $formatted_paise = '';
        if ((int)$paise > 0) {
            $formatted_paise = "." . substr($paise, 0, 2);
        }

        return $negative . $formatted_rupee . $formatted_paise;

    }
}

function generateStrongPassword($length = 8, $add_dashes = false, $available_sets = 'luds')
{
    $sets = array();
    if(strpos($available_sets, 'l') !== false)
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
    if(strpos($available_sets, 'u') !== false)
        $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
    if(strpos($available_sets, 'd') !== false)
        $sets[] = '23456789';
    if(strpos($available_sets, 's') !== false)
        $sets[] = '!@$&*';
    $all = '';
    $password = '';
    foreach($sets as $set)
    {
        $password .= $set[array_rand(str_split($set))];
        $all .= $set;
    }
    $all = str_split($all);
    for($i = 0; $i < $length - count($sets); $i++)
        $password .= $all[array_rand($all)];
    $password = str_shuffle($password);
    if(!$add_dashes)
        return $password;
    $dash_len = floor(sqrt($length));
    $dash_str = '';
    while(strlen($password) > $dash_len)
    {
        $dash_str .= substr($password, 0, $dash_len) . '-';
        $password = substr($password, $dash_len);
    }
    $dash_str .= $password;
    return $dash_str;
}

function debug($dataArray, $isExit = true) {
    echo "<pre>";
    print_r($dataArray);
    echo "</pre>";
    if($isExit) {
        exit;
    }
}

function getFinancialYearStartDate($financialYear = false) {
    if(!$financialYear) {
        $financialYear = getCurrentFinancialYear();
    }
    $startYear = current(explode('-', $financialYear));

    $startMonth = getConfiguration('financial_year_start_month');
    $dateParseArray = date_parse($startMonth);
    $startMonth = ($dateParseArray['month'])? $dateParseArray['month'] : FINANCIAL_YEAR_START_MONTH;
    $considerDate = 01;
    $startDate = $startYear.'-'.$startMonth.'-'.$considerDate;
    $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
    return $startDate;
}

function getFinancialYearEndDate($financialYear = false) {
    $startDate = getFinancialYearStartDate($financialYear);
    $endDate = date('Y-m-31 23:59:59', strtotime('+1 year', strtotime('-1 day',strtotime($startDate))));
    return $endDate;
}

function sendResponse($status, $message ,$data) {
    if ($status) {
        http_response_code(200);
    }else{
        http_response_code(203);
    }
    $resp = array('status' => $status, "message"=>$message, "data"=> $data);
    header('Content-Type: application/json');
    echo json_encode($resp);
    exit(0);
}