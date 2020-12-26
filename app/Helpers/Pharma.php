<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Activity;
use App\Doctor;
use App\Models\Pharma\Customer;
use App\Models\Pharma\Invoice;
use App\Models\Pharma\Sale;
use App\Models\Pharma\Purchase;
use App\Transation;
use App\Models\Pharma\SaleReturn;
use App\Models\diagnostic\Bill;
use App\Models\hospital\HmsAdmission;
use App\Models\hospital\HmsOperation; 
use App\Models\hospital\HmsEmergency; 
use App\Models\hospital\BedChargeCollection; 
use App\Models\doctor\DocAppointment;
use App\Models\doctor\DocSchedule;
use App\Models\hrm\HrmAttendance;;
use App\AssetCategory;


use Sentinel;
use Session;

class Pharma
{
    private $userId;
    // private $roleId;
    // private $userStatus;
    public function __construct()
    {
        if (Sentinel::check()) {
            $this->userId = Sentinel::getUser()->id;
            // $this->roleId = $user->role_id;
            // $this->userStatus = $user->status;
        }
    }

    public function getModule(){
        if(Sentinel::getUser()->inRole('admin')){
            return 'HMS';
        }elseif(Sentinel::getUser()->inRole('pharmacy')){
            return 'Pharmacy';
        }elseif(Sentinel::getUser()->inRole('laboratory')){
            return 'Laboratory';
        }elseif(Sentinel::getUser()->inRole('diagnostic')){
            return 'Diagnostic';
        }elseif(Sentinel::getUser()->inRole('hospital')){
            return 'Hospital';
        }elseif(Sentinel::getUser()->inRole('doctor')){
            return 'Doctor';
        }    
    }
    public function getUserName($id)
    {
        $user =  DB::table('users')->where('id',$id)->first();
        return $user->first_name.' '.$user->last_name;
    }
    public function isAdmin()
    {
        $user = Sentinel::getUser();
        if ($user->inRole('admin')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function ownResults($model, $user_id = 'user_id')
    {
        $user = Sentinel::getUser();
        if ($user->inRole('admin')) {
            return $model->orderBy('id', 'desc')->where('Status','Active')->get();
        } else {
            return $model->where($user_id, $this->userId)->where('Status','Active')->orderBy('id', 'desc')->get();
        }
    }
    public function ownItems($model, $user_id = "user_id")
    {
        $user = Sentinel::getUser();
        if ($user->inRole('admin')) {
            return true;
        }
        if ($model->$user_id == $this->userId) {
            return true;
        }
        abort(404);
    }

    public function roleOptions($object, $selected = "client")
    {
        $option = '';
        if (empty($object)) {
            return "<option value = ''>No Data</option>";
        }
        foreach ($object as $obj) {
            $option .= "<option value = '{$obj->slug}' ";
            $option .= ($selected == $obj->slug) ? 'selected' : '';
            $option .= ">{$obj->name}</option>";
        }

        return $option;
    }
    public function GetOptions($object, $column, $selected = 0, $id = 'id')
    {
        $option = '';
        if (empty($object)) {
            return "<option value = ''>No Data</option>";
        }
        foreach ($object as $obj) {
            $option .= "<option value = '{$obj->$id}' ";
            $option .= ($selected == $obj->$id) ? 'selected' : '';
            $option .= ">" . ucfirst($obj->$column) . "</option>";
        }

        return $option;
    }
    public function getOptionArray ($arr , $selected=NULL){
        $option = '';
        foreach($arr as $key => $val){
            // $slug = Str::slug($val,"-");
            $option .= "<option value = '{$key}'";
            $option .= ($selected == $key) ? 'selected' : '';
            $option .= ">".$val."</option>";
        }
        return $option;
    }


    public function getUniqueSlug($model, $value,$row = "slug")
    {
        $slug = Str::slug($value);
        $slugCount = count($model->whereRaw("{$row} REGEXP '^{$slug}(-[0-9]+)?$' and id != '{$model->id}'")->get());

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }

    public function identification_no($model, $cat,$name)
    {
        $catName = Str::slug(AssetCategory::find($cat)->name);
        $name = Str::slug($name);
        $value = session()->get('settings')[0]['prefix_asset'].$catName.'/'.$name;
        $slugCount = count($model->whereRaw("identification_no REGEXP '^{$value}(-[0-9]+)?$' and id != '{$model->id}'")->get());
        
        return ($slugCount > 0) ? "{$value}-{$slugCount}" : $value;
    }

    public function limit_text($text, $limit)
    {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
    public function short_text($text, $limit){
        return strlen($text) > $limit ? substr($text,0,$limit).".." : $text;
    }

    public static function activities($action = "", $module = "", $notes = "")
    {
        $activity = new Activity();
        $activity->user_id = Sentinel::getUser()->id;
        $activity->name = Sentinel::getUser()->first_name . ' ' . Sentinel::getUser()->last_name;
        $activity->action = $action;
        $activity->module = $module;
        $activity->notes = $notes;
        $activity->save();
    }

    public function sendNotification($users = array(), $content = "", $url = "")
    {
        $users = ($users) ?: [$this->userId];
        foreach ($users as $id) {
            $a = [];
            $a['created_at'] = date('Y-m-d H:i:s');
            $a['user'] = $id;
            $a['content'] = $content;
            $a['is_read'] = 0;
            $a['from'] = $this->userId;
            $a['url'] = $url;
            DB::table('notifications')->insert($a);
        }

        return true;
    }
    public function countUserinRole($role_id)
    {
        return DB::table('role_users')->where('role_id', $role_id)->count();
    }

    public static function sendEmail($config = [])
    {
        $to = $config['to'];
        $data = $config['data'];
        $template = $config['template'];

        $template = DB::table('email_templates')->where('slug', $template)->first();
        if (!empty($template)) {
            $html = $template->content;
            foreach ($data as $key => $val) {
                $html = str_replace('[' . $key . ']', $val, $html);
                $template->subject = str_replace('[' . $key . ']', $val, $template->subject);
            }
            $subject = $template->subject;
            $attachments = ($config['attachments']) ?: [];

            \Mail::send("email_template.emails.email", ['content' => $html], function ($message) use ($to, $subject, $template, $attachments) {
                $message->priority(1);
                $message->to($to);

                if ($template->from_email) {
                    $from_name = ($template->from_name) ?: 'Sharif';
                    $message->from($template->from_email, $from_name);
                }

                if ($template->cc_email) {
                    $message->cc($template->cc_email);
                }

                // https://stackoverflow.com/questions/47051151/how-to-send-attachment-files-to-email-using-laravel
                if (count($attachments)) {
                    foreach ($attachments as $attachment) {
                        $message->attach($attachment);
                    }
                }

                $message->subject($subject);
            });

            DB::table('mailboxes')->insert([
                'to'            => $to,
                'from'          => $template->from_email,
                'template'      => $config['template'],
                'message'       => $html,
                'subject'       => $subject,
                // 'attachments'   => $attachments,
                'status'    => 'unread',
                'created_at'    => now(),
            ]);
        }
    }
    
    //System Settings -----------------------------------------------------------------------------------------

    public function globalDateTime($timestamp){
        if (empty($timestamp)) {
            return '<span class="text-danger">No Date Time</span>';
        }
        return date('d-M-y h:i A', strtotime($timestamp));
    }
    public function dateFormat($date){
        $dateFormat = session()->get('settings')[0]['date_format'];
        return date($dateFormat,strtotime($date));
    }
    public function dateTimeFormat($date){
        // $dateFormat = session()->get('settings')[0]['date_format'];
        return date('h:i A',strtotime($date));
    }

    public function two_date_diff($form, $today) {
        $date1 = date_create($form);
        $date2 = date_create($today);
        $diff = $date1->diff($date2);
    
        if ($diff->d == 0) {
            return 1;
            // return 'Same Day';
        } else {
            // return $d
            return $diff->d+1;
        }
    }

    public function amountFormat($amount){
        // $cur = "$";
        return $amount;
    }
    public function amountFormatWithCurrency($amount,$NotZiro = 0){
        if($amount == 0){
            return ($NotZiro != '0')? '-': $this->curPosition(0);
        }
        return $this->curPosition($amount);
    }
    public function getCurrency(){
        // return '€';
        return session()->get('settings')[0]['currency_symbol'];
    }
    public function curPosition($amount){
        $cur = $this->getCurrency();
        if($amount >= 0){
            if(session()->get('settings')[0]['cur_position'] == 'before'){
                return $cur.number_format($amount,2);
            }else{
                return number_format($amount,2).$cur;
            }
        }
        if(session()->get('settings')[0]['cur_position'] == 'before'){
            return $cur.'('.number_format(abs($amount),2).')';
        }else{
            return '('.number_format(abs($amount),2).')'.$cur;
        }
    }

    public function getLowQty(){
        return 10;
    }
    public function getUpcomingDate(){
        $day = 30;
        $today = date('Y-m-d H:i:s');
        return date('Y-m-d',date(strtotime("+{$day} day", strtotime($today))));
    }



    
    public function getPharmecyDue($patient_id){
        $dues               = Sale::where('patient_id',$patient_id)->sum('new_balance');
        $collection         = Transation::where('vendor_id',$patient_id)->where('vendor','Patient')->where('transaction_type','Collection')->where('module','Pharmacy')->sum('amount');
        $balance            = $dues-$collection;
        // return $this->amountFormatWithCurrency($balance);
        return $balance;
    }

    public function getDiagnosticDue($patient_id){
        $dues               = Bill::where('patient_id',$patient_id)->sum('due'); //Diagnostic bill
        $collection         = Transation::where('vendor_id',$patient_id)->where('vendor','Patient')->where('transaction_type','Collection')->where('module','Diagnostic')->sum('amount');
        $balance            = $dues-$collection;
        // return $this->amountFormatWithCurrency($balance);
        return $balance;
    }
    public function getAdmissionDue($patient_id){
        $dues               = HmsAdmission::where('patient_id',$patient_id)->sum('due');
        $collection         = Transation::where('vendor_id',$patient_id)->where('vendor','Patient')->where('transaction_type','Collection')->where('module','Hospital')->where('sub_module','Hospital-Admission')->sum('amount');
        $balance            = $dues-$collection;
        return $balance;
    }
    public function getEmergencyDue($patient_id){
        $dues               = HmsEmergency::where('patient_id',$patient_id)->sum('due');
        $collection         = Transation::where('vendor_id',$patient_id)->where('vendor','Patient')->where('transaction_type','Collection')->where('module','Hospital')->where('sub_module','Hospital-Emergency')->sum('amount');
        $balance            = $dues-$collection;
        return $balance;
    }
    public function getOperationDue($patient_id){
        $dues               = HmsOperation::where('patient_id',$patient_id)->sum('due');
        $collection         = Transation::where('vendor_id',$patient_id)->where('vendor','Patient')->where('transaction_type','Collection')->where('module','Hospital')->where('sub_module','Hospital-Operation')->sum('amount');
        $balance            = $dues-$collection;
        return $balance;
    }

    public function bedChargeDue($patient_id){
        $admission = HmsAdmission::where('patient_id',$patient_id)->where('status','Active')->first();
        if(!empty($admission)){
            $day = $this->two_date_diff($admission->date,date('Y-m-d'));
            $charge = $admission->bed->price;
            return $day*$charge;
        }
    }

    public function getBedChargeCollection($patient_id){
        $admission = HmsAdmission::where('patient_id',$patient_id)->where('status','Active')->first();
        if(!empty($admission)){
            $collect = BedChargeCollection::where('admission_id',$admission->id)->first();
            if(!empty($collect)){
                if(date("Y-m-d",strtotime($collect->updated_at)) == date('Y-m-d')){
                    $day = 0;
                }else{
                    $day = $this->two_date_diff($collect->updated_at,date('Y-m-d'));
                }
                $charge = $admission->bed->price;
                return $day*$charge + $collect->due;
            }else{
                if(!empty($admission)){
                    $day = $this->two_date_diff($admission->date,date('Y-m-d'));
                    $charge = $admission->bed->price;
                    return $day*$charge;
                }
            }
        }
        return 0;
    }





    //Parmacy Function -----------------------------------------------------------------------------------------

    public function findIdBySlug($table, $slug){
        $data = DB::table($table)->where('slug',$slug)->first();
        if(empty($data)){return 0;}
        return $data->id;
    }
    
    public function getinfo($table, $item, $id)
    {
        return DB::table($table)->where($item, $id)->first();
    }
    public function nextBatchNumber()
    {
        $batch_number = DB::table('pharma_batches')->max('batch_number');
        if (empty($batch_number)) {
            $batch_number = 0;
        }
        $batch_number = $batch_number + 1;
        return sprintf('%04d', $batch_number);
    }
    public function GenaratePatientSlug(){
        $lastProduct = DB::table('patients')->limit(1)->orderBy('id', 'DESC')->first();
        if (empty($lastProduct)) {
            return '0001';
        }
        return sprintf('%04d', $lastProduct->id + 1);
    } 
    public function GenarateInvoiceNumber($table, $slug = 'sale')
    {
        $lastProduct = DB::table($table)->limit(1)->orderBy('id', 'DESC')->first();
        if (empty($lastProduct)) {
            return strtoupper($slug) . '0001';
        }
        return strtoupper($slug) . sprintf('%04d', $lastProduct->id + 1);
    }
    public function getSiteInfo()
    {
        return DB::table('site_settings')->first();
    }

    public function convertNumberToWord($num = false)
    {
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return 'Undefined Taka Only.';
        }
        $num = (int) $num;
        if($num == 0){
            return 'Zero Taka Only.';
        }
        $words = array();
        $list1 = array(
            '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array(
            '', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int) ($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        $inword = implode(' ', $words);
        return ucwords($inword . 'Taka Only.');
    }

    public function StockIncrement($table, $column, $id, $qty)
    {
        DB::table($table)->where('id', $id)->increment($column, $qty);
    }
    public function StockDecrement($table, $column, $id, $qty)
    {
        DB::table($table)->where('id', $id)->decrement($column, $qty);
    }

    // public function newInvoice($parent_invoice, $invoice_number, $type, $jsonData)
    // {
    //     $invoice = new Invoice;
    //     $invoice->create([
    //         'parent_invoice'    => $parent_invoice,
    //         'invoice'           => $invoice_number,
    //         'type'              => $type,
    //         'json_data'         => $jsonData,
    //         'created_at'        =>  now()
    //     ]);
    // }

    public function getcustomerBalance($customer_id,$valueOnly = NULL){
        $diagnostic_dues    = Bill::where('patient_id',$customer_id)->sum('due'); //Diagnostic bill
        $admission_dues     = HmsAdmission::where('patient_id',$customer_id)->sum('due') + $this->bedChargeDue($customer_id);
        $dues               = Sale::where('patient_id',$customer_id)->sum('new_balance');
        $collection         = Transation::where('vendor_id',$customer_id)->where('vendor','Patient')->where('transaction_type','Collection')->sum('amount');
        $balance            = $admission_dues+$diagnostic_dues+$dues-$collection;
        if(!empty($valueOnly)){
            return ($balance);
        }
        return $this->amountFormatWithCurrency($balance);
    }
    public function getManufacturerBalance($manufacturer_id,$valueOnly = NULL){
        $total_payable = Purchase::where('manufacturer_id',$manufacturer_id)->where('status','Active')->sum('payable_amount');
        $paid          = Transation::where('vendor_id',$manufacturer_id)->where('vendor','Manufacturer')->where('transaction_type','Payment')->sum('amount');
        $received      = Transation::where('vendor_id',$manufacturer_id)->where('vendor','Manufacturer')->where('transaction_type','Received')->sum('amount');
        if(!empty($valueOnly)){
            return $total_payable-$paid+$received;
        }
        return $this->amountFormatWithCurrency($total_payable-$paid+$received);
    }
    public function getBankAccountBalance($account_id,$balance){
        // $account_open = DB::table('bank_accounts')->where('id',$account_id)->first()->balance;
        $total_debit  = DB::table('bank_transections')->where('bank_account_id',$account_id)->where('transection_type','debit')->where('status','Active')->sum('amount');
        $total_credit  = DB::table('bank_transections')->where('bank_account_id',$account_id)->where('transection_type','credit')->where('status','Active')->sum('amount');
        return $this->amountFormatWithCurrency($balance+$total_debit - $total_credit);
    }


    public function receivedPayment($data){
        $transaction = New Transation;
        $url = url('sale/invoice/'.$data['invoice']);
        $trans = $transaction->create([
            'date'                  => $data['date'],
            'trans_id'              => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
            'amount'                => $data['paid_amount'],
            'description'           => "Received from sales. <a target='_blank' href='{$url}'>{$data['invoice']}</a>",
            'vendor_id'             => $data['patient_id'],
            'user_id'               => $data['user_id'],
            'module'                => $this->getModule(),
            'created_at'            => now(),
        ]);
        return $trans;
    }
    public function makePayment($data){
        $transaction = New Transation;
        $transaction->create([
            'date'                  => $data['date'],
            'trans_id'              => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
            'amount'                => $data['amount'],
            'description'           => "Payment for Expense",
            'vendor'                => 'Expense',
            'vendor_id'             => $data['expense_category_id'],
            'transaction_type'      => 'Payment',
            'module'                => $this->getModule(),   
            'user_id'               => $data['user_id'],
            'created_at'            => now(),
        ]);
    }

    // public function makePayment($data){
    //     $transaction = New Transation;
    //     $url = url('sale/invoice/'.$saledata['invoice']);
    //     $transaction->create([
    //         'date'                  =>  date('Y-m-d', strtotime($request->date)),
    //         'trans_id'              => Pharma::GenarateInvoiceNumber('transations',session()->get('settings')[0]['transaction_prefix']),
    //         'amount'                => $request->amount,
    //         'description'           => $request->description,
    //         'transaction_way'       => $request->transaction_way,
    //         'bank_transaction_id'   => $bank_transaction_id,
    //         'transaction_type'      => $request->transaction_type,
    //         'vendor_id'             => $request->vendor_id,
    //         'vendor'                => $request->vendor,
    //         'user_id'               => Sentinel::getUser()->id,
    //         'created_at'            => now(),
    //     ]);
    // }


    public function getTimezones($selected = "Asia/Dhaka"){
        $option = '';
        $timezones = [
            "Africa/Abidjan",
            "Africa/Accra","Africa/Addis_Ababa","Africa/Algiers","Africa/Asmara","Africa/Asmera","Africa/Bamako","Africa/Bangui","Africa/Banjul","Africa/Bissau","Africa/Blantyre","Africa/Brazzaville","Africa/Bujumbura","Africa/Cairo","Africa/Casablanca","Africa/Ceuta","Africa/Conakry","Africa/Dakar","Africa/Dar_es_Salaam","Africa/Djibouti","Africa/Douala","Africa/El_Aaiun","Africa/Freetown","Africa/Gaborone","Africa/Harare","Africa/Johannesburg","Africa/Juba","Africa/Kampala","Africa/Khartoum","Africa/Kigali","Africa/Kinshasa","Africa/Lagos","Africa/Libreville","Africa/Lome","Africa/Luanda","Africa/Lubumbashi","Africa/Lusaka","Africa/Malabo","Africa/Maputo","Africa/Maseru","Africa/Mbabane","Africa/Mogadishu","Africa/Monrovia","Africa/Nairobi","Africa/Ndjamena","Africa/Niamey","Africa/Nouakchott","Africa/Ouagadougou","Africa/Porto-Novo","Africa/Sao_Tome",
            "Africa/Timbuktu","Africa/Tripoli","Africa/Tunis","Africa/Windhoek","AKST9AKDT","America/Adak","America/Anchorage","America/Anguilla","America/Antigua","America/Araguaina","America/Argentina/Buenos_Aires","America/Argentina/Catamarca","America/Argentina/ComodRivadavia","America/Argentina/Cordoba","America/Argentina/Jujuy","America/Argentina/La_Rioja","America/Argentina/Mendoza","America/Argentina/Rio_Gallegos","America/Argentina/Salta","America/Argentina/San_Juan","America/Argentina/San_Luis","America/Argentina/Tucuman","America/Argentina/Ushuaia","America/Aruba",
            "America/Asuncion","America/Atikokan","America/Atka","America/Bahia","America/Bahia_Banderas","America/Barbados","America/Belem","America/Belize","America/Blanc-Sablon","America/Boa_Vista",
            "America/Bogota","America/Boise","America/Buenos_Aires","America/Cambridge_Bay","America/Campo_Grande","America/Cancun","America/Caracas","America/Catamarca","America/Cayenne","America/Cayman","America/Chicago","America/Chihuahua","America/Coral_Harbour","America/Cordoba","America/Costa_Rica","America/Creston","America/Cuiaba","America/Curacao","America/Danmarkshavn","America/Dawson","America/Dawson_Creek","America/Denver","America/Detroit","America/Dominica","America/Edmonton","America/Eirunepe","America/El_Salvador","America/Ensenada","America/Fort_Wayne","America/Fortaleza","America/Glace_Bay","America/Godthab","America/Goose_Bay","America/Grand_Turk","America/Grenada","America/Guadeloupe","America/Guatemala","America/Guayaquil","America/Guyana","America/Halifax","America/Havana","America/Hermosillo","America/Indiana/Indianapolis","America/Indiana/Knox","America/Indiana/Marengo","America/Indiana/Petersburg","America/Indiana/Tell_City","America/Indiana/Vevay","America/Indiana/Vincennes","America/Indiana/Winamac","America/Indianapolis",
            "America/Inuvik","America/Iqaluit","America/Jamaica","America/Jujuy","America/Juneau","America/Kentucky/Louisville","America/Kentucky/Monticello","America/Knox_IN",
            "America/Kralendijk","America/La_Paz","America/Lima","America/Los_Angeles","America/Louisville","America/Lower_Princes","America/Maceio","America/Managua","America/Manaus","America/Marigot","America/Martinique","America/Matamoros","America/Mazatlan","America/Mendoza","America/Menominee","America/Merida","America/Metlakatla","America/Mexico_City","America/Miquelon","America/Moncton","America/Monterrey","America/Montevideo","America/Montreal","America/Montserrat","America/Nassau","America/New_York","America/Nipigon","America/Nome","America/Noronha","America/North_Dakota/Beulah","America/North_Dakota/Center","America/North_Dakota/New_Salem","America/Ojinaga",
            "America/Panama","America/Pangnirtung","America/Paramaribo","America/Phoenix","America/Port_of_Spain","America/Port-au-Prince","America/Porto_Acre",
            "America/Porto_Velho","America/Puerto_Rico","America/Rainy_River","America/Rankin_Inlet","America/Recife","America/Regina","America/Resolute","America/Rio_Branco","America/Rosario","America/Santa_Isabel","America/Santarem","America/Santiago","America/Santo_Domingo","America/Sao_Paulo","America/Scoresbysund","America/Shiprock","America/Sitka","America/St_Barthelemy","America/St_Johns","America/St_Kitts","America/St_Lucia","America/St_Thomas","America/St_Vincent","America/Swift_Current","America/Tegucigalpa","America/Thule","America/Thunder_Bay","America/Tijuana","America/Toronto","America/Tortola","America/Vancouver","America/Virgin","America/Whitehorse","America/Winnipeg","America/Yakutat","America/Yellowknife","Antarctica/Casey","Antarctica/Davis","Antarctica/DumontDUrville","Antarctica/Macquarie","Antarctica/Mawson","Antarctica/McMurdo","Antarctica/Palmer","Antarctica/Rothera","Antarctica/South_Pole","Antarctica/Syowa","Antarctica/Vostok","Arctic/Longyearbyen","Asia/Aden","Asia/Almaty","Asia/Amman","Asia/Anadyr","Asia/Aqtau","Asia/Aqtobe","Asia/Ashgabat","Asia/Ashkhabad","Asia/Baghdad","Asia/Bahrain","Asia/Baku","Asia/Bangkok","Asia/Beirut","Asia/Bishkek","Asia/Brunei","Asia/Calcutta","Asia/Choibalsan","Asia/Chongqing","Asia/Chungking","Asia/Colombo","Asia/Dacca","Asia/Damascus","Asia/Dhaka","Asia/Dili","Asia/Dubai","Asia/Dushanbe","Asia/Gaza","Asia/Harbin","Asia/Hebron","Asia/Ho_Chi_Minh","Asia/Hong_Kong","Asia/Hovd","Asia/Irkutsk","Asia/Istanbul","Asia/Jakarta","Asia/Jayapura","Asia/Jerusalem","Asia/Kabul","Asia/Kamchatka","Asia/Karachi","Asia/Kashgar","Asia/Kathmandu","Asia/Katmandu","Asia/Kolkata","Asia/Krasnoyarsk","Asia/Kuala_Lumpur","Asia/Kuching","Asia/Kuwait","Asia/Macao","Asia/Macau","Asia/Magadan","Asia/Makassar","Asia/Manila","Asia/Muscat","Asia/Nicosia","Asia/Novokuznetsk","Asia/Novosibirsk","Asia/Omsk","Asia/Oral","Asia/Phnom_Penh","Asia/Pontianak","Asia/Pyongyang","Asia/Qatar","Asia/Qyzylorda","Asia/Rangoon","Asia/Riyadh","Asia/Saigon","Asia/Sakhalin","Asia/Samarkand","Asia/Seoul","Asia/Shanghai","Asia/Singapore","Asia/Taipei","Asia/Tashkent","Asia/Tbilisi","Asia/Tehran","Asia/Tel_Aviv","Asia/Thimbu","Asia/Thimphu","Asia/Tokyo","Asia/Ujung_Pandang","Asia/Ulaanbaatar","Asia/Ulan_Bator","Asia/Urumqi","Asia/Vientiane","Asia/Vladivostok","Asia/Yakutsk","Asia/Yekaterinburg","Asia/Yerevan","Atlantic/Azores","Atlantic/Bermuda","Atlantic/Canary","Atlantic/Cape_Verde","Atlantic/Faeroe","Atlantic/Faroe","Atlantic/Jan_Mayen","Atlantic/Madeira","Atlantic/Reykjavik","Atlantic/South_Georgia","Atlantic/St_Helena","Atlantic/Stanley","Australia/ACT","Australia/Adelaide","Australia/Brisbane","Australia/Broken_Hill","Australia/Canberra","Australia/Currie","Australia/Darwin","Australia/Eucla","Australia/Hobart","Australia/LHI","Australia/Lindeman","Australia/Lord_Howe","Australia/Melbourne","Australia/North","Australia/NSW","Australia/Perth","Australia/Queensland","Australia/South","Australia/Sydney","Australia/Tasmania","Australia/Victoria","Australia/West","Australia/Yancowinna","Brazil/Acre","Brazil/DeNoronha","Brazil/East","Brazil/West","Canada/Atlantic","Canada/Central","Canada/Eastern","Canada/East-Saskatchewan","Canada/Mountain",
            "Canada/Newfoundland","Canada/Pacific","Canada/Saskatchewan","Canada/Yukon","CET","Chile/Continental","Chile/EasterIsland","CST6CDT","Cuba","EET","Egypt","Eire",
            "EST","EST5EDT","Etc./GMT","Etc./GMT+0","Etc./UCT","Etc./Universal","Etc./UTC","Etc./Zulu","Europe/Amsterdam",
            "Europe/Andorra","Europe/Athens","Europe/Belfast","Europe/Belgrade","Europe/Berlin","Europe/Bratislava","Europe/Brussels","Europe/Bucharest","Europe/Budapest","Europe/Chisinau","Europe/Copenhagen","Europe/Dublin","Europe/Gibraltar","Europe/Guernsey","Europe/Helsinki","Europe/Isle_of_Man","Europe/Istanbul","Europe/Jersey","Europe/Kaliningrad","Europe/Kiev","Europe/Lisbon","Europe/Ljubljana","Europe/London","Europe/Luxembourg","Europe/Madrid","Europe/Malta","Europe/Mariehamn","Europe/Minsk","Europe/Monaco","Europe/Moscow","Europe/Nicosia","Europe/Oslo","Europe/Paris","Europe/Podgorica","Europe/Prague","Europe/Riga","Europe/Rome","Europe/Samara","Europe/San_Marino","Europe/Sarajevo","Europe/Simferopol","Europe/Skopje","Europe/Sofia","Europe/Stockholm","Europe/Tallinn","Europe/Tirane","Europe/Tiraspol","Europe/Uzhgorod","Europe/Vaduz","Europe/Vatican","Europe/Vienna","Europe/Vilnius","Europe/Volgograd","Europe/Warsaw","Europe/Zagreb","Europe/Zaporozhye","Europe/Zurich","GB","GB-Eire","GMT","GMT+0","GMT0","GMT-0","Greenwich","Hong Kong","HST","Iceland","Indian/Antananarivo","Indian/Chagos","Indian/Christmas","Indian/Cocos","Indian/Comoro","Indian/Kerguelen","Indian/Mahe","Indian/Maldives","Indian/Mauritius","Indian/Mayotte","Indian/Reunion","Iran","Israel","Jamaica","Japan","JST-9","Kwajalein","Libya","MET","Mexico/BajaNorte","Mexico/BajaSur","Mexico/General","MST","MST7MDT","Navajo","NZ","NZ-CHAT","Pacific/Apia","Pacific/Auckland","Pacific/Chatham","Pacific/Chuuk","Pacific/Easter","Pacific/Efate","Pacific/Enderbury","Pacific/Fakaofo","Pacific/Fiji","Pacific/Funafuti","Pacific/Galapagos","Pacific/Gambier","Pacific/Guadalcanal","Pacific/Guam","Pacific/Honolulu","Pacific/Johnston","Pacific/Kiritimati","Pacific/Kosrae","Pacific/Kwajalein","Pacific/Majuro","Pacific/Marquesas","Pacific/Midway","Pacific/Nauru","Pacific/Niue","Pacific/Norfolk","Pacific/Noumea","Pacific/Pago_Pago","Pacific/Palau","Pacific/Pitcairn","Pacific/Pohnpei","Pacific/Ponape","Pacific/Port_Moresby","Pacific/Rarotonga","Pacific/Saipan","Pacific/Samoa","Pacific/Tahiti","Pacific/Tarawa","Pacific/Tongatapu","Pacific/Truk","Pacific/Wake","Pacific/Wallis","Pacific/Yap","Poland","Portugal","PRC","PST8PDT","ROC","ROK","Singapore","Turkey","UCT","Universal","US/Alaska","US/Aleutian","US/Arizona","US/Central","US/Eastern","US/East-Indiana","US/Hawaii",
            "US/Indiana-Starke","US/Michigan",
            "US/Mountain","US/Pacific","US/Pacific-New","US/Samoa",
            "UTC","WET","W-SU","Zul"
        ];

        foreach ($timezones as $val) {
            $option .= "<option value = '{$val}' ";
            $option .= ($selected == $val) ? 'selected' : '';
            $option .= ">" . ucfirst($val) . "</option>";
        }
        return $option;
    }

    public function getCurrencies ($selected = 9){
        $option = '';
        $currencies = DB::table('currencies')->get();
        foreach($currencies as $cur){
            $option .= "<option value = '{$cur->id}' ";
            $option .= ($selected == $cur->id) ? 'selected' : '';
            $option .= ">{$cur->country}-{$cur->currency}-{$cur->symbol}</option>";
        }
        return $option;
    }

    public function fileUpload($request, $input = 'image', $old = 'old_image', $path = '/uploads',$name = NULL) {
        $request->validate([
            $input => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile($input)) {
            if(!empty($old)){
                if(file_exists(public_path().$old)){
                    unlink(public_path().$old);
                }
            }
            $image = $request->file($input);
            $name = !empty($name) ? $name : time();
            $name = $name.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path($path);
            $image->move($destinationPath, $name);
            $url =  $path.'/'.$name;
            return $url;
        }
        if(!empty($old)){
            return $request->$old;
        }
        return '';
    }
    
    public function getScheduleDayWise($doctorId){
        $days = DB::table('doc_schedules')->where('doctor_id','=',$doctorId)->groupBy('week_day')->select('week_day','doctor_id')->get()->toArray();
        $week_day = [];
        foreach($days as $day){
            $week_day[] = $day->week_day;
        }
        // dd($week_day);
        return $week_day;
    }

    public function scheduleChart($day,$array,$doctor){
        $html = '';
        if(in_array($day,$array)){
            $html .= "<td class='event'>";
            $schedulesWeekDay = DocSchedule::where('doctor_id',$doctor->id)->where('week_day',$day)->where('status','Active')->get();
            foreach($schedulesWeekDay as $sch){
                $timeSlot = date('h:ia', strtotime($sch->start_time)).'-'.date('h:ia', strtotime($sch->end_time));
                $html .= "<div class='schedule'>";
                    $html .= "<h4 class='mb-0 bg-theme text-white font-weight-bold p-1'>{$sch->name}</h4>";
                    $html .= "<small>{$timeSlot}</small>";
                    $html .= "<p class='mb-0'>#p: {$sch->visit_qty}</p>";
                $html .= "</div>";
            }
            $html .= "</td>";
        }else{
            $html .= "<td></td>";
        }
        return $html;
    }

    public function getNextSerial($scheduleId,$date){
        $sl = DocAppointment::where('date',$date)->where('doc_schedule_id',$scheduleId)->count();
        return $sl+1;
    }

    public function getDayWisDoctorSchedule($doctorId,$scheduleId,$day){
        $appionts = DocAppointment::where('doctor_id',$doctorId)->where('doc_schedule_id',$scheduleId)->where('date',$day)->where('status','!=','Void')->get();
        return $appionts;
    }

    public function getDoctor(){
        $doctor = Doctor::where('own_user_id',Sentinel::getUser()->id)->first();
        return $doctor;
    }

    public function monthDays($m,$y){
        return date('t',strtotime($y.'-'.$m.'-01'));
    }

    public function attendanceDayCount($empId, $m = NULL , $y = NULL, $data = NULL){
        $att = new HrmAttendance;

        if(!empty($y)){
            $att = $att->where('date','like',$y.'%');
        }else{
            $att = $att->where('date','>=',date('Y-m-01'));
        }
        
        if(!empty($m)){
            $m = $y.'-'.$m;
            $att = $att->where('date','like',$m.'%');
        }else{
            $att->where('date','<=',date('Y-m-d'));
        }
        
        $days =  $att->where('emp_id',$empId)->groupBy('date')->get();
        
        if(!empty($data)){
            return $days;
        }
        return count($days);
    }

    public function employeeAttendance($empId, $m = NULL , $y = NULL){
        $att = new HrmAttendance;
        if(!empty($y)){
            $att = $att->where('date','like',$y.'%');
        }else{
            $att = $att->where('date','>=',date('Y-m-01'));
        }

        if(!empty($m)){
            $m = $y.'-'.$m;
            $att = $att->where('date','like',$m.'%');
        }else{
            $att->where('date','<=',date('Y-m-d'));
        }
        $att = $att->orderBy('date','ASC');
        $att = $att->orderBy('time','ASC');
        $att = $att->where('emp_id' , $empId);
        $attendance = $att->get();
        
        return $this->attendanceHourCount($attendance);
    }    

    public function attendanceHourCount($attendance){
        // $to_time = strtotime("10:42:00");
        // dd($to_time);
        // $from_time = strtotime("10:21:00");
        // echo round(abs($to_time - $from_time) / 60,2). " minute";
        // die();
        // dd($attendance);

        $state = 'In';
        $inTime = '00:00:00';
        $outTime = '00:00:00';
        $totalTime = 0;
        $i = 0;
        $flag = 'Out';
        foreach($attendance as $att){
            if($flag != $att->status){
                if($att->status == 'In'){
                    $inTime = $att->time;
                }else{
                    $out_time = strtotime($att->time);
                    // echo $att->time.' - '.$inTime.'<br>';
                    $in_time =  strtotime($inTime);
                    $time = round(abs($out_time - $in_time) / 60,2);
                    $totalTime += $time;
                    // echo $time.'<br>';
                    // echo $totalTime.'<br>';
                }
                $flag = $att->status;
                }

            $i++;
        }
        $total = $this->hoursandmins($totalTime);
        return $total;
    }

    public function hoursandmins($time, $format = '%02d:%02d'){
            if ($time < 1) {
                return;
            }
            $hours = floor($time / 60);
            $minutes = ($time % 60);
            $hours =  sprintf('%02d',$hours);
            $min =  sprintf('%02d',$minutes);
            return $hours.' Hour '.$min.' Minutes';
            // return sprintf($format, $hours, $minutes);
        }
}