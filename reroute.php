<?php
session_start();

function main(){
	if(isset($_SESSION['id'])){
		if($_SESSION['id'] == 'admin'){
			header("Location: dashboard.php");
		} else {
			header("Location: candidates.php");
		}
	}	
}

function admin(){
	if(isset($_SESSION['id'])){
		if($_SESSION['id'] != 'admin'){
			header("Location: candidates.php");
		}	
	} else {
		header("Location: index.php");
	}	
}

function user(){
	if(!isset($_SESSION['id'])){
		header("Location: index.php");
	}
}

function profile(){
	if(!isset($_SESSION['id'])){
		header("Location: index.php");
	} else {
		if($_SESSION['id'] == 'admin'){
			header("Location: dashboard.php");
		}
	}
}
?>