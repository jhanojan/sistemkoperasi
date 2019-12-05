<?php

if(!isset($katakuncirahasia)){
	$katakuncirahasia='FauzanRabbaniJhanojan290';
	}


if(!function_exists('encryptor')){
function encryptor($data,$katakuncirahasia){
        $array = array();

        if(is_array($data)){
            foreach($data as $key=>$value){
                 $array[$key] = trim(
            base64_encode(
                mcrypt_encrypt(
                    MCRYPT_RIJNDAEL_256,
                    $katakuncirahasia, $value, 
                    MCRYPT_MODE_ECB, 
                    mcrypt_create_iv(
                        mcrypt_get_iv_size(
                            MCRYPT_RIJNDAEL_256, 
                            MCRYPT_MODE_ECB
                            ), 
                        MCRYPT_RAND)
                    )
                )
            );
            }
            return $array;

        }else{

           return trim(
            base64_encode(
                mcrypt_encrypt(
                    MCRYPT_RIJNDAEL_256,
                    $katakuncirahasia, $data, 
                    MCRYPT_MODE_ECB, 
                    mcrypt_create_iv(
                        mcrypt_get_iv_size(
                            MCRYPT_RIJNDAEL_256, 
                            MCRYPT_MODE_ECB
                            ), 
                        MCRYPT_RAND)
                    )
                )
            );
       }
   }

}

if(!function_exists('decryptor')){
   function decryptor($data,$katakuncirahasia)
   {
    $array = array();

        if(is_array($data)){
            foreach($data as $key=>$value){
                 $array[$key] = trim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_256, 
                $katakuncirahasia, 
                base64_decode($value), 
                MCRYPT_MODE_ECB,
                mcrypt_create_iv(
                    mcrypt_get_iv_size(
                        MCRYPT_RIJNDAEL_256,
                        MCRYPT_MODE_ECB
                        ), 
                    MCRYPT_RAND
                    )
                )
            );
            }
            return $array;
        }else{
        return trim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_256, 
                $katakuncirahasia, 
                base64_decode($data), 
                MCRYPT_MODE_ECB,
                mcrypt_create_iv(
                    mcrypt_get_iv_size(
                        MCRYPT_RIJNDAEL_256,
                        MCRYPT_MODE_ECB
                        ), 
                    MCRYPT_RAND
                    )
                )
            );
    }
	}
}

      		if(!function_exists('getBulan')){
function getBulan($bln){
				switch ($bln){
					case '01': 
						return "January";
						break;
					case '02':
						return "February";
						break;
					case '03':
						return "March";
						break;
					case '04':
						return "April";
						break;
					case '05':
						return "May";
						break;
					case '06':
						return "June";
						break;
					case '07':
						return "July";
						break;
					case '08':
						return "August";
						break;
					case '09':
						return "September";
						break;
					case '10':
						return "October";
						break;
					case '11':
						return "November";
						break;
					case '12':
						return "December";
						break;
				}
} }

if(!function_exists('tanggalpenuh')){
	function tanggalpenuh($date){
		$month=substr($date,5,2);
		$year=substr($date,0,4);
		
	if($month=='01' || $month=='03' || $month=='05' || $month=='07' || $month=='08' || $month=='10' || $month=='12'){
		return  $year.'-'.$month.'-31';
			}
	elseif($month=='04' || $month=='06' || $month=='09' || $month=='11'){
		return  $year.'-'.$month.'-30';
			}	
	elseif($month=='02'){
			
			$cekkabisat=isTahunKabisat($year);
			if($cekkabisat==TRUE){
				return  $year.'-'.$month.'-29';
				}
			else{
				return  $year.'-'.$month.'-28';
			}
		
		}
			
	}
}

if(!function_exists('isTahunKabisat')){
	function isTahunKabisat($angkaTahun) {
	if($angkaTahun % 100 === 0) {
		if($angkaTahun % 400 === 0) return (bool)TRUE;
		else return (bool)FALSE;
	} else {
		if($angkaTahun % 4 === 0) return (bool)TRUE;
		else return (bool)FALSE;
	}
}
	
	}

function tgl_indo($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan = getBulan(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.'-'.$bulan.'-'.$tahun;		 
}	

function getBulanpendek($bln){
				switch ($bln){
					case 1: 
						return "Jan";
						break;
					case 2:
						return "Feb";
						break;
					case 3:
						return "Mar";
						break;
					case 4:
						return "Apr";
						break;
					case 5:
						return "May";
						break;
					case 6:
						return "Jun";
						break;
					case 7:
						return "Jul";
						break;
					case 8:
						return "Aug";
						break;
					case 9:
						return "Sep";
						break;
					case 10:
						return "Oct";
						break;
					case 11:
						return "Nov";
						break;
					case 12:
						return "Dec";
						break;
				}
} 
if (!function_exists('GetOptKary')){
	function GetOptKary($tabel,$judul=NULL)
	{
		if($tabel == "pendidikan") $filter = array("urut"=> "order/asc");
		else $filter = array();
		$q = GetAll($tabel, $filter);
		if($judul) $opt[''] = $judul;
		foreach($q->result_array() as $r)
		{
			$opt[$r['id']] = $r['name'];
		}
		
		return $opt;
	}
}
if(!function_exists('GetDayName')){
	function GetDayName($hari){

$timstmp=strtotime($hari);
$hari=date('w',$timstmp);
switch ($hari){
    case 0 : $hari="Minggu";
        Break;
    case 1 : $hari="Senin";
        Break;
    case 2 : $hari="Selasa";
        Break;
    case 3 : $hari="Rabu";
        Break;
    case 4 : $hari="Kamis";
        Break;
    case 5 : $hari="Jum'at";
        Break;
    case 6 : $hari="Sabtu";
        Break;
}
return $hari;

		}
}
if (!function_exists('hak_edit1')){
	function hak_edit1($adminid,$filename,$type,$r){
		if($adminid!=1){
			if($type==1){
			echo "<a href='".site_url($filename.'/detail/'.$r)."'>Edit</a>";
			}
			elseif($type==2){
				
			}
			}
		
			else{ echo "-";}
		}
	}
if (!function_exists('permissionactionz')){
	function permissionactionz()
	{
		$CI =& get_instance();
		$grup = $CI->session->userdata("webmaster_grup");
		if($grup == 4 || $grup==1) return 0;
		else return 1;
	}
}
function getAgama($agama){
				switch ($agama){
					case 'I': 
						return "ISLAM";
						break;
					case 'K':
						return "KATOLIK";
						break;
					case 'P':
						return "PROTESTAN";
						break;
					case 'H':
						return "HINDU";
						break;
					case 'B':
						return "BUDHA";
						break;
					
				}
} 

function cetakSimpanPinjam($id){
	/*echo "<script>";
	echo "window.open('')";
	echo "</script>";*/
} 
function GetPP($id=NULL){
	$CI =& get_instance();
	if($id==NULL || $id==''){
	$img=site_url('uploads').'/foto/'.'default.png';	
	}
	else{
		$gmbr=GetValue('images','tb_karyawan',array('id'=>'where/'.$id));
		//echo $CI->db->last_query();
		if($gmbr==NULL || $gmbr==''){
		$img=site_url('uploads').'/foto/'.'default.png';	
		}
		else{
		$img=site_url().'/'.$gmbr;	
		}
		
	}
	//die(''.$id);
	return $img;
	
} 
function cekqty($stok,$min){
	if($stok==0){
	$style='color:red;';
	}
	elseif($stok<=$min){
	$style='color:orange;';	
	}
	else{	
	$style='color:black;';	
	}
	return $style;
	
}