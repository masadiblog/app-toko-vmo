<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!(function_exists('con'))){
  function con(){
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'db_toko';
    $con = mysqli_connect($host, $user, $pass, $dbname);
    if(!($con)){
      echo 'Tidak dapat terhubung ke server!';
    }
    return $con;
  }
}
$con=con();

if(!(function_exists('base_url'))){
  function base_url($atRoot=FALSE,$atCore=FALSE, $parse=FALSE){
    if(isset($_SERVER['HTTP_HOST'])){
      $http=isset($_SERVER['HTTPS'])&&strtolower($_SERVER['HTTPS'])!=='off'?'https':'http'; 
      $hostname=$_SERVER['HTTP_HOST'];$dir=str_replace(basename($_SERVER['SCRIPT_NAME']),'',$_SERVER['SCRIPT_NAME']);
      $core=preg_split('@/@',str_replace($_SERVER['DOCUMENT_ROOT'],'',realpath(dirname(__FILE__))),NULL,PREG_SPLIT_NO_EMPTY);
      $core=[];
      $tmplt=$atRoot?($atCore?"%s://%s/%s/":"%s://%s/"):($atCore?"%s://%s/%s/":"%s://%s%s");
      $end=$atRoot?($atCore?$core:$hostname):($atCore?$core:$dir);
      $base_url=sprintf($tmplt,$http,$hostname,$end);
    }else{
      $base_url='http://localhost/';
    }
    if($parse){
      $base_url=parse_url($base_url);
      if(isset($base_url['path'])){
        if($base_url['path']=='/'){$base_url['path']='';
        }
      }
    }
    return $base_url;
  }
}
$base_url=base_url();
date_default_timezone_set('Asia/Jakarta');
function day_now(){
  $dn=date("D");switch($dn){case'Sun':$dn='Minggu';break;case'Mon':$dn='Senin';break;case'Tue':$dn='Selasa';break;case'Wed':$dn='Rabu';break;case'Thu':$dn='Kamis';break;case'Fri':$dn='Jumat';break;case'Sat':$dn='Sabtu';break;default:$dn='Tidak diketahui!';break;}
  return $dn;
}
function date_now($setda){
  $month=array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');$xp=explode('-',$setda);return $xp[2].' '.$month[(int)$xp[1]].' '.$xp[0];
}
$exDateNow=explode(' ',date_now(date('Y-m-d')));$day_now=day_now();$date_now=$exDateNow[0];$month_now=$exDateNow[1];$year_now=$exDateNow[2];$time_now=date('H:i:s');$full_date=$day_now.', '.date_now(date('Y-m-d')).', '.$time_now;
?>
