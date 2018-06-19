<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * EmailUtility - Use to send email
 * */
class EmailUtility{
		
		/**
		 * Process the exception raised in system
		 *
		 * @param	array/string $to
		 * @param	string $subject 
		 * @param	string $template
		 * @param	array $emailTemplateData
		 * @param	array/string $attachments
		 * @param	array/string $cc
		 * @param	array/string $bcc
		 * @param	array/string $replyTo
		 * @return	true/false
		 */
		public static function sendEmail($to, $subject, $template , $emailTemplateData = array(), $attachments = null, $cc = null, $bcc = null, $replyTo = null)
		{
			try {
				$CI =& get_instance();
				/*Get setting from configuration table*/
				$configSettings = getConfiguration();
				$host = $configSettings['smtp_host'];
				$port = $configSettings['smtp_port'];
				$username = $configSettings['smtp_user'];
				$password = $configSettings['smtp_password'];

				$fromEmail = $configSettings['from_email'];
				$fromName = $configSettings['from_name'];
				$enableEmail = $configSettings['enable_email'];
				if(!$enableEmail) { /*if setting disable email sending then return from here*/
					//return false;
				}
				// Email configuration

				$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => $host,
					'smtp_port' => $port,
					'smtp_user' => $username, // change it to yours
					'smtp_pass' => $password, // change it to yours
					'mailtype' => 'html',
					'charset' => 'utf-8',
					'wordwrap' => TRUE,
					'validate' => FALSE
				);
                if(!$enableEmail) { /*if setting disable email sending then return from here*/
                    $config = Array(
                        'protocol' => 'sendmail',
                        'smtp_host' => $host,
                        'smtp_port' => $port,
                        //'smtp_user' => '', // change it to yours
                        //'smtp_pass' => '', // change it to yours
                        'mailtype' => 'html',
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE,
                        'validate' => FALSE
                    );
                }

				$CI->load->library('email', $config);
				$CI->email->from($fromEmail, $fromName);

				$CI->email->to($to);

				if ($cc) {
					$CI->email->cc($cc);
				}
				if ($bcc) {
					$CI->email->bcc($bcc);
				}
				if ($replyTo) {
					$CI->email->reply_to($replyTo);
				}
				if ($attachments) {
					if (is_array($attachments)) {
						foreach ($attachments as $file) {
							$CI->email->attach($file);
						}
					} else {
						$CI->email->attach($attachments);
					}
				}

				$CI->email->subject($subject);

				$emailHtml = $CI->load->view('email-templates/emailHeader', $emailTemplateData, TRUE);
				$emailHtml .= $CI->load->view('email-templates/' . $template, $emailTemplateData, TRUE); // this will return you html data as message
				$emailHtml .= $CI->load->view('email-templates/emailFooter', $emailTemplateData, TRUE);

				$CI->email->message($emailHtml);
				if ($isSend = $CI->email->send()) {
					$CI->email->clear(TRUE);
					return $isSend;
				}
			}catch(Exception $e) {
				//return false;
				print_r($e->getMessage());die;
			}
		}

}