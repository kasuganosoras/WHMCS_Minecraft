<?php
/**
 * WHMCS Hook Minecraft Service
 *
 * by Akkariin
 */

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function minecraft_MetaData() {
    return array(
        'DisplayName' => 'Minecraft',
        'APIVersion' => '1.2', 
        'RequiresServer' => false, 
    );
}

function minecraft_ConfigOptions() {
	
    return array(
        '<b>服务器地址</b> <span style="color:#FF0000">*</span>' => array(
            'Type' => 'text',
            'Size' => '500',
            'Default' => ''
        ),
		'<b>Rcon 端口</b> <span style="color:#FF0000">*</span>' => array(
            'Type' => 'text',
            'Size' => '500',
            'Default' => ''
        ),
		'<b>Rcon 密码</b> <span style="color:#FF0000">*</span>' => array(
            'Type' => 'text',
            'Size' => '500',
            'Default' => ''
        ),
		'<b>连接超时时间</b>(ms) <span style="color:#FF0000">*</span>' => array(
            'Type' => 'text',
            'Size' => '500',
            'Default' => ''
        ),
		'<b>首次开通执行命令</b> <span style="color:#FF0000">*</span><br>每行一条命令，不要带 <code>/</code><br><a href="https://github.com/kasuganosoras/WHMCS_Minecraft/wiki/Vars" target="_blank">[可用变量列表]</a>' => array(
            'Type' => 'textarea',
            'Size' => '500',
            'Default' => ''
        ),
        '<b>产品续费执行命令</b><br>每行一条，留空则不执行<br><a href="https://github.com/kasuganosoras/WHMCS_Minecraft/wiki/Vars" target="_blank">[可用变量列表]</a>' => array(
            'Type' => 'textarea',
            'Size' => '500',
            'Default' => ''
        ),
		'<b>产品暂停执行命令</b><br>每行一条，留空则不执行<br><a href="https://github.com/kasuganosoras/WHMCS_Minecraft/wiki/Vars" target="_blank">[可用变量列表]</a>' => array(
            'Type' => 'textarea',
            'Size' => '500',
            'Default' => ''
        ),
		'<b>解除暂停执行命令</b><br>每行一条，留空则不执行<br><a href="https://github.com/kasuganosoras/WHMCS_Minecraft/wiki/Vars" target="_blank">[可用变量列表]</a>' => array(
            'Type' => 'textarea',
            'Size' => '500',
            'Default' => ''
        ),
		'<b>产品删除执行命令</b><br>每行一条，留空则不执行<br><a href="https://github.com/kasuganosoras/WHMCS_Minecraft/wiki/Vars" target="_blank">[可用变量列表]</a>' => array(
            'Type' => 'textarea',
            'Size' => '500',
            'Default' => ''
        ),
    );
}

function minecraft_getSplitCmds(string $cmds, array $params) {
	$exp = explode("\n", $cmds);
	$cmd = [];
	foreach($exp as $line) {
		$line  = str_replace("{playerName}", $params['customfields']['游戏名字'], $line);
		$line  = str_replace("{serviceId}", $params['serviceid'], $line);
		$cmd[] = trim($line, "\r\t\n ");
	}
	return $cmd;
}

function minecraft_getServerInfo(array $params) {
	$serverInfo = [
		'hostname' => $params['configoption1'],
		'port'     => Intval($params['configoption2']),
		'password' => $params['configoption3'],
		'timeout'  => Intval($params['configoption4']),
	];
	$serverInfo['create']    = (!empty($params['configoption5'])) ? minecraft_getSplitCmds($params['configoption5'], $params) : false;
	$serverInfo['renew']     = (!empty($params['configoption6'])) ? minecraft_getSplitCmds($params['configoption6'], $params) : false;
	$serverInfo['suspend']   = (!empty($params['configoption7'])) ? minecraft_getSplitCmds($params['configoption7'], $params) : false;
	$serverInfo['unsuspend'] = (!empty($params['configoption8'])) ? minecraft_getSplitCmds($params['configoption8'], $params) : false;
	$serverInfo['terminate'] = (!empty($params['configoption9'])) ? minecraft_getSplitCmds($params['configoption9'], $params) : false;
	return $serverInfo;
}

