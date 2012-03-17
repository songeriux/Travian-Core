<?php
###################################################
##-= YOU MAY NOT REMOVE OR CHANGE THIS NOTICE =- ##
## ----------------------------------------------##
## Project starters: Akakori, TTMMTT and other   ##
## Travian-Core project owner: Songer		     ##
## Project devoloper's: Songer				     ##
## Editors: Dzoki and other...				     ##
## Licence: Travian-Core					     ##
## Release date: 2012.03.17 15:40			     ##
## All right reserverd						     ##
## ENJOY THE TRAVIAN!!						     ##
###################################################
		if(!file_exists('GameEngine/config.php')) {
        	header("Location: install/");
        }
        include ("Battle.php");
        include ("Data/buidata.php");
        include ("Data/cp.php");
        include ("Data/cel.php");
        include ("Data/resdata.php");
        include ("Data/unitdata.php");
        include ("Data/hero_full.php");
        include ("config.php");
        include ("Database.php");
        include ("Mailer.php");
        include ("Form.php");
        include ("Generator.php");
        include ("Automation.php");
        include ("Lang/" . LANG . ".php");
        include ("Logging.php");
        include ("Message.php");
        include ("Multisort.php");
        include ("Ranking.php");
        include ("Alliance.php");
        include ("Profile.php");
        include ("Protection.php");

        class Session {

        	private $time;
        	var $logged_in = false;
        	var $referrer, $url;
        	var $username, $uid, $access, $plus, $tribe, $isAdmin, $alliance, $gold, $oldrank, $gpack;
        	var $bonus = 0;
        	var $bonus1 = 0;
        	var $bonus2 = 0;
        	var $bonus3 = 0;
        	var $bonus4 = 0;
        	var $checker, $mchecker;
        	public $userinfo = array();
        	private $userarray = array();
        	var $villages = array();

        	function Session() {
        		$this->time = time();
        		session_start();

        		$this->logged_in = $this->checkLogin();

        		if($this->logged_in && TRACK_USR) {
        			$database->updateActiveUser($this->username, $this->time);
        		}
        		$banned = mysql_query("SELECT reason, end FROM " . TB_PREFIX . "banlist WHERE active = 1 and time-" . time() . "<1 and uid = '" . $this->uid . "';");
        		if(mysql_num_rows($banned)) {
        			$ban = mysql_fetch_assoc($banned);
        			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><title></title><link REL="shortcut icon" HREF="favicon.ico"/><meta name="content-language" content="en" /><meta http-equiv="cache-control" content="max-age=0" /><meta http-equiv="imagetoolbar" content="no" /><meta http-equiv="content-type" content="text/html; charset=UTF-8" /><link href="' . GP_LOCATE .
        				'lang/en/compact.css?f4b7c" rel="stylesheet" type="text/css" />  <link href="gpack/travian_default/lang/en/compact.css?f4b7c" rel="stylesheet" type="text/css" /><link href="img/travian_basics.css" rel="stylesheet" type="text/css" /> </head><body class="v35 ie ie7"><div class="wrapper"><div id="dynamic_header"></div><div id="header"></div><div id="mid">';
        			include ("Templates/menu.tpl");
        			echo '<div id="content"  class="login">';
        			if($ban['end'] == 0) {
        				die("We're sorry but you were banned. <br /><br /><b>Reason:</b> " . $ban['reason'] . "<br/><b>Lifts: </B>NEVER</div></div></body><html>");
        			}
        			die("We're sorry but you were banned. <br /><br /><b>Reason:</b> " . $ban['reason'] . "<br/><b>Lifts: </B>" . date("d.m.Y G:i:s", $ban['end']) . "</div></div></body><html>");
        		}
        		if(isset($_SESSION['url'])) {
        			$this->referrer = $_SESSION['url'];
        		} else {
        			$this->referrer = "/";
        		}
        		$this->url = $_SESSION['url'] = $_SERVER['PHP_SELF'];
        		$this->SurfControl();
        	}

        	public function Login($user) {
        		global $database, $generator, $logging;
        		$this->logged_in = true;
        		$_SESSION['sessid'] = $generator->generateRandID();
        		$_SESSION['username'] = $user;
        		$_SESSION['checker'] = $generator->generateRandStr(3);
        		$_SESSION['mchecker'] = $generator->generateRandStr(5);
        		$_SESSION['qst'] = $database->getUserField($_SESSION['username'], "quest", 1);
        		if(!isset($_SESSION['wid'])) {
        			$query = mysql_query('SELECT * FROM `' . TB_PREFIX . 'vdata` WHERE `owner` = ' . $database->getUserField($_SESSION['username'], "id", 1) . ' LIMIT 1');
        			$data = mysql_fetch_assoc($query);
        			$_SESSION['wid'] = $data['wref'];
        		} else
        			if($_SESSION['wid'] == '') {
        				$query = mysql_query('SELECT * FROM `' . TB_PREFIX . 'vdata` WHERE `owner` = ' . $database->getUserField($_SESSION['username'], "id", 1) . ' LIMIT 1');
        				$data = mysql_fetch_assoc($query);
        				$_SESSION['wid'] = $data['wref'];
        			}
        		$this->PopulateVar();

        		$logging->addLoginLog($this->uid, $_SERVER['REMOTE_ADDR']);
        		$database->addActiveUser($_SESSION['username'], $this->time); 
        		$database->updateUserField($_SESSION['username'], "sessid", $_SESSION['sessid'], 0);

        		header("Location: dorf1.php");
        	}

        	public function Logout() {
        		global $database;
        		$this->logged_in = false;
        		$database->updateUserField($_SESSION['username'], "sessid", "", 0);
        		if(ini_get("session.use_cookies")) {
        			$params = session_get_cookie_params();
        			setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        		}
        		session_destroy();
        		session_start();
        	}

        	public function changeChecker() {
        		global $generator;
        		$this->checker = $_SESSION['checker'] = $generator->generateRandStr(3);
        		$this->mchecker = $_SESSION['mchecker'] = $generator->generateRandStr(5);
        	}

        	private function checkLogin() {
        		global $database;
        		if(isset($_SESSION['username']) && isset($_SESSION['sessid'])) {
        			if(!$database->checkActiveSession($_SESSION['username'], $_SESSION['sessid'])) {
        				$this->Logout();
        				return false;
        			} else {
        				//Get and Populate Data
        				$this->PopulateVar();
        				//update database
        				$database->addActiveUser($_SESSION['username'], $this->time);
        				$database->updateUserField($_SESSION['username'], "timestamp", $this->time, 0);
        				return true;
        			}
        		} else {
        			return false;
        		}
        	}

        	private function PopulateVar() {
        		global $database;
        		$this->userarray = $this->userinfo = $database->getUserArray($_SESSION['username'], 0);
        		$this->username = $this->userarray['username'];
        		$this->uid = $_SESSION['id_user'] = $this->userarray['id'];
        		$this->gpack = $this->userarray['gpack'];
        		$this->access = $this->userarray['access'];
        		$this->plus = ($this->userarray['plus'] > $this->time);
        		$this->villages = $database->getVillagesID($this->uid);
        		$this->tribe = $this->userarray['tribe'];
        		$this->isAdmin = $this->access >= MODERATOR;
        		$this->alliance = $_SESSION['alliance_user'] = $this->userarray['alliance'];
        		$this->checker = $_SESSION['checker'];
        		$this->mchecker = $_SESSION['mchecker'];
                	$this->sit1 = $this->userarray['sit1'];
                        $this->sit2 = $this->userarray['sit2'];
                        $this->cp = $this->userarray['cp'];
        		$this->gold = $this->userarray['gold'];
        		$this->oldrank = $this->userarray['oldrank'];
        		$_SESSION['ok'] = $this->userarray['ok'];
        		if($this->userarray['b1'] > $this->time) {
        			$this->bonus1 = 1;
        		}
        		if($this->userarray['b2'] > $this->time) {
        			$this->bonus2 = 1;
        		}
        		if($this->userarray['b3'] > $this->time) {
        			$this->bonus3 = 1;
        		}
        		if($this->userarray['b4'] > $this->time) {
        			$this->bonus4 = 1;
        		}
        	}

        	private function SurfControl() {
        		if(SERVER_WEB_ROOT) {
        			$page = $_SERVER['SCRIPT_NAME'];
        		} else {
        			$explode = explode("/", $_SERVER['SCRIPT_NAME']);
        			$i = count($explode) - 1;
        			$page = $explode[$i];

        		}
        		$pagearray = array("index.php", "anleitung.php", "tutorial.php", "login.php", "activate.php", "anmelden.php", "xaccount.php");
        		if(!$this->logged_in) {
        			if(!in_array($page, $pagearray) || $page == "logout.php") {
        				header("Location: login.php");
        			}
        		} else {
        			if(in_array($page, $pagearray)) {
        				header("Location: dorf1.php");
        			}

        		}
        	}
        }
        ;

        $session = new Session;
        $form = new Form;
        $message = new Message;
?>