<?php 
 $send = mail("rgv.info51@gmail.com","PHP mail functionality check","PLEASE DO IGNORE THIS MAIL,this is a test mail to check the mailscript functionality","From:test@wishcart.co.in");
 if($send){
echo "PHP-mail script executed successfully from server ";
}else
 {
echo "sorry,message was not sent";
};
?>