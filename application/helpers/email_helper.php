<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * getNotificationTheme()
 * 
 * @param mixed $message
 * @param mixed $subject
 * @param string $filePath
 * @return
 */
function getNotificationTheme($emailTitle, $subject, $message) {
    // Call Codeigniter Instance
    $CI = & get_instance();
    $baseURL = HTTP_PATH;
    $siteName = SITE_NAME;

    //Notification themem file path.
    $filePath = str_replace("\\", "/", dirname(dirname(dirname(__FILE__)))) . "/application/views/notification.html";

    //Get HTML contents of theme file.
    $fileContents = file_get_contents($filePath);

    //Search with this patterns
    $searchPatterns[0] = '<<!--currentdate-->>';
    $searchPatterns[1] = '<<!--subject-->>';
    $searchPatterns[2] = '<<!--contents-->>';
    $searchPatterns[3] = '<<!--baseURL-->>';
    $searchPatterns[4] = '<<!--siteName-->>';
    $searchPatterns[5] = '<<!--emailTitle-->>';

    //Replace with this values
    $replaceBy[0] = date(FRONTEND_DATE_VIEW_FORMAT);
    $replaceBy[1] = $subject;
    $replaceBy[2] = $message;
    $replaceBy[3] = $baseURL;
    $replaceBy[4] = $siteName;
    $replaceBy[5] = $emailTitle;

    //Return the theme processed contents.
    return preg_replace($searchPatterns, $replaceBy, $fileContents);
}

function sendMail($to, $msg, $subject) {
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.cisinlabs.com';
    $config['smtp_port'] = '465';
    $config['smtp_timeout'] = '7';
    $config['smtp_user'] = 'vishal.patidar@cisinlabs.com';
    $config['smtp_pass'] = 'aEUh8Kdcr4';
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html'; // or html
    $config['validation'] = FALSE; // bool whether to validate email or not  
    $ci = get_instance();
    $ci->load->library('email');
    $ci->email->initialize($config);
    $ci->email->from('http://biznetafrica.rt.cisinlive.com/', SITE_NAME);
    $ci->email->to($to);
    $ci->email->subject($subject);
    $ci->email->message($msg);
    if ($ci->email->send()) {
        return true;
    }
    else {
        return false;
    }
}

function sendForgotPassword($data) {
    $title = SITE_NAME;
    $subject = 'Forgot Password Notification at ' . SITE_NAME;
    $pass_text = $data['user_password'];
    $messae_txt=SITE_NAME." received a request to forgot password for your account.";
    $to = $data['user_primary_email'];
    $name = $data['user_name'];
    $siteURL = HTTP_PATH;
    $message = '';
    $message .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">
                '.$data['content_message'].'    
                <tr style="font-family:segoe UI, Arial, sans-serif; font-size:12px;">';
    $message .= '<td>Thanks and regards,<br />';
    $message .= '<a href="' . HTTP_PATH . '">' . SITE_NAME . '</a><br />';
    $message .= '</td></tr>';
    $message .= '</table>';
    $message .= '';
    $body = getNotificationTheme($title, $subject, $message);
    $check = sendMail($to, $body, $subject);
    return $check;
}

function sendRegistrationMail($user_password, $email, $user_email_token, $name) {
    $title = SITE_NAME;
    $subject = 'Verify your Account';
    $pass_text = 'Your account Password is: ' . $user_password;
    $active_link_text = 'To verify your account please click here: ';
    $active_link = HTTP_PATH . 'auth/email_verification/' . $email . '/' . md5($user_email_token);
    $to = $email;
    $name = $name;
    $siteURL = HTTP_PATH;

    $message = '';
    $message .='<tr>
                <td bgcolor="#2182B7" style="font-family:segoe UI, Arial, sans-serif; font-size:13px; color:#FFF; padding:6px 10px;">
                   <font style="font-size:15px;">' . $subject . '</font>
                </td>
                </tr>';
    $message .= '<tr>';
    $message .= '<td valign="top" bgcolor="#ffffff" style="padding:12px;">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td height="26" style="font-family:Tahoma, Arial, sans-serif; font-size:12px;color:#575757;">
                        <strong>Hi ' . ucfirst(@$name) . ',</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Tahoma, Arial, sans-serif; font-size:11px; color:#575757; line-height:15px; padding-bottom:10px;font-size:12px;">' . $pass_text . '</td>
                    </tr>
                    <tr>
                        <td style="font-family:Tahoma, Arial, sans-serif; font-size:11px; color:#575757; line-height:15px; padding-bottom:10px;font-size:12px;">' . $active_link_text . '<a href="' . $active_link . '">Verify Account.</a></td>
                    </tr>';
    $message .='<tr>
                    <td height="5">
                    
                    </td>
                    </tr>';
    $message .='<tr><td>
                    </td>
                </tr>
                <tr>
                    <td height="25"></td>
                </tr>
                <tr style="color:black;">

                ';
    $message .= '<td>Thanks and regards,<br />';
    $message .= '<a href="' . HTTP_PATH . '">' . SITE_NAME . '</a><br />';
    $message .= '</td></tr>';
    $message .= '</table>';
    $message .= '</tr>';

    $body = getNotificationTheme($title, $subject, $message);

    $check = sendMail($to, $body, $subject);

    return $check;
}
