<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright � 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: backup-restore.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

if(!defined("PARENT_LOADED"))		exit;
if(!$_SESSION["isAuthenticated"])	exit;

if(@function_exists("gzopen")) {
	$COLLAPSED	= explode(",", $_COOKIE["display"]["backup-restore"]["collapsed"]);

	if(strlen($_GET["action"]) > 0) {
		$ACTION	= checkslashes($_GET["action"]);
	} else {
		$ACTION	= checkslashes($_POST["action"]);
	}

	switch($ACTION) {
		case "backup" :
			@set_time_limit(1200);	// Tries to set the script timeout to 20 minutes.
			require_once("classes/pclzip/pclzip.lib.php");

			$tmp_filename			= "backup.".time().".lme";

			$queries				= array();
			$queries["cdata"]		= "SELECT * FROM `".TABLES_PREFIX."cdata` ORDER BY `cdata_id` ASC";
			$queries["cfields"]		= "SELECT * FROM `".TABLES_PREFIX."cfields` ORDER BY `cfields_id` ASC";
			$queries["confirmation"]	= "SELECT * FROM `".TABLES_PREFIX."confirmation` ORDER BY `confirm_id` ASC";
			$queries["groups"]		= "SELECT * FROM `".TABLES_PREFIX."groups` ORDER BY `groups_id` ASC";
			$queries["messages"]	= "SELECT * FROM `".TABLES_PREFIX."messages` ORDER BY `message_id` ASC";
			$queries["preferences"]	= "SELECT * FROM `".TABLES_PREFIX."preferences` ORDER BY `preference_id` ASC";
			$queries["queue"]		= "SELECT * FROM `".TABLES_PREFIX."queue` ORDER BY `queue_id` ASC";
			$queries["sending"]		= "SELECT * FROM `".TABLES_PREFIX."sending` ORDER BY `sending_id` ASC";
			$queries["templates"]	= "SELECT * FROM `".TABLES_PREFIX."templates` ORDER BY `template_id` ASC";
			$queries["users"]		= "SELECT * FROM `".TABLES_PREFIX."users` ORDER BY `users_id` ASC";

			if(@is_dir($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/")) {
				if(@is_writable($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/")) {
					$handle = @fopen($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$tmp_filename, "a");
					if($handle) {
						@fwrite($handle, "<backup lmversion=\"".VERSION_INFO."\">\r\n");
						foreach($queries as $table => $query) {
							$results = $db->GetAll($query);
							if(!$results) {
								$results = array();
							}
							@fwrite($handle, "<".$table." records=\"".@count($results)."\">".@base64_encode(@serialize($results))."</".$table.">\r\n");
						}
						@fwrite($handle, "</backup>\r\n");
						@fclose($handle);
					} else {
						$ERROR++;
						$ERRORSTR[] = "Unable to open your temporary backup file for writing, please ensure your private tmp directory is chmodded to 777.";

						if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
							@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to create temporary backup file in your tmp directory [".$_SESSION["config"][PREF_PRIVATE_PATH]."tmp]. Please chmod it to 777 and make sure PHP is able to write to it.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
						}
					}
				} else {
					$ERROR++;
					$ERRORSTR[] = "Your private <strong>tmp</strong> directory is currently not writable by PHP, please chmod it to 777 so you are able to create a new temporary file in this directory.";

					if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
						@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tYour private tmp folder [".$_SESSION["config"][PREF_PRIVATE_PATH]."tmp] is not writable by PHP, please chmod it to 777.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
					}
				}
			} else {
				$ERROR++;
				$ERRORSTR[] = "Your private <strong>tmp</strong> directory does not appear to exist or PHP is not able to read the directory. Please go into the <a href=\"index.php?section=preferences&type=program\">ListMessenger Program Preferences</a> and update your private folder directory path and ensure that the &quot;<strong>tmp</strong>&quot; folder exists in that directory.";

				if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
					@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tYour private tmp folder [".$_SESSION["config"][PREF_PRIVATE_PATH]."tmp] does not exist or cannot be read by PHP.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
				}
			}
			if(!$ERROR) {
				if((@file_exists($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$tmp_filename)) && (@filesize($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$tmp_filename) > 0)) {
					$bu_filename	= $tmp_filename.".zip";

					$zip	= new PclZip($_SESSION["config"][PREF_PRIVATE_PATH]."backups/".$bu_filename);
					$zip->add($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$tmp_filename, PCLZIP_OPT_REMOVE_PATH, $_SESSION["config"][PREF_PRIVATE_PATH]."tmp/");
					$zip->add($_SESSION["config"][PREF_PUBLIC_PATH]."files", PCLZIP_OPT_REMOVE_PATH, $_SESSION["config"][PREF_PUBLIC_PATH]);
					$zip->add($_SESSION["config"][PREF_PUBLIC_PATH]."images", PCLZIP_OPT_REMOVE_PATH, $_SESSION["config"][PREF_PUBLIC_PATH]);

					if((@file_exists($_SESSION["config"][PREF_PRIVATE_PATH]."backups/".$bu_filename)) && (@filesize($_SESSION["config"][PREF_PRIVATE_PATH]."backups/".$bu_filename) > 0)) {
						$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

						$SUCCESS++;
						$SUCCESSSTR[] = "You have successfully created a new backup of ListMessenger.<br /><br />You will be automatically redirected in 5 seconds, or <a href=\"index.php?section=backup-restore\">click here</a> if you prefer not to wait.";

						echo display_success($SUCCESSSTR);
					} else {
						$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

						$ERROR++;
						$ERRORSTR[] = "ListMessenger was unable to create backup archive in your public backups folder.";

						echo display_error($ERRORSTR);
					}
				}
			} else {
				$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

				echo display_error($ERRORSTR);
			}
			@unlink($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$tmp_filename);
		break;
		case "delete" :
			if((!@is_array($_POST["filename"])) && (@trim($_POST["filename"]) != "")) {
				$_POST["filename"] = array($_POST["filename"]);
			}

			if((@is_array($_POST["filename"])) && (@count($_POST["filename"]) > 0)) {
				if((!$_POST["confirmed"]) || ($_POST["confirmed"] != "1")) {
					$filecount	= 0;
					$totalsize	= 0;
					?>
					<h1>Removing Backup Files</h1>
					Please confirm that you wish to permenantly remove the following backup files from the filesystem.
					<br /><br />
					<form action="./index.php?section=backup-restore&action=delete" method="post">
					<input type="hidden" name="confirmed" value="1" />
					<table style="width: 100%; text-align: left" cellspacing="0" cellpadding="1" border="0">
					<tr>
						<td style="width: 3%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap">&nbsp;</td>
						<td style="width: 30%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap"><?= order_link("date", "Backup Date", $order, $sort, false) ?></td>
						<td style="width: 50%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap"><?= order_link("name", "Filename", $order, $sort, false) ?></td>
						<td style="width: 17%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap"><?= order_link("size", "Filesize", $order, $sort, false) ?></td>
					</tr>
					<?php
					foreach($_POST["filename"] as $filename) {
						if(@file_exists($_SESSION["config"][PREF_PRIVATE_PATH]."backups/".$filename)) {
							$filecount++;
							$pieces		= explode(".", $filename);
							$backup_date	= $pieces[1];
							$filesize		= filesize($_SESSION["config"][PREF_PRIVATE_PATH]."backups/".$filename);
							$totalsize	+= $filesize;

							if($pieces[2] == "lme") {
								echo "<tr>\n";
								echo "	<td><input type=\"checkbox\" name=\"filename[]\" value=\"".$filename."\" checked=\"checked\"/></td>\n";
								echo "	<td style=\"padding-left: 5px\">".display_date($_SESSION["config"][PREF_DATEFORMAT], $backup_date)."</td>\n";
								echo "	<td style=\"padding-left: 5px\">".$filename."</td>\n";
								echo "	<td style=\"padding-left: 5px\">".readable_size($filesize)."</td>\n";
								echo "</tr>\n";
							}

						}
					}
					echo "<tr>\n";
					echo "	<td colspan=\"3\">&nbsp;</td>\n";
					echo "</tr>\n";
					echo "<tr>\n";
					echo "	<td colspan=\"3\">\n";
					if($filecount > 0) {
						echo "I confirm that I wish to delete the following <strong>".$filecount."</strong> backup file".(($filecount != 1) ? "s" : "")." <em>(".readable_size($totalsize).")</em> from the private backups directory.<br /><br />";
						echo "<input type=\"button\" class=\"button\" value=\"Cancel\" onclick=\"window.location='index.php?section=backup-restore'\" />&nbsp;";
						echo "<input type=\"submit\" class=\"button\" value=\"Confirmed\" />\n";
					}
					echo "	</td>\n";
					echo "</tr>\n";
					echo "</table>\n";
					echo "</form>\n";
				} else {
					if((@is_array($_POST["filename"])) && (@count($_POST["filename"]) > 0)) {
						foreach($_POST["filename"] as $filename) {
							if(!@unlink($_SESSION["config"][PREF_PRIVATE_PATH]."backups/".$filename)) {
								$ERROR++;
								$ERRORSTR[] = "ListMessenger is unable to delete <strong>".$filename."</strong> from your private backups directory. This could be a file owner ship or permissions error, so please delete it using an FTP client.";
							}
						}
						if($ERROR) {
							$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

							echo display_error($ERRORSTR);
						} else {
							$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

							$SUCCESS++;
							$SUCCESSSTR[] = "You have successfully deleted <strong>".@count($_POST["filename"])."</strong> backup file".((@count($_POST["remove"]) != 1) ? "s" : "")." from your private backups directory.<br /><br />You will be automatically redirected in 5 seconds, or <a href=\"index.php?section=backup-restore\">click here</a> if you prefer not to wait.";

							echo display_success($SUCCESSSTR);
						}
					} else {
						$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

						$ERROR++;
						$ERRORSTR[] = "You did not select any backup files to delete on the confirmation screen.<br /><br />You will be automatically redirected in 5 seconds, or <a href=\"index.php?section=backup-restore\">click here</a> if you prefer not to wait.";

						echo display_error($ERRORSTR);
					}
				}
			} else {
				$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

				$ERROR++;
				$ERRORSTR[] = "You did not select any backup files to remove from the file system. If you would like to delete a ListMessenger backup file, select the radio button beside the filename then click the Delete Selected button.";

				echo display_error($ERRORSTR);
			}
		break;
		case "restore" :
			@set_time_limit(1200);	// Tries to set the script timeout to 20 minutes.
			require_once("classes/pclzip/pclzip.lib.php");

			if((isset($_GET["step"])) && ((int) $_GET["step"])) {
				$STEP = (int) $_GET["step"];
			} else {
				$STEP = 1;
			}

			// ERROR CHECKING
			switch($STEP) {
				case "2" :
				break;
				default :
				break;
			}

			// STEP DISPLAY
			switch($STEP) {
				case "2" :
					if(($_POST["filename"]) && (trim($_POST["filename"]) != "")) {
						if(@file_exists($_SESSION["config"][PREF_PRIVATE_PATH]."/backups/".trim($_POST["filename"]))) {
							$filename		= trim($_POST["filename"]);
							$pieces		= explode(".", $filename);

							$backupdate	= $pieces[1];

							if((@is_array($_POST["restore"]["tables"])) && (@count($_POST["restore"]["tables"]) > 0)) {
								$zip			= new PclZip($_SESSION["config"][PREF_PRIVATE_PATH]."/backups/".$filename);
								$rawdata		= $zip->extract(PCLZIP_OPT_EXTRACT_AS_STRING, PCLZIP_OPT_BY_NAME, "backup.".$backupdate.".lme");

								if(trim($rawdata[0]["content"]) != "") {
									$backup		= array();
									$xml_parser	= xml_parser_create();
									xml_set_element_handler($xml_parser, "backup_stag", "backup_etag");
									xml_set_character_data_handler($xml_parser, "backup_data");
									$data		= xml_parse($xml_parser, $rawdata[0]["content"]);
									if((!$data) || (trim($data) == "")) {
										$ERROR++;
										$ERRORSTR[] = sprintf("Your backup file contains the following XML Error:<br /><br />%s at line %d", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser));
									}
									xml_parser_free($xml_parser);

									if($backup[0]["attributes"]["LMVERSION"] != VERSION_INFO) {
										$ERROR++;
										$ERRORSTR[] = "The backup file that you are attempting to restore was generated by ListMessenger Pro <strong>".$backup[0]["attributes"]["LMVERSION"]."</strong> and you are currently using ListMessenger ".VERSION_INFO.". In order to restore this specific backup file you will need to install ListMessenger Pro <strong>".$backup[0]["attributes"]["LMVERSION"]."</strong> and then upgrade your ListMessenger installation to ".VERSION_INFO.".<br /><br />If you require further assistance, please visit the ListMessenger Forum at <a href=\"http://forum.listmessenger.com\" target=\"_blank\">http://forum.listmessenger.com</a>.";
									}

								} else {
									$ERROR++;
									$ERRORSTR[] = "It appears as though your backup file is empty or ListMessenger was unable to read it's contents. Please make sure that PHP has read access to the backup file that you are trying to restore and try the restore again.";
								}
								if(!$ERROR) {
									foreach($backup[0]["tables"] as $table) {
										$results	= @unserialize(@base64_decode($table["result"]));
										if(@is_array($results)) {
											if(@in_array($table["name"], $_POST["restore"]["tables"])) {
												$query = "DELETE FROM `".TABLES_PREFIX.$table["name"]."`";
												$db->Execute($query);

												$query = "OPTIMIZE TABLE `".TABLES_PREFIX.$table["name"]."`";
												$db->Execute($query);

												foreach($results as $result) {
													$keys	= array();
													$values	= array();
													$i		= 0;

													foreach($result as $key => $value) {
														$keys[$i]		= $key;
														$values[$i]	= addslashes($value);
														$i++;
													}

													$query = "INSERT INTO `".TABLES_PREFIX.$table["name"]."` (`".implode("`, `", $keys)."`) VALUES ('".implode("', '", $values)."');";
													if(!$db->Execute($query)) {
														$ERROR++;
														$ERRORSTR[] = "Database query failed: [".$query."]. Database server said: ".$db->ErrorMsg();
													} else {
														$SUCCESS++;
													}
												}
											} else {
												// Skipping this table because it wasn't selected.
											}
										} else {
											// This result set is not an array; therefore, skip it.
										}
									}

									// Update the paths and URL's if it's required.
									if($_POST["skip_path"] == "1") {
										foreach($PREFERENCES_SKIP as $preference_id) {
											$query	= "UPDATE `".TABLPES_PREFIX."preferences` SET `preference_value`='".$_SESSION["config"][$preference_id]."' WHERE `preference_id`='".$preference_id."';";
											if(!$db->Execute($query)) {
												if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
													@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to set preference ID ".$preference_id." back to ".$_SESSION["config"][$preference_id].".\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
												}
											}
										}
									}
									if(!reload_configuration()) {
										if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
											@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to reload the settings from the database. The load_settings() function returned false.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
										}
									}
									$SUCCESSSTR[] = "You have successfully restored <strong>".$SUCCESS." record".(($SUCCESS != 1) ? "s" : "")."</strong> into <strong>".@count($_POST["restore"]["tables"])." table".((@count($_POST["restore"]["tables"]) != 1) ? "s" : "")."</strong> in your database.";
								}
							}

							if(@file_exists($_SESSION["config"][PREF_PRIVATE_PATH]."/backups/".$filename)) {
								if((@is_array($_POST["restore"]["directories"])) && (@count($_POST["restore"]["directories"]) > 0)) {
									foreach($_POST["restore"]["directories"] as $directory) {
										if((@is_dir($_SESSION["config"][PREF_PUBLIC_PATH].$directory)) && (@is_writable($_SESSION["config"][PREF_PUBLIC_PATH].$directory))) {
											$zip			= new PclZip($_SESSION["config"][PREF_PRIVATE_PATH]."/backups/".$filename);
											$rawdata		= $zip->extract(PCLZIP_OPT_PATH, $_SESSION["config"][PREF_PUBLIC_PATH], PCLZIP_OPT_BY_PREG, "/".$directory."\//i");

											$SUCCESS++;
											$SUCCESSSTR[]	= "You have successfully restored <strong>".@count($rawdata)." file".((@count($rawdata) != 1) ? "s" : "")."</strong> into your <strong>".$directory."</strong> directory.";
										} else {
											$ERROR++;
											$ERRORSTR[]	= "Unable to restore backed up files in the <strong>".$directory."</strong> directory to <em>".$_SESSION["config"][PREF_PUBLIC_PATH].$directory."</em>. This directory either does not exist or is not writable by PHP.";
										}
									}
								}
							} else {
								$ERROR++;
								$ERRORSTR[] = "The ListMessenger backup filename that you provided [".$filename."] no longer exists in your private backups directory. This could be cause because your database restore changed the path to the ListMessenger Public directory or the file was removed from the server.";
							}

							$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 10000)";
							if($ERROR) {
								echo display_error($ERRORSTR);
								echo "<br /><br />";
							}
							if($SUCCESS) {
								echo display_success($SUCCESSSTR);
							}
							echo "<br />";
							echo "You will now be redirected back to the backup and restore main page in 10 seconds, or please feel free to <a href=\"index.php?section=backup-restore\">click here</a> if you prefer not to wait.";
						} else {
							$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

							$ERROR++;
							$ERRORSTR[] = "The ListMessenger backup filename that you provided [".checkslashes($_POST["filename"], 1)."] does not exist in your private backups directory.";

							echo display_error($ERRORSTR);
						}
					} else {
						$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

						$ERROR++;
						$ERRORSTR[] = "You did not select a backup file to restore from the file system. If you would like to restore a ListMessenger backup file, select the radio button beside the filename then click the Restore Selected button.";

						echo display_error($ERRORSTR);
					}
				break;
				default :
					if(($_POST["filename"]) && (trim($_POST["filename"]) != "")) {
						if(@file_exists($_SESSION["config"][PREF_PRIVATE_PATH]."/backups/".trim($_POST["filename"]))) {
							$filename		= trim($_POST["filename"]);
							$pieces		= explode(".", $filename);

							$backupdate	= $pieces[1];

							$zip			= new PclZip($_SESSION["config"][PREF_PRIVATE_PATH]."/backups/".$filename);
							$rawdata		= $zip->extract(PCLZIP_OPT_EXTRACT_AS_STRING, PCLZIP_OPT_BY_NAME, "backup.".$backupdate.".lme");

							if(trim($rawdata[0]["content"]) != "") {
								$backup		= array();
								$xml_parser	= xml_parser_create();
								xml_set_element_handler($xml_parser, "backup_stag", "backup_etag");
								xml_set_character_data_handler($xml_parser, "backup_data");
								$data		= xml_parse($xml_parser, $rawdata[0]["content"]);
								if((!$data) || (trim($data) == "")) {
									$ERROR++;
									$ERRORSTR[] = sprintf("Your backup file contains the following XML Error:<br /><br />%s at line %d", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser));
								}
								xml_parser_free($xml_parser);

								if($backup[0]["attributes"]["LMVERSION"] != VERSION_INFO) {
									$ERROR++;
									$ERRORSTR[] = "The backup file that you are attempting to restore was generated by ListMessenger Pro <strong>".$backup[0]["attributes"]["LMVERSION"]."</strong> and you are currently using ListMessenger ".VERSION_INFO.". In order to restore this specific backup file you will need to install ListMessenger Pro <strong>".$backup[0]["attributes"]["LMVERSION"]."</strong> and then upgrade your ListMessenger installation to ".VERSION_INFO.".<br /><br />If you require further assistance, please visit the ListMessenger Forum at <a href=\"http://forum.listmessenger.com\" target=\"_blank\">http://forum.listmessenger.com</a>.";
								}

							} else {
								$ERROR++;
								$ERRORSTR[] = "It appears as though your backup file is empty or ListMessenger was unable to read it's contents. Please make sure that PHP has read access to the backup file that you are trying to restore and try the restore again.";
							}

							if(!$ERROR) {
								?>
								<h1>Restoring <?php echo html_encode(trim($_POST["filename"])); ?></h1>
								The backup file that you are attempting to restore was made <strong><?php echo display_date($_SESSION["config"][PREF_DATEFORMAT], $rawdata[0]["mtime"]); ?></strong>.
								<h2>Restore Data</h2>
								Select which database tables you would like to restore from this backup:
								<form action="index.php?section=backup-restore&action=restore&step=2" method="post" id="restoreData">
								<input type="hidden" name="filename" value="<?= checkslashes(trim($_POST["filename"])) ?>" />
								<table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
								<?php
								for($i = 0; $i < @count($backup[0]["tables"]); $i++) {
									echo "<tr>\n";
									echo "	<td style=\"width: 3%\">".($i + 1).".</td>";
									echo "	<td style=\"width: 3%\"><input type=\"checkbox\" name=\"restore[tables][]\" value=\"".$backup[0]["tables"][$i]["name"]."\" checked=\"checked\" /></td>";
									echo "	<td style=\"width: 24%; padding-left: 10px\"><strong>".$backup[0]["tables"][$i]["name"]."</strong></td>\n";
									echo "	<td style=\"width: 70%\">";
									if($backup[0]["tables"][$i]["attributes"]["RECORDS"] == "0") {
										echo "There are no records in this table to restore.";
									} else {
										echo "There ".(($backup[0]["tables"][$i]["attributes"]["RECORDS"] != "1") ? " are ".$backup[0]["tables"][$i]["attributes"]["RECORDS"]." records" : " is 1 record")." in this table to restore.";
									}
									echo "	</td>\n";
									echo "</tr>\n";
								}
								?>
								<tr>
									<td colspan="4">
										<br /><br />
										Select the directories that you would like to restore from this backup:
									</td>
								</tr>
								<tr>
									<td>1.</td>
									<td><input type="checkbox" name="restore[directories][]" value="files" checked="checked" /></td>
									<td style="padding-left: 10px" colspan="2">Restore the <strong>public files</strong> directory.</td>
								</tr>
								<tr>
									<td>2.</td>
									<td><input type="checkbox" name="restore[directories][]" value="images" checked="checked" /></td>
									<td style="padding-left: 10px" colspan="2">Restore the <strong>public images</strong> directory.</td>
								</tr>
								</table>
								<h2>Restore Options</h2>
								<table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
								<tr>
									<td style="width: 3%"><input type="checkbox" name="skip_paths" value="1" checked="checked" /></td>
									<td style="width: 97%">Do not overwrite this installations program, public and private directory paths and URL's.</td>
								</tr>
								<tr>
									<td coslpan="2">&nbsp;</td>
								</tr>
								<tr>
									<td style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px" colspan="2">
										<input type="button" class="button" value="Cancel" onclick="window.location='index.php?section=backup-restore'" />&nbsp;
										<input type="button" class="button" value="Proceed" onclick="confirmRestore()" />
									</td>
								</tr>
								</table>
								</form>
								<?php
							} else {
								$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

								echo display_error($ERRORSTR);
							}
						} else {
							$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

							$ERROR++;
							$ERRORSTR[] = "The ListMessenger backup filename that you provided [".checkslashes($_POST["filename"], 1)."] does not exist in your private backups directory.";

							echo display_error($ERRORSTR);
						}
					} else {
						$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

						$ERROR++;
						$ERRORSTR[] = "You did not select a backup file to restore from the file system. If you would like to restore a ListMessenger backup file, select the radio button beside the filename then click the Restore Selected button.";

						echo display_error($ERRORSTR);
					}
				break;
			}
		break;
		case "upload" :
			if((!$_FILES["backup_file"]) || ($_FILES["backup_file"] == "")) {
				$ERROR++;
				$ERRORSTR[] = "You did not select a file on your computer to upload. Please select a local file.";
			} else {
				switch($_FILES["backup_file"]["error"]) {
					case "0" :
						// File was uploaded successfully.
					break;
					case "1" :
						// File exceeds upload_max_file size in php.ini.
						$ERROR++;
						$ERRORSTR[] = "The backup file that you are trying to upload is a larger filesize than your server currently allows. Please either modify the &quot;upload_max_file&quot; in your php.ini file or manually FTP your backup file to your private backups directory.";
					break;
					case "2" :
						// File exceeds MAX_FILE_SIZE directive in form.
						$ERROR++;
						$ERRORSTR[] = "The backup file that you are trying to upload is a larger filesize than your server currently allows.";
					break;
					case "3" :
						// File was only partially uploaded.
						$ERROR++;
						$ERRORSTR[] = "The backup file that was uploaded did not complete the upload process or was interupted. Please try again.";
					break;
					case "4" :
						// There was no file uploaded.
						$ERROR++;
						$ERRORSTR[] = "You did not select a backup file on your computer to upload. Please select the local backup file and try again.";
					break;
					default :
						// This should never happen.
					break;
				}

				$fpieces	= explode(".", $_FILES["backup_file"]["name"]);

				if(($fpieces[0] != "backup") || ($fpieces[2] != "lme") || ($fpieces[3] != "zip")) {
					$ERROR++;
					$ERRORSTR[] = "The backup file that you uploaded does not appear to be a valid ListMessenger backup filename [".$_FILES["backup_file"]["name"]."]. Please ensure your backup file is correct and that you did not change the name of the file.";
				}

				if(!@is_dir($_SESSION["config"][PREF_PRIVATE_PATH]."backups/")) {
					$ERROR++;
					$ERRORSTR[] = "Your private <strong>backups</strong> directory does not appear to exist or PHP is not able to read the directory. Please go into the <a href=\"index.php?section=preferences&type=program\">ListMessenger Program Preferences</a> and update your private folder directory path and ensure that the &quot;<strong>backups</strong>&quot; folder exists in that directory.";
				} else {
					if(!@is_writable($_SESSION["config"][PREF_PRIVATE_PATH]."backups/")) {
						$ERROR++;
						$ERRORSTR[] = "Your private <strong>backups</strong> directory is currently not writable by PHP, please chmod it to 777 so you are able to upload and create new backup files in this directory.";
					}
				}

				if(!$ERROR) {
					if(!@move_uploaded_file($_FILES["backup_file"]["tmp_name"], $_SESSION["config"][PREF_PRIVATE_PATH]."backups/".$_FILES["backup_file"]["name"])) {
						$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

						$ERROR++;
						$ERRORSTR[] = "ListMessenger was unable to move the backup file from your servers temporary storage directory to your private backups directory at &quot;".$_SESSION["config"][PREF_PRIVATE_PATH]."backups/&quot;.";

						echo display_error($ERRORSTR);
					} else {
						$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

						$SUCCESS++;
						$SUCCESSSTR[] = "You have successfully uploaded ".$_FILES["backup_file"]["name"]." to your private backups directory and it should appear in your backup files list immediately.<br /><br />You will be automatically redirected in 5 seconds, or <a href=\"index.php?section=backup-restore\">click here</a> if you prefer not to wait.";

						echo display_success($SUCCESSSTR);
					}
				} else {
					$ONLOAD[] = "setTimeout('window.location=\'index.php?section=backup-restore\'', 5000)";

					echo display_error($ERRORSTR);
				}
			}
		break;
		default :
			// Setup "Sort By Field" Information
			if(strlen($_GET["sort"]) > 0) {
				$_SESSION["display"]["backup-restore"]["sort"] = checkslashes($_GET["sort"]);
				setcookie("display[backup-restore][sort]", checkslashes($_GET["sort"]), PREF_COOKIE_TIMEOUT);
			} elseif((!isset($_SESSION["display"]["backup-restore"]["sort"])) && (isset($_COOKIE["display"]["backup-restore"]["sort"]))) {
				$_SESSION["display"]["backup-restore"]["sort"] = $_COOKIE["display"]["backup-restore"]["sort"];
			} else {
				if(!isset($_SESSION["display"]["backup-restore"]["sort"])) {
					$_SESSION["display"]["backup-restore"]["sort"] = "date";
					setcookie("display[backup-restore][sort]", "date", PREF_COOKIE_TIMEOUT);
				}
			}

			// Setup "Sort Order" Information
			if($_GET["order"]) {
				switch($_GET["order"]) {
					case "asc" :
						$_SESSION["display"]["backup-restore"]["order"] = "ASC";
					break;
					case "desc" :
						$_SESSION["display"]["backup-restore"]["order"] = "DESC";
					break;
					default :
						$_SESSION["display"]["backup-restore"]["order"] = "DESC";
					break;
				}
				setcookie("display[backup-restore][order]", $_SESSION["display"]["backup-restore"]["order"], PREF_COOKIE_TIMEOUT);
			} elseif((!isset($_SESSION["display"]["backup-restore"]["order"])) && (isset($_COOKIE["display"]["backup-restore"]["order"]))) {
				$_SESSION["display"]["backup-restore"]["order"] = $_COOKIE["display"]["backup-restore"]["order"];
			} else {
				if (!isset($_SESSION["display"]["backup-restore"]["order"])) {
					$_SESSION["display"]["backup-restore"]["order"] = "DESC";
					setcookie("display[backup-restore][order]", "DESC", PREF_COOKIE_TIMEOUT);
				}
			}

			$sort	= $_SESSION["display"]["backup-restore"]["sort"];
			$order	= $_SESSION["display"]["backup-restore"]["order"];
			?>
			<script language="JavaScript" type="text/javascript">
			function setAction(type) {
				switch (type) {
					case 'delete' :
						document.getElementById('faction').value = 'delete';
						document.getElementById('backup_restore').submit();
						return;
					break;
					case 'restore' :
						document.getElementById('faction').value = 'restore';
						document.getElementById('backup_restore').submit();
						return;
					break;
					default :
						alert('Unrecognized action type.');
						return;
					break;
				}
			}
			</script>
			<div style="display: <?= (in_array("backup", $COLLAPSED) ? "none" : "inline") ?>" id="opened_backup">
				<table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
				<tr>
					<td class="cursor" style="height: 15px; background-image: url('./images/table-head-on.gif'); background-color: #EEEEEE; border-bottom: 1px #CCCCCC solid" onclick="toggle_section('backup', 1, '<?= javascript_cookie(); ?>', 'backup-restore')">
						<table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td style="width: 95%; text-align: left"><span class="search-on">Upload Backup File</span></td>
							<td style="width: 5%; text-align: right"><a href="javascript: toggle_section('backup', 1, '<?= javascript_cookie(); ?>', 'backup-restore')"><img src="./images/section-hide.gif" width="9" height="9" alt="Hide" title="Hide Upload Backup File" border="0" /></a></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<form action="index.php?section=backup-restore&action=upload" method="post" name="backupForm" enctype="multipart/form-data">
						<table style="width: 100%; height: 25px" cellspacing="0" cellpadding="2" border="0">
						<tr>
							<td style="text-align: right">Select local backup file to upload:</td>
							<td style="text-align: right">
								<input type="file" name="backup_file" class="file" size="25" />
							</td>
							<td style="text-align: right">
								<input type="submit" value="Upload Backup" class="button" />
							</td>
						</tr>
						</table>
						</form>
					</td>
				</tr>
				</table>
			</div>
			<div style="display: <?= (!in_array("backup", $COLLAPSED) ? "none" : "inline") ?>" id="closed_backup">
				<table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
				<tr>
					<td class="cursor" style="height: 15px; background-image: url('./images/table-head-off.gif'); background-color: #EEEEEE" onclick="toggle_section('backup', 0, '<?= javascript_cookie(); ?>', 'backup-restore')">
						<table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td style="width: 95%; text-align: left"><span class="search-off">Upload Backup File</span></td>
							<td style="width: 5%; text-align: right"><a href="javascript: toggle_section('backup', 0, '<?= javascript_cookie(); ?>', 'backup-restore')"><img src="./images/section-show.gif" width="9" height="9" alt="Show" title="Show Upload Backup File" border="0" /></a></td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>

			<h1>Backup &amp; Restore</h1>
			<?php
			if(@is_dir($_SESSION["config"][PREF_PRIVATE_PATH]."backups/")) {
				if(@is_writable($_SESSION["config"][PREF_PRIVATE_PATH]."backups/")) {
					if(@is_dir($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/")) {
						if(@is_writable($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/")) {
							?>
							<form>
							<table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
							<tr>
								<td style="text-align: right">
									<input type="button" value="Create Backup" class="button" onclick="window.location='index.php?section=backup-restore&action=backup'" />
								</td>
							</tr>
							</table>
							</form>
							<?php
							if($handle = @opendir($_SESSION["config"][PREF_PRIVATE_PATH]."backups/")) {
								$filenames	= array();
								$filesizes	= array();
								$totalsize	= 0;

								while(($filename = @readdir($handle)) !== false) {
									if(($filename != ".") && ($filename != "..")) {
										$pieces		= explode(".", $filename);
										if($pieces[2] == "lme") {
											$filesize		= @filesize($_SESSION["config"][PREF_PRIVATE_PATH]."backups/".$filename);

											$i			= @count($filenames);
											$filenames[$i] = $filename;
											$filesizes[$i] = (($filesize > 0) ? $filesize : 0);

											$totalsize += $filesize;
										}
									}
								}
								@closedir($handle);

								$filecount = @count($filenames);

								if($filecount > 0) {
									?>
									<form action="./index.php?section=backup-restore" method="post" id="backup_restore">
									<input type="hidden" name="action" id="faction" value="" />
									<table style="width: 100%; text-align: left" cellspacing="0" cellpadding="1" border="0">
									<tr>
										<td style="width: 3%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap">&nbsp;</td>
										<td style="width: 30%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?= (($sort == "date") ? "on" : "off") ?>.gif'); white-space: nowrap"><?= order_link("date", "Backup Date", $order, $sort) ?></td>
										<td style="width: 46%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?= (($sort == "name") ? "on" : "off") ?>.gif'); white-space: nowrap"><?= order_link("name", "Filename", $order, $sort) ?></td>
										<td style="width: 17%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-<?= (($sort == "size") ? "on" : "off") ?>.gif'); white-space: nowrap"><?= order_link("size", "Filesize", $order, $sort) ?></td>
									</tr>
									<?php
									if(($sort == "name") || ($sort == "date")) {
										if($order == "ASC") {
											@asort($filenames);
										} else {
											@arsort($filenames);
										}
										foreach($filenames as $key => $filename) {
											$pieces		= explode(".", $filename);
											$backup_date	= $pieces[1];
											if($pieces[2] == "lme") {
												echo "<tr>\n";
												echo "	<td style=\"padding-top: 3px; padding-bottom: 3px\"><input type=\"radio\" name=\"filename\" value=\"".$filename."\" /></td>\n";
												echo "	<td style=\"padding-left: 5px\">".display_date($_SESSION["config"][PREF_DATEFORMAT], $backup_date)."</td>\n";
												echo "	<td style=\"padding-left: 5px\"><a href=\"./backup.php?sid=".session_id()."&file=".$filename."\">".$filename."</a></td>\n";
												echo "	<td style=\"padding-left: 5px\">".readable_size($filesizes[$key])."</td>\n";
												echo "</tr>\n";
											}
										}
									} else {
										if($order == "ASC") {
											@asort($filesizes);
										} else {
											@arsort($filesizes);
										}
										foreach($filesizes as $key => $filesize) {
											$pieces		= explode(".", $filenames[$key]);
											$backup_date	= $pieces[1];
											if($pieces[2] == "lme") {
												echo "<tr>\n";
												echo "	<td><input type=\"radio\" name=\"filename\" value=\"".$filenames[$key]."\" /></td>\n";
												echo "	<td style=\"padding-left: 5px\">".display_date($_SESSION["config"][PREF_DATEFORMAT], $backup_date)."</td>\n";
												echo "	<td style=\"padding-left: 5px\"><a href=\"./backup.php?sid=".session_id()."&file=".$filenames[$key]."\">".$filenames[$key]."</a></td>\n";
												echo "	<td style=\"padding-left: 5px\">".readable_size($filesize)."</td>\n";
												echo "</tr>\n";
											}
										}
									}
									echo "<tr>\n";
									echo "	<td colspan=\"4\" style=\"border-top: 1px #333333 dotted; padding-top: 5px\"><input type=\"radio\" name=\"filename\" value=\"\" checked=\"checked\" />&nbsp;<input type=\"button\" value=\"Delete Selected\" class=\"button\" onclick=\"setAction('delete')\" />&nbsp;<strong>- OR -</strong>&nbsp;<input type=\"button\" value=\"Restore Selected\" class=\"button\" onclick=\"setAction('restore')\" /></td>\n";
									echo "</tr>\n";
									echo "<tr>\n";
									echo "	<td colspan=\"4\">\n";
									echo "		<h2>Private Backup Directory Statistics:</h2>\n";
									echo "		There ".(($filecount != 1) ? "are" : "is")." currently <strong>".$filecount."</strong> backup".(($filecount != 1) ? "s" : "")." in your private backups directory.<br />";
									echo "		Your private backups directory constains a total of <strong>".readable_size($totalsize)."</strong> worth of backups.";
									echo "	</td>\n";
									echo "</tr>\n";
									echo "</table>\n";
									echo "</form>\n";
								} else {
									$NOTICE++;
									$NOTICESTR[] = "You have not yet made any backups of ListMessenger Pro, to create a new backup simply click the &quot;Create Backup&quot; button and a new snap shot will be created for you.<br /><br />Alternatively, if you have a backup file that you wish to import, you can use the &quot;Upload Backup File&quot; form above to select the backup file on your computer and then click &quot;Upload Backup&quot; to upload it into your backups directory.";
									echo display_notice($NOTICESTR);
								}
							}
						} else {
							$ERROR++;
							$ERRORSTR[] = "Your private <strong>tmp</strong> directory is currently not writable by PHP, please chmod it to 777 so you are able to create a new temporary file in this directory.";
							echo display_error($ERRORSTR);
						}
					} else {
						$ERROR++;
						$ERRORSTR[] = "Your private <strong>tmp</strong> directory does not appear to exist or PHP is not able to read the directory. Please go into the <a href=\"index.php?section=preferences&type=program\">ListMessenger Program Preferences</a> and update your private folder directory path and ensure that the &quot;<strong>tmp</strong>&quot; folder exists in that directory.";
						echo display_error($ERRORSTR);
					}
				} else {
					$ERROR++;
					$ERRORSTR[] = "Your private <strong>backups</strong> directory is currently not writable by PHP, please chmod it to 777 so you are able to upload and create new backup files in this directory.";
					echo display_error($ERRORSTR);
				}
			} else {
				$ERROR++;
				$ERRORSTR[] = "Your private <strong>backups</strong> directory does not appear to exist or PHP is not able to read the directory. Please go into the <a href=\"index.php?section=preferences&type=program\">ListMessenger Program Preferences</a> and update your private folder directory path and ensure that the &quot;<strong>backups</strong>&quot; folder exists in that directory.";
				echo display_error($ERRORSTR);
			}
		break;
	}
} else {
	$ERROR++;
	$ERRORSTR[] = "Your PHP installation does not appear to be compiled with zLib support [<a href=\"http://www.php.net/zlib\">php.net</a>]. The backup and restore utilities in ListMessenger require that zLib be installed in order to properly backup and restore your ListMessenger data.";
	echo display_error($ERRORSTR);
}


?>
