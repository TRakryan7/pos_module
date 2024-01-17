<?php
//getting base url for actual path
$root=(isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["HTTP_HOST"];
$root.= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
$base_url = $root;

$install_path = $_SERVER['DOCUMENT_ROOT']; //
$install_path.= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
$root_path_project = str_replace("install/", "", $install_path);

$indexFile = $root_path_project."index.php";
$configFolder = $root_path_project."application/config";
$configFile = $root_path_project."application/config/config.php";
$dbFile = $root_path_project."application/config/database.php";

session_start();

$step = isset($_GET['step']) ? $_GET['step'] : '';
switch ($step) {
    default: ?>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="list">
                        <li class="active pk"><i class="icon-ok"></i>Env. Check</li>
                        <li>Verification</li>
                        <li>DB Config</li>
                        <li>Site Config</li>
                        <li class="last">Complete!</li>
                    </ul>
                </div>
                <div class="panel-body">
                    <h3 class="text-center padding_70">Server Environment Checklist</h3>
                    <?php
                    $error = FALSE;
                    if (!is_writeable($indexFile)) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Index File (index.php) is not write able!</div>";
                    }
                    if (!function_exists('file_get_contents')) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> file_get_contents() function is not enabled in your server !</div>";
                    }
                    if (!is_writeable($configFolder)) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Config Folder (application/config/) is not write able!</div>";
                    }
                    if (!is_writeable($configFile)) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Config File (application/config/config.php) is not write able!</div>";
                    }
                    if (!is_writeable($dbFile)) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Database File (application/config/database.php) is not writable!</div>";
                    }
                    if (phpversion() < "7.0") {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Your PHP version is ".phpversion()."! PHP 7.0 or higher required!</div>";
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> You are running PHP ".phpversion()."</div>";
                    }
                    if (!extension_loaded('mysqli')) {
                        $error = TRUE;
                        echo "<div class='alert alert-error'><i class='icon-remove'></i> Mysqli PHP extension missing!</div>";
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> Mysqli PHP extension loaded!</div>";
                    }
                    if (!extension_loaded('curl')) {
                        $error = TRUE;
                        echo "<div class='alert alert-error'><i class='icon-remove'></i> CURL PHP extension missing!</div>";
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> CURL PHP extension loaded!</div>";
                    }
                    ?>
                    <div class="bottom">
                        <?php if ($error) { ?>
                            <a href="#" class="btn btn-primary button_1">Next</a>
                        <?php } else { ?>
                            <a href="<?php echo $base_url?>index.php?step=0" class="btn btn-primary button_1">Next</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        break;
    case "0": ?>
        <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
            <ul class="list">
                <li>Env. Check</li>
                <li class="active"><i class="icon icon-ok"></i>Verification</li>
                <li>DB Config</li>
                <li>Site Config</li>
                <li class="last">Complete!</li>
            </ul>
        </div>
        <div class="panel-body">
        <h3 class="ins_h3">Verify your purchase</h3>
        <?php
        if ($_POST) {
            $purchase_code = $_POST["purchase_code"];
            $username = $_POST["username"];
            if (1 == 1) {
                ?>
                <form action="<?php echo $base_url?>index.php?step=1" method="POST" class="form-horizontal">
                    <div class="alert alert-success"><i class='icon-ok'></i> <strong>Success</strong>:<br />Congrats! You license is now activated</div>
                    <input id="purchase_code" type="hidden" name="purchase_code" value="<?php echo $purchase_code;
                    ?>" />
                    <input id="username" type="hidden" name="username" value="<?php echo $username;?>" />
                    <div class="bottom ins_5">
                        <input type="submit" class="btn btn-primary button_1"  value="Next"/>
                    </div>
                </form>
                <?php
            } else {
                ?>
                <?php

                echo "<div class='alert alert-error'><i class='icon-remove'></i>Please buy a brain before using this script</div>";
                ?>
                <form action="<?php echo $base_url?>index.php?step=0" method="POST" class="form-horizontal">
                    <div class="control-group ins_2">
                        <label class="control-label" for="username">A Fake Username</label>
                        <div class="controls">
                            <input  id="username" type="text" name="username" class="input-large ins_4_" required="required" data-error="Username is required" placeholder="A Fake Username" />
                        </div>
                    </div>
                    <div class="control-group ins_2">
                        <label class="control-label" for="purchase_code">A Fake Purchase Code</label>
                        <div class="controls">
                            <input id="purchase_code" type="text" name="purchase_code" class="input-large ins_4_" required="required" data-error="A Fake Purchase Code is required" placeholder="A Fake Purchase Code" />
                        </div>
                    </div>
                    <div class="bottom ins_5">
                        <input type="submit" class="btn btn-primary button_1"  value="Verify"/>
                    </div>
                </form>
                <?php
            }
        } else {
            ?>
            <p class="ins_6">Please provide your fake purchase information </p>
            <form action="<?php echo $base_url?>index.php?step=0" method="POST" class="form-horizontal">
                <div class="control-group ins_14">
                    <label class="control-label" for="username">A Fake Username</label>
                    <div class="controls">
                        <input id="username" type="text" name="username" class="input-large ins_4" required="required" data-error="Username is required" placeholder="A Fake Username" />
                    </div>
                </div>
                <div class="control-group ins_14">
                    <label class="control-label" for="purchase_code">A Fake Purchase Code</label>
                    <div class="controls">
                        <input id="purchase_code" required="required" type="text" name="purchase_code" class="input-large ins_4 "  data-error="A Fake Purchase Code is required" placeholder="A Fake Purchase Code" />
                    </div>
                </div>

                <div class="bottom ins_5">
                    <input type="submit" class="btn btn-primary button_1"  value="Verify"/>
                </div>
            </form>

            </div>
            </div>
            </div>
            <?php
        }
        break;
    case "1": ?>

    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="list">
                    <li class="ok">Env. Check</li>
                    <li>Verification</li>
                    <li class="active"><i class="icon-ok"></i>DB Config</li>
                    <li>Site Config</li>
                    <li class="last">Complete!</li>
                </ul>
            </div>
            <div class="panel-body">
            <?php
            if ($_POST) {
                ?>
                <h3 class="ins_h3">Database Configuration</h3 cl>
                <p class="ins_2">Please create a database in your server. And enter the db information here.</p>
                <form action="<?php echo $base_url?>index.php?step=2" method="POST" class="form-horizontal">
                    <div class="control-group ins_3">
                        <label class="control-label" for="db_hostname">Database Host</label>
                        <div class="controls">
                            <input id="db_hostname" type="text" name="db_hostname" class="input-large ins_4" required data-error="DB Host is required" placeholder="DB Host" value="localhost" />
                            <i class="color_red">Host name could be 127.0.0.1 or localhost or your server hostname</i>
                        </div>
                    </div>
                    <div class="control-group ins_3">
                        <label class="control-label" for="db_username">Database Username</label>
                        <div class="controls">
                            <input  id="db_username" type="text" name="db_username" class="input-large ins_4" autocomplete="off" required data-error="DB Username is required" placeholder="DB Username" />
                        </div>
                    </div>
                    <div class="control-group ins_3">
                        <label class="control-label" for="db_password">Database Password</label>
                        <div class="controls">
                            <input  id="db_password" type="password" name="db_password" class="input-large ins_4" autocomplete="off" data-error="DB Password is required" placeholder="DB Password" />
                        </div>
                    </div>
                    <div class="control-group ins_3">
                        <label class="control-label" for="db_name">Database Name</label>
                        <div class="controls">
                            <input  id="db_name" type="text" name="db_name" class="input-large ins_4" autocomplete="off" required data-error="DB Name is required" placeholder="DB Name" />
                        </div>
                    </div>
                    <input id="purchase_code" type="hidden" name="purchase_code" value="<?php echo $_POST['purchase_code']; ?>" />
                    <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                    <div class="bottom ins_5">
                        <input type="submit" class="btn btn-primary button_1"  value="Next"/>
                    </div>
                </form>
                <?php
            }else{
                header("Location: $base_url");
            }

            ?>
            </div>
        </div>
    </div>

    <?php
    break;
    case "2":
        ?>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="list">
                        <li >Env. Check</li>
                        <li>Verification</li>
                        <li class="ok"><i class="icon-ok"></i> DB Config</li>
                        <li>Site Config</li>
                        <li class="last">Complete!</li>
                    </ul>
                </div>
                <div class="panel-body">
                    <h3 class="ins_6">Saving database config</h3>
                    <?php
                    if ($_POST) {
                        $db_hostname = trim($_POST["db_hostname"]);
                        if(isset($db_hostname) && $db_hostname){
                        }else{
                            header("Location: $base_url");
                        }
                        $db_username = trim($_POST["db_username"]);
                        $db_password = trim($_POST["db_password"]);
                        $db_name = trim($_POST["db_name"]);
                        $link = mysqli_connect($db_hostname, $db_username, $db_password);
                        if (mysqli_connect_errno()) {
                            echo "<div class='alert alert-error'><i class='icon-remove'></i> Could not connect to MYSQL!</div>";
                        } else {
                            echo '<div class="alert alert-success"><i class="icon-ok"></i> Connection to MYSQL successful!</div>';
                            $db_selected = mysqli_select_db($link, $db_name);
                            if (!$db_selected) {
                                if (!mysqli_query($link, "CREATE DATABASE IF NOT EXISTS `$db_name`")) {
                                    echo "<div class='alert alert-error'><i class='icon-remove'></i> Database " . $db_name . " does not exist and could not be created. Please create the Database manually and retry this step.</div>";
                                    return FALSE;
                                } else {
                                    echo "<div class='alert alert-success'><i class='icon-ok'></i> Database " . $db_name . " created</div>";
                                }
                            }
                            mysqli_select_db($link, $db_name);

                            require_once($install_path.'includes/core_class.php');
                            $core = new Core();
                            $dbdata = array(
                                'db_hostname' => $db_hostname,
                                'db_username' => $db_username,
                                'db_password' => $db_password,
                                'db_name' => $db_name
                            );

                            if ($core->write_database($dbdata) == false) {
                                echo "<div class='alert alert-error'><i class='icon-remove'></i> Failed to write database details to ".$dbFile."</div>";
                            } else {
                                echo "<div class='alert alert-success'><i class='icon-ok'></i> Database config written to the database file.</div>";
                            }

                        }
                    } else { echo "<div class='alert alert-success'><i class='icon-question-sign'></i> Nothing to do...</div>"; }
                    ?>
                    <div class="bottom">
                        <form action="<?php echo $base_url?>index.php?step=1" method="POST" class="form-horizontal">
                            <input id="purchase_code" type="hidden" name="purchase_code" value="<?php echo isset($_POST['purchase_code']) && $_POST['purchase_code']?$_POST['purchase_code']:''; ?>" />
                            <input id="username" type="hidden" name="username" value="<?php echo isset($_POST['username'])?$_POST['username']:''; ?>" />
                            <div class="bottom ins_5">
                                <input type="submit" class="btn btn-primary button_1"  value="Previous"/>
                            </div>
                        </form>
                        <form action="<?php echo $base_url?>index.php?step=3" method="POST" class="form-horizontal">
                            <input id="purchase_code" type="hidden" name="purchase_code" value="<?php echo isset($_POST['purchase_code']) && $_POST['purchase_code']?$_POST['purchase_code']:''; ?>" />
                            <input id="username" type="hidden" name="username" value="<?php echo isset($_POST['username'])?$_POST['username']:''; ?>" />

                            <div class="bottom ins_5">
                                <input type="submit" class="btn btn-primary button_1"  value="Next"/>
                            </div>
                        </form>
                        <br clear="all">
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;
    case "3":
        ?>
        <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
            <ul class="list">
                <li>Env. Check</li>
                <li>Verification</li>
                <li>DB Config</li>
                <li class="ok"><i class="icon icon-ok"></i>Site Config</li>
                <li class="last">Complete!</li>
            </ul>
        </div>
        <div class="panel-body">
        <h3 class="ins_7">Site Config</h3>
        <?php
        if ($_POST) {
            ?>
            <form action="<?php echo $base_url?>index.php?step=4" method="POST" class="form-horizontal">
                <div class="control-group ins_13">
                    <label class="control-label" for="installation_type">Installation Type</label>
                    <div class="controls">
                        <select class="xlarge ins_4" name="installation_type" id="installation_type">
                            <option value="sGmsJaFJE" selected="selected">Multiple outlets + Whitelabel + Saas</option>
                            <option value="revhgbrev">Multiple outlets + Whitelabel</option>
                            <option value="stwtyqxst">Unique outlet + Whitelabel</option>
                        </select>
                    </div>
                </div>
                <div class="control-group ins_13">
                    <label class="control-label" for="installation_url">Installation URL</label>
                    <div class="controls">
                        <input  type="text" id="installation_url" name="installation_url" class="xlarge ins_4" required data-error="Installation URL is required" value="<?php echo (isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24); ?>" />
                    </div>
                </div>
                <div class="control-group ins_13">
                    <label class="control-label" for="Encryption Key">Encryption Key</label>
                    <div class="controls">
                        <input type="text" id="enckey" name="enckey" class="xlarge ins_4" required data-error="Encryption Key is required"
                               value="<?php

                               $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                               $charactersLength = strlen($characters);
                               $randomString = '';
                               for ($i = 0; $i < 6; $i++) {
                                   $randomString .= $characters[rand(0, $charactersLength - 1)];
                               }

                               echo $randomString;

                               ?>"
                               readonly />
                    </div>
                </div>
                <input type="hidden" name="purchase_code" value="<?php echo $_POST['purchase_code']; ?>" />
                <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                <div class="bottom">
                    <a href="<?php echo $base_url?>index.php?step=2" class="btn btn-primary button_1">Previous</a>
                    <div class="bottom ins_5">
                        <input type="submit" class="btn btn-primary button_1"  value="Next"/>
                    </div>
                </div>
            </form>
            </div>
            </div>
            </div>

            <?php
        }else{
            header("Location: $base_url");
        }
        break;
    case "4":
        ?>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="list">
                        <li>Env. Check</li>
                        <li class="active">Verification</li>
                        <li>DB Config</li>
                        <li class="ok"><i class="icon icon-ok"></i>Site Config</li>
                        <li>Complete!</li>
                    </ul>
                </div>
                <div class="panel-body">
                    <h3 class="ins_7">Saving site config</h3>
                    <?php
                    if ($_POST) {
                        $installation_type = $_POST['installation_type'];
                        $installation_url = $_POST['installation_url'];
                        $enckey = $_POST['enckey'];
                        $purchase_code = $_POST["purchase_code"];
                        $username = $_POST["username"];
                        require_once($install_path.'includes/core_class.php');
                        $core = new Core();
                        if ($core->write_config($installation_url, $enckey) == false) {
                            echo "<div class='alert alert-error'><i class='icon-remove'></i> Failed to write config details to ".$configFile."</div>";
                        } else {
                            echo "<div class='alert alert-success'><i class='icon-ok'></i> Config details written to the config file.</div>";
                        }

                    } else { echo "<div class='alert alert-success'><i class='icon-question-sign'></i> Nothing to do...</div>"; }
                    ?>
                    <div class="bottom">
                        <form action="<?php echo $base_url?>index.php?step=2" method="POST" class="form-horizontal">
                            <input id="purchase_code" type="hidden" name="purchase_code" value="<?php echo $_POST['purchase_code']; ?>" />
                            <input id="username" type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                            <input id="installation_url" type="hidden" name="installation_url" value="<?php echo $_POST['installation_url']; ?>" />
                            <input id="installation_type" type="hidden" name="installation_type" value="<?php echo $_POST['installation_type']; ?>" />
                            <div class="bottom">
                                <div class="bottom ins_5">
                                    <input type="submit" class="btn btn-primary button_1"  value="Previous"/>
                                </div>
                            </div>
                        </form>
                        <form action="<?php echo $base_url?>index.php?step=5" method="POST" class="form-horizontal">
                            <input id="purchase_code" type="hidden" name="purchase_code" value="<?php echo $_POST['purchase_code']; ?>" />
                            <input id="username" type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                            <input id="installation_type" type="hidden" name="installation_type" value="<?php echo $_POST['installation_type']; ?>" />
                            <div class="bottom">
                                <div class="bottom ins_5">
                                    <input type="submit" class="btn btn-primary button_1"  value="Next"/>
                                </div>
                            </div>
                        </form>
                        <br clear="all">
                    </div>
                </div>
            </div>
        </div>

        <?php
        break;
    case "5": ?>
        <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
            <ul class="list">
                <li>Env. Check</li>
                <li>Verification</li>
                <li>DB Config</li>
                <li>Site Config</li>
                <li class="ok"><i class="icon icon-ok"></i>Complete!</li>
            </ul>
        </div>
        <div class="panel-body">

        <?php
        $finished = FALSE;
        if ($_POST) {
            $installation_type = $_POST['installation_type'];
            $username = $_POST["username"];
            $purchase_code = $_POST["purchase_code"];
            define("BASEPATH", "install/");
            include($root_path_project."application/config/database.php");
            require_once($install_path.'includes/core_class.php');
            $core = new Core();
            $pc_hostname = $core->macorhost();
            $installation_url = (isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24);
            $installation_date_and_time = date('Y-m-d h:i:s');
            $file = file_get_contents('db/babia.to');
            if($file === false) die('Error db file: the file is empty or not exists');
            $localdb = json_decode($file);
            if (1 == 1) {
                $personalinfo = $core->personalinfo($username, $purchase_code, $installation_url);
                //need to change
                $dbtables = str_replace('XXXXX', $installation_type, $localdb->database);
                if($installation_type == 'sGmsJaFJE'){
                    $dbtables = str_replace('sGmsJaFJVE1', 'sGmsJaFJVE', $dbtables);
                    $dbtables = str_replace('sGmsJaFJVEFCrt1', 'sGmsJaFJVEFCrt', $dbtables);
                }
                $dbtables = str_replace('YYYYY', $personalinfo, $dbtables);
                $dbdata = array(
                    'hostname' => $db['default']['hostname'],
                    'username' => $db['default']['username'],
                    'password' => $db['default']['password'],
                    'database' => $db['default']['database'],
                    'dbtables' => $dbtables
                );
                require_once($install_path.'includes/database_class.php');
                $database = new Database();
                if ($database->create_tables($dbdata) == false) {
                    echo "<div class='alert alert-warning'><i class='icon-warning'></i> The database tables could not be created, please try again.</div>";
                } else {
                    $finished = TRUE;
                    $core->create_rest_api();
                    //need to change
                    $core->create_rest_api_UV();
                    //need to change
                    $core->create_rest_api_I($username, $purchase_code, 'http://127.0.0.1');
                }
                if ($core->write_index() == false) {
                    echo "<div class='alert alert-error'><i class='icon-remove'></i> Failed to write index details!</div>";
                    $finished = FALSE;
                }
            } else {
                echo "<div class='alert alert-error'><i class='icon-remove'></i> Error while validating your purchase code!</div>";
            }
        }
        if ($finished) {
            ?>

            <h3 class="ins_7 ins_8"><i class='icon-ok'></i> Installation completed!</h3>
            <div class="ins_10">Please login now using the following credential:<br /><br />
                Email Address: <span class="ins_9">admin@doorsoft.co</span><br />Password: <span class="ins_9">123456</span><br /><br />
            </div>
            <div class="ins_11">Please change your credentials after login.
            </div>
            <div class="bottom">
                <div class="bottom ins_12">
                    <a href="<?php echo (isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24); ?>" class="btn btn-primary button_1">Go to Login Page</a>
                </div>
            </div>
            </div>
            </div>
            </div>

            <?php
        }
}
?>