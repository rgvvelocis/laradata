<?php
/* @This helper is used for Common functions*/
 
 
use App\Models\Role;  
use Illuminate\Support\Facades\Storage;
use App\Models\DataAssigned;
use App\Models\FinalSubmission;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



if (! function_exists('pr')) {
    function pr($request)
    {
		echo '<pre>';
		print_r($request);
        die;         
    }
}

if (! function_exists('pra')) {
    function pra($request)
    {
		pr($request->toArray());
    }
}
 
//Send Mail with template
function send_mailTemplate_($to, $subject, $templates, $data=null, $cc = null, $bcc = null, $applicationType = null)
{
    //require base_path("vendor/autoload.php");
    $mail = new PHPMailer(true);     // Passing `true` enables exceptions
 
            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST');             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');   //  sender username
            $mail->Password = env('MAIL_PASSWORD');       // sender password
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465

            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
            $mail->addAddress($to);
           // $mail->addCC($request->emailCc);
            //$mail->addBCC($request->emailBcc);

            $mail->addReplyTo(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));

         /*   if(isset($_FILES['emailAttachments'])) {
                for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                }
            } */


            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $subject;
           
            $mail->Body    = $templates;
            return   $mail->send();
            // $mail->AltBody = plain text version of email body;

          /*  if( !$mail->send() ) {
                return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
            }
            
            else {
                return back()->with("success", "Email has been sent.");
            } */
 
}

function send_mailTemplate($to, $subject, $templates, $data = null, $cc = null, $bcc = null, $applicationType = null)
{
    require base_path("vendor/autoload.php"); // Ensure PHPMailer is loaded
    $mail = new PHPMailer(true);  // Enable exceptions

    try {
        // Email server settings
        //$mail->SMTPDebug = 2; // Set to 2 for debugging
        $mail->isSMTP();
        $mail->Host = config('mail.mailers.smtp.host'); // SMTP Host
        $mail->SMTPAuth = true;
        $mail->Username = config('mail.mailers.smtp.username'); // SMTP Username
        $mail->Password = config('mail.mailers.smtp.password'); // SMTP Password
        $mail->SMTPSecure = config('mail.mailers.smtp.encryption'); // SSL/TLS
        $mail->Port = config('mail.mailers.smtp.port'); // SMTP Port

        // Sender & Recipient
        $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
        $mail->addAddress($to);

        // CC & BCC (if provided)
        if (!empty($cc)) {
            $mail->addCC($cc);
        }
        if (!empty($bcc)) {
            $mail->addBCC($bcc);
        }

        $mail->addReplyTo(config('mail.from.address'), config('mail.from.name'));

        // Email format & content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $templates;

        // Send Email
        if ($mail->send()) {
            return true; // Success
        } else {
            return false; // Failure
        }
    } catch (Exception $e) {
        \Log::error("Mail error: " . $mail->ErrorInfo);
        return false;
    }
}

/*
*send OTP
*/
if (! function_exists('generateOTP')) {
    function generateOTP()
    {
        return rand(10000, 99999);
        //return '11111';
        //return '12345';
    }
}

function random_string($str_len = 30)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $result = '';
    for ($i = 0; $i < $str_len; $i++) {
        $result .= $characters[mt_rand(0, 61)];
    }

    return $result;
}
function random_numeric($str_len = 30)
{
    $randnum = rand(1111111111, mt_getrandmax());

    return  $randnum;
}
function saveMedia($file, $repository_name = '/brochure', $str_len = 5, $file_permission = 'public')
{
    $disk_name = 'uploads';
    $filename = random_string($str_len).'_'.time().'.'.$file->getClientOriginalExtension();
    Storage::disk('uploads')->put($repository_name.'/'.$filename, file_get_contents($file->getRealPath()), $file_permission);

    return '/'.$disk_name.(($repository_name != '') ? $repository_name.'/' : '').$filename;
}
function getAmountInWords(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = [];
    $words = [0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety', ];
    $digits = ['', 'hundred', 'thousand', 'lakh', 'crore'];
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number].' '.$digits[$counter].$plural.' '.$hundred : $words[floor($number / 10) * 10].' '.$words[$number % 10].' '.$digits[$counter].$plural.' '.$hundred;
        } else {
            $str[] = null;
        }
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? '.'.($words[$decimal / 10].' '.$words[$decimal % 10]).' Paise' : '';

    return ($Rupees ? $Rupees.'Rupees ' : '').$paise;
}

function getNumberInWords($number)
{
	if($number == 0)
	{
		return 'zero';
	}elseif($number == 1)
	{
		return 'one';
	}elseif($number == 2)
	{
		return 'two';
	}elseif($number == 3)
	{
		return 'three';
	}elseif($number == 4)
	{
		return 'four';
	}elseif($number == 5)
	{
		return 'five';
	}else{
		return 'wrong';
	}
}

function getWordsInNumber($number)
{
	if($number == 'zero')
	{
		return 0;
	}elseif($number == 'one')
	{
		return 1;
	}elseif($number == 'two')
	{
		return 2;
	}elseif($number == 'three')
	{
		return 3;
	}elseif($number == 'four')
	{
		return 4;
	}elseif($number == 'five')
	{
		return 5;
	}else{
		return '';
	}
}

function getGender($gen)
{
    if ($gen == 'M') {
        return 'Male';
    } elseif ($gen == 'F') {
        return 'Female';
    } elseif ($gen == 'T') {
        return 'Transgender';
    }
}

function IndMoneyFormat($number)
{
    $decimal = (string) ($number - floor($number));
    $money = floor($number);
    $length = strlen($money);
    $delimiter = '';
    $money = strrev($money);

    for ($i = 0; $i < $length; $i++) {
        if (($i == 3 || ($i > 3 && ($i - 1) % 2 == 0)) && $i != $length) {
            $delimiter .= ',';
        }
        $delimiter .= $money[$i];
    }

    $result = strrev($delimiter);
    $decimal = preg_replace("/0\./i", '.', $decimal);
    $decimal = substr($decimal, 0, 3);

    if ($decimal != '0') {
        $result = $result.$decimal;
    }

    return $result;
}

function getRoles()
{
    $result = Role::where('id', '!=', 1)->get();

    return $result;
}
 
 
 function assigndata_num($userid,$planid)
 {
	 return DataAssigned::where('user_id',$userid)->where('plan_id',$planid)->count();
 }

function checkSubmit($user_id)
{
	return FinalSubmission::where('user_id',$user_id)->where('sub_status',1)->count(); 
}
?>