function minecraft_CreateAccount(array $params) {
	include("rcon.php");
	$sinfo = minecraft_getServerInfo($params);
	if($sinfo['create']) {
		$rcon = new Rcon($sinfo['hostname'], $sinfo['port'], $sinfo['password'], $sinfo['timeout']);
		if($rcon->connect()) {
			foreach($sinfo['create'] as $cmd) {
				$back = $rcon->send_command($cmd);
				if(!empty($back)) {
					$back = mb_substr($back, 0, -1);
				}
				logModuleCall("WHMCS-Minecraft", "Rcon Result", $cmd, $back);
			}
			return 'success';
		} else {
			logModuleCall("WHMCS-Minecraft", "Rcon Error", "Failed connect to rcon server", "");
			return "无法连接到 Rcon 服务器";
		}
	}
    return 'success';
}

function minecraft_Renew(array $params) {
	include("rcon.php");
	$sinfo = minecraft_getServerInfo($params);
	if($sinfo['renew']) {
		$rcon = new Rcon($sinfo['hostname'], $sinfo['port'], $sinfo['password'], $sinfo['timeout']);
		if($rcon->connect()) {
			foreach($sinfo['renew'] as $cmd) {
				$back = $rcon->send_command($cmd);
				if(!empty($back)) {
					$back = mb_substr($back, 0, -1);
				}
				logModuleCall("WHMCS-Minecraft", "Rcon Result", $cmd, $back);
			}
			return 'success';
		} else {
			logModuleCall("WHMCS-Minecraft", "Rcon Error", "Failed connect to rcon server", "");
			return "无法连接到 Rcon 服务器";
		}
	}
    return 'success';
}

function minecraft_SuspendAccount(array $params) {
	include("rcon.php");
	$sinfo = minecraft_getServerInfo($params);
	if($sinfo['suspend']) {
		$rcon = new Rcon($sinfo['hostname'], $sinfo['port'], $sinfo['password'], $sinfo['timeout']);
		if($rcon->connect()) {
			foreach($sinfo['suspend'] as $cmd) {
				$back = $rcon->send_command($cmd);
				if(!empty($back)) {
					$back = mb_substr($back, 0, -1);
				}
				logModuleCall("WHMCS-Minecraft", "Rcon Result", $cmd, $back);
			}
			return 'success';
		} else {
			logModuleCall("WHMCS-Minecraft", "Rcon Error", "Failed connect to rcon server", "");
			return "无法连接到 Rcon 服务器";
		}
	}
    return 'success';
}

function minecraft_UnsuspendAccount(array $params) {
	include("rcon.php");
	$sinfo = minecraft_getServerInfo($params);
	if($sinfo['unsuspend']) {
		$rcon = new Rcon($sinfo['hostname'], $sinfo['port'], $sinfo['password'], $sinfo['timeout']);
		if($rcon->connect()) {
			foreach($sinfo['unsuspend'] as $cmd) {
				$back = $rcon->send_command($cmd);
				if(!empty($back)) {
					$back = mb_substr($back, 0, -1);
				}
				logModuleCall("WHMCS-Minecraft", "Rcon Result", $cmd, $back);
			}
			return 'success';
		} else {
			logModuleCall("WHMCS-Minecraft", "Rcon Error", "Failed connect to rcon server", "");
			return "无法连接到 Rcon 服务器";
		}
	}
    return 'success';
}

function minecraft_TerminateAccount(array $params) {
	include("rcon.php");
	$sinfo = minecraft_getServerInfo($params);
	if($sinfo['terminate']) {
		$rcon = new Rcon($sinfo['hostname'], $sinfo['port'], $sinfo['password'], $sinfo['timeout']);
		if($rcon->connect()) {
			foreach($sinfo['terminate'] as $cmd) {
				$back = $rcon->send_command($cmd);
				if(!empty($back)) {
					$back = mb_substr($back, 0, -1);
				}
				logModuleCall("WHMCS-Minecraft", "Rcon Result", $cmd, $back);
			}
			return 'success';
		} else {
			logModuleCall("WHMCS-Minecraft", "Rcon Error", "Failed connect to rcon server", "");
			return "无法连接到 Rcon 服务器";
		}
	}
    return 'success';
}

function minecraft_ClientArea(array $params) {
    $templateFile = 'templates/overview.tpl';

    return array(
		'tabOverviewReplacementTemplate' => $templateFile,
		'templateVariables' => array(
			'playerName' => $params['customfields']['游戏名字'],
		),
    );
}
