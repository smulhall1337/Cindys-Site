<?php
/**
 * 
 * URL: www.freecontactform.com
 * 
 * Version: FreeContactForm Free V2.2
 * 
 * Copyright (c) 2013 Stuart Cochrane
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * 
 * Note: This is NOT the same code as the PRO version
 * 
 */


echo "before/n";
?>

<pre>
<?php var_dump($_POST); ?>
<?php var_dump($_SERVER); ?>
</pre>

<?php

include('Mail.php');
include('Mail/mime.php');
if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	
	if(isset($_POST['Email_Address'])) {

		echo "after first if";

		error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);

		set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/pear/php" . PATH_SEPARATOR . get_include_path());
		require_once "Mail.php";
		include 'freecontactformsettings.php';

		function died($error) {
			echo "Sorry, but there were error(s) found with the form you submitted. ";
			echo "These errors appear below.<br /><br />";
			echo $error."<br /><br />";
			echo "Please go back and fix these errors.<br /><br />";
			die();
		}

		if(!isset($_POST['Full_Name']) ||
			!isset($_POST['Email_Address']) ||
			!isset($_POST['Telephone_Number']) ||
			!isset($_POST['Your_Message']) || 
			!isset($_POST['AntiSpam'])		
		) {
			died('Sorry, there appears to be a problem with your form submission.');		
		}

		$full_name = $_POST['Full_Name']; // required
		$email_from = $_POST['Email_Address']; // required
		$telephone = $_POST['Telephone_Number']; // not required
		$comments = $_POST['Your_Message']; // required
		$antispam = $_POST['AntiSpam']; // required

		$error_message = "";

		$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
		if(preg_match($email_exp,$email_from)==0) {
			$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
		}
		if(strlen($full_name) < 2) {
			$error_message .= 'Your Name does not appear to be valid.<br />';
		}
		if(strlen($comments) < 2) {
			$error_message .= 'The Comments you entered do not appear to be valid.<br />';
		}

		if($antispam <> $antispam_answer) {
			$error_message .= 'The Anti-Spam answer you entered is not correct.<br />';
		}

		if(strlen($error_message) > 0) {
			died($error_message);
		}
		$email_message = "Form details below.\r\n";

		function clean_string($string) {
			$bad = array("content-type","bcc:","to:","cc:");
			return str_replace($bad,"",$string);
		}

		$email_message .= "Full Name: ".clean_string($full_name)."\r\n";
		$email_message .= "Email: ".clean_string($email_from)."\r\n";
		$email_message .= "Telephone: ".clean_string($telephone)."\r\n";
		$email_message .= "Message: ".clean_string($comments)."\r\n";

		//pear mail stuff
		$host = "ssl://smtp.gmail.com";
		$username = "smulhall1337@gmail.com";
		$password = "Agnryfaice1337";
		$port = "465";
		$to = "smulhall1337@gmail.com";
		

		$headers['From']    = $email_from;
		$headers['To']      = "smulhall1337@gmail.com";
		$headers['Subject'] = 'New Contact';
		$params['sendmail_path'] = '/usr/lib/sendmail';

		//create a mail object FIRST
		$mail_object =& Mail::factory('sendmail', $params);
		
	/*
		$headers = 'From: '.$email_from."\r\n".
			'Reply-To: '.$email_from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
	*/	
		var_dump($to);
		var_dump($headers);
		var_dump($email_message);

		//$smtip = Mail::factory('smtp', array('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
		//$mail = $smtp->send($to, $headers, $email_message);

		$mail = $mail_object->send($to, $headers, $email_message);


		if ($mail) {

		echo "good!";

		} else {

		//code here will never actually be executed.

		}

		
	/*
		if (PEAR::isError($mail)) {
			echo("<p>" . $mail->getMessage() . "</p>");
		}
		else {
			echo ("<p> success!</p>");
		}
	*/

	/*
		mail($email_to, $email_subject, $email_message, $headers);
		header("Location: $thankyou");
	 */
	?>
	<script>//location.replace('<?php echo $thankyou;?>')</script>

	<?php
	}
}
echo "dead";
die();
?>