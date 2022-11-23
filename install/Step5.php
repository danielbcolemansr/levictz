<?php

#**************************************************************************
#  openSIS is a free student information system for public and non-public 
#  schools from Open Solutions for Education, Inc. web: www.os4ed.com
#
#  openSIS is  web-based, open source, and comes packed with features that 
#  include student demographic info, scheduling, grade book, attendance, 
#  report cards, eligibility, transcripts, parent portal, 
#  student portal and more.   
#
#  Visit the openSIS web site at http://www.opensis.com to learn more.
#  If you have question regarding this system or the license, please send 
#  an email to info@os4ed.com.
#
#  This program is released under the terms of the GNU General Public License as  
#  published by the Free Software Foundation, version 2 of the License. 
#  See license.txt.
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#
#  You should have received a copy of the GNU General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
#***************************************************************************************
error_reporting(0);
session_start();
echo '<script type="text/javascript">
var page=parent.location.href.replace(/.*\//,"");
if(page && page!="index.php"){
	window.location.href="index.php";
	}

</script>';
$string='';
if (isset($_SESSION['mod']) && $_SESSION['mod']== 'upgrade') {

    $myFile = "../Data.php";
    $fh = fopen($myFile, 'w');

    if ($fh == TRUE) {
        $string .= "<" . "?php \n";
        $string .= "$" . "DatabaseType = 'mysqli'; \n";
        $string .= "$" . "DatabaseServer = '" . $_SESSION['server'] . "'; \n";
        $string .= "$" . "DatabaseUsername = '" . $_SESSION['username'] . "'; \n";
        $string .= "$" . "DatabasePassword = '" . $_SESSION['password'] . "'; \n";
        $string .= "$" . "DatabaseName = '" . $_SESSION['db'] . "'; \n";
        $string .= "$" . "DatabasePort = '" . $_SESSION['port'] . "'; \n";
        $string .="?" . ">";

        fwrite($fh, $string);
    }

    fclose($fh);
    $display_text = 'Your system has been successfully upgraded to version 7.5. Please click the button below<br/> to proceed to login with your existing login credentials.
';
    echo '<!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>openSIS Installer</title>
                <link href="../assets/css/icons/fontawesome/styles.min.css" rel="stylesheet">
                <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
                <link rel="stylesheet" href="assets/css/installer.css?v=' . rand(000, 999) . '" type="text/css" />
                <noscript><META http-equiv=REFRESH content="0;url=../EnableJavascript.php" /></noscript>
            </head>
            <body class="outer-body">
                <section class="login">
                    <div class="login-wrapper">
                        <div class="panel">
                        <div class="panel-heading">
                            <div class="logo">
                                <img src="assets/images/opensis_logo.png" alt="openSIS">
                            </div>
                            <h3>openSIS Installation - Complete</h3>
                        </div>
                        <div class="panel-body">
                            <div class="installation-steps-wrapper">
                                <div class="installation-instructions">
                                    <ul class="installation-steps-label">
                                        <li>Choose Package</li>
                                        <li>System Requirements</li>
                                        <li>Database Connection</li>
                                        <li>Database Selection</li>
                                        <li>School Information</li>
                                        <li>Site Admin Account Setup</li>
                                        <li class="active">Ready to Go!</li>
                                    </ul>
                                </div>
                                <div class="installation-steps">
                                    <div class="text-center"><img src="assets/images/check-clipart-animated.gif" width="80" /><h3 class="text-success">Congratulations! You have successfully upgraded openSIS</h3></div>
                                        
                                    <div class="padding-20 p-t-0 class="text-center"">
                                        <p class="text-center">' . $display_text . '</p>
                                        <div class="text-center"><br/><a href="../index.php?modfunc=logout&ins=comp" class="btn btn-success btn-lg" target="_parent">Proceed to openSIS Login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.panel-body -->
                        </div><!-- /.panel -->
                        <footer>
                            Copyright &copy; Open Solutions for Education, Inc. (<a href="http://www.os4ed.com">OS4Ed</a>).
                        </footer>
                    </div><!-- /.login-wrapper -->
                </section><!-- /.login -->
            </body>
        </html>';
} elseif ($_SESSION['mod'] != 'upgrade') {
    $myFile = "../Data.php";
    $fh = fopen($myFile, 'w');

    if ($fh == TRUE) {

        $THIS_server = sqlSecurityFilterIns($_SESSION['server']);
        $THIS_username = sqlSecurityFilterIns($_SESSION['username']);
        $THIS_password = sqlSecurityFilterIns($_SESSION['password']);
        $THIS_db = sqlSecurityFilterIns($_SESSION['db']);
        $THIS_port = sqlSecurityFilterIns($_SESSION['port']);

        $string .= "<" . "?php \n";
        $string .= "$" . "DatabaseType = 'mysqli'; \n";
        $string .= "$" . "DatabaseServer = '" . $THIS_server . "'; \n";
        $string .= "$" . "DatabaseUsername = '" . $THIS_username . "'; \n";
        $string .= "$" . "DatabasePassword = '" . $THIS_password . "'; \n";
        $string .= "$" . "DatabaseName = '" . $THIS_db . "'; \n";
        $string .= "$" . "DatabasePort = '" . $THIS_port . "'; \n";
        $string .="?" . ">";

        fwrite($fh, $string);
    }

    fclose($fh);
    $display_text = '';
    if ($_SESSION['school_installed'] == 'both') {

        $display_text = "A  school has been created in the name of: " . $_SESSION['sname'] . ".

You need to follow the instructions in the administrator manual for setting up the school properly. The manual is located in the docs folder.
<br><br>
You have also installed the sample school data. You can select your school or the sample school by clicking on the drop down menu of the school select field on the upper right hand corner.";
#You have also installed the sample school data, you can access it by clicking on the drop down menu  of  the school select field.";
    } else if ($_SESSION['school_installed'] == 'user') {
        $display_text = "A  school has been created in the name of: " . $_SESSION['sname'] . ".

You need to follow the instructions in the administrator manual for setting up the school properly. The manual is located in the docs folder.";
    } else if ($_SESSION['school_installed'] == 'sample') {
        $display_text = "You have installed openSIS with a sample school data. Use this school to get familiar with the system and as a guide for creating your own school.  You can also follow the instructions in the administrator manual for setting up and configuring a new school. The manual is located in the docs folder.";
    }
    $display_text = "You have installed openSIS with a sample school data. Use this school to get familiar with the system and as a guide for creating your own school.  You can also follow the instructions in the administrator manual for setting up and configuring a new school. The manual is located in the docs folder.";
    echo '<!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>openSIS Installer</title>
                <link href="../assets/css/icons/fontawesome/styles.min.css" rel="stylesheet">
                <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
                <link rel="stylesheet" href="assets/css/installer.css?v=' . rand(000, 999) . '" type="text/css" />
                <noscript><META http-equiv=REFRESH content="0;url=../EnableJavascript.php" /></noscript>
            </head>
            <body class="outer-body">
                <section class="login">
                    <div class="login-wrapper">
                        <div class="panel"">
                        <div class="panel-heading">                            
                            <div class="logo">
                                <img src="assets/images/opensis_logo.png" alt="openSIS">
                            </div>
                            <h3>openSIS Installation - Complete</h3>
                        </div>
                        <div class="panel-body">
                            <div class="installation-steps-wrapper">
                                <div class="installation-instructions">
                                    <ul class="installation-steps-label">
                                        <li>Choose Package</li>
                                        <li>System Requirements</li>
                                        <li>Database Connection</li>
                                        <li>Database Selection</li>
                                        <li>School Information</li>
                                        <li>Site Admin Account Setup</li>
                                        <li class="active">Ready to Go!</li>
                                    </ul>
                                </div>
                                <div class="installation-steps">
                                    <div class="padding-20 class="text-center"">
                                        <div class="text-center"><img src="assets/images/check-clipart-animated.gif" width="80" /><h3 class="text-success">Congratulations! You have successfully installed openSIS</h3></div>
                                        <div class="row" style="padding: 10px 0 0;">
                                            <div class="col-md-12 text-center">
                                                <!--<p style="padding: 0 30px 10px;">' . $display_text . '</p>
                                                <p style="padding: 0 30px;"><b>You can also visit the support portal and read the quick setup: <br/><a href="https://support.os4ed.com/hc/en-us/articles/200976357-Quick-Set-Up" target="_blank">https://support.os4ed.com/hc/en-us/articles/200976357-Quick-Set-Up</a></b></p>-->
                                            </div>
                                        </div>

                                        <div class="text-center" style="padding: 10px 0;"><a href="../index.php?modfunc=logout&ins=comp" class="btn btn-success btn-lg" target="_parent">Proceed to openSIS Login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.panel-body -->
                        </div><!-- /.panel -->
                        <footer>
                            Copyright &copy; Open Solutions for Education, Inc. (<a href="http://www.os4ed.com">OS4ED</a>).
                        </footer>
                    </div><!-- /.login-wrapper -->
                </section><!-- /.login -->
            </body>
        </html>';
    
} else {
    echo "<html><head><link rel='stylesheet' type='text/css' href='../styles/Installer.css'></head><body>
<div class=\"heading\">System Successfully Upgraded
<div style=\"background-image:url(images/step4.gif); background-repeat:no-repeat; background-position:50% 20px; height:270px;\">
<table border=\"0\" cellspacing=\"6\" cellpadding=\"3\" align=\"center\">
      <tr>
        <td  align=\"center\" style=\"padding-top:36px; padding-bottom:16px\">Step 3 of 3</td>
      </tr>
	  
      <tr>
        <td align=\"center\"><a href='../index.php?modfunc=logout'><img src='images/login.png' border=0 /></a></td>
      </tr>
 	</td>
      </tr>
    </table></div></div>
</body></html>
";
}
session_unset();
session_destroy();

function sqlSecurityFilterIns($variableName = '')
{
    $variable = $variableName;
    $check_stream = array('union ', 'select ', 'concat',  'concat_ws', 'create ', 'update ', 'insert ', 'delete ', 'extract ', 'drop ', 'truncate ', 'where ', 'trim ', 'format ', 'union%20', 'select%20', 'create%20', 'update%20', 'insert%20', 'delete%20', 'extract%20', 'drop%20', 'truncate%20', 'where%20', 'trim%20', 'format%20', ';', '\'', '--', '../', '..%2f', 'skip-grant-tables');

    if ($variable != '') {
        $checker = 0;
        $checker_k = 0;
        $checker_v = 0;
        if (is_array($variable)) {

            $filter_data = array();
            $neat_key = '';
            $neat_val = '';

            foreach ($variable as $onekey => $oneval) {

                $k_check_1      =   strip_tags($onekey);
                $k_check_2      =   addslashes($k_check_1);
                // $k_check_3      =   mysqli_real_escape_string($connection, $k_check_2);
                $k_check_4      =   strtolower($k_check_2);

                $v_check_1      =   strip_tags($oneval);
                $v_check_2      =   addslashes($v_check_1);
                // $v_check_3      =   mysqli_real_escape_string($connection, $v_check_2);
                $v_check_4      =   strtolower($v_check_2);

                foreach ($check_stream as $one_check) {
                    if (strpos($k_check_4, $one_check) !== false)
                    {
                        $checker_k++;
                    }
                    
                    if(strpos($v_check_4, $one_check) !== false)
                    {
                        $checker_v++;
                    }
                }

                if(is_array($oneval))
                {
                    $get_child_ret = sqlSecurityFilterIns($oneval); // being recursive

                    $filter_data[$k_check_3] = $get_child_ret;
                }
                else
                {
                    if($checker_k != 0 || $checker_v != 0)
                    {
                        unset($variable[$onekey]);
                    }
                    else
                    {
                        unset($variable[$onekey]);

                        // if(is_array($oneval))
                        // {
                        //  $get_child_ret = sqlSecurityFilter($oneval); // being recursive

                        //  $filter_data[$k_check_3] = $get_child_ret;
                        // }
                        // else
                        // {
                            $filter_data[$k_check_3] = $v_check_3;
                        // }
                    }
                }

                // $filter_data[] = $variable;
            }

            return $filter_data;

            unset($checker);
            unset($checker_k);
            unset($checker_v);
        } else {
            $check_1    =   strip_tags($variable);
            $check_2    =   addslashes($check_1);
            // $check_3    =   mysqli_real_escape_string($connection, $check_2);
            $check_4    =   strtolower($check_2);

            foreach ($check_stream as $one_check) {
                if (strpos($check_4, $one_check) !== false) {
                    $checker++;
                }
            }

            if ($checker == 0) {
                return $check_2;
            } else {
                return '';
            }
        }
    } else {
        return $variableName;
    }
}

?>
