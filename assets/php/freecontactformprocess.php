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

if(isset($_POST['Email_Address'])) {



	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	error_reporting(E_ALL);

	// ----------------------------------------------------------------------------------------------------
	// - Display Errors
	// ----------------------------------------------------------------------------------------------------
	ini_set('display_errors', 'On');
	ini_set('html_errors', 0);

	// ----------------------------------------------------------------------------------------------------
	// - Error Reporting
	// ----------------------------------------------------------------------------------------------------
	error_reporting(-1);

	// ----------------------------------------------------------------------------------------------------
	// - Shutdown Handler
	// ----------------------------------------------------------------------------------------------------
	function ShutdownHandler()
	{
		if(@is_array($error = @error_get_last()))
		{
			return(@call_user_func_array('ErrorHandler', $error));
		};

		return(TRUE);
	};

	register_shutdown_function('ShutdownHandler');

	// ----------------------------------------------------------------------------------------------------
	// - Error Handler
	// ----------------------------------------------------------------------------------------------------
	function ErrorHandler($type, $message, $file, $line)
	{
		$_ERRORS = Array(
			0x0001 => 'E_ERROR',
			0x0002 => 'E_WARNING',
			0x0004 => 'E_PARSE',
			0x0008 => 'E_NOTICE',
			0x0010 => 'E_CORE_ERROR',
			0x0020 => 'E_CORE_WARNING',
			0x0040 => 'E_COMPILE_ERROR',
			0x0080 => 'E_COMPILE_WARNING',
			0x0100 => 'E_USER_ERROR',
			0x0200 => 'E_USER_WARNING',
			0x0400 => 'E_USER_NOTICE',
			0x0800 => 'E_STRICT',
			0x1000 => 'E_RECOVERABLE_ERROR',
			0x2000 => 'E_DEPRECATED',
			0x4000 => 'E_USER_DEPRECATED'
		);

		if(!@is_string($name = @array_search($type, @array_flip($_ERRORS))))
		{
			$name = 'E_UNKNOWN';
		};

		return(print(@sprintf("%s Error in file \xBB%s\xAB at line %d: %s\n", $name, @basename($file), $line, $message)));
	};

	$old_error_handler = set_error_handler("ErrorHandler");



	//	include 'freecontactformsettings.php';
	$email_to = "smulhall1337@gmail.com";
	$email_subject = "new contact";

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

	$headers = 'From: '.$email_from."\r\n".
		'Reply-To: '.$email_from."\r\n" .
		'X-Mailer: PHP/' . phpversion();
	mail($email_to, $email_subject, $email_message, $headers);
	header("Location: $thankyou");
?>
<script>location.replace('<?php echo $thankyou;?>')</script>
<?php
}
die();
?>
