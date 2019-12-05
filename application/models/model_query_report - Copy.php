<?php

class Model_query_report extends CI_Model{
	
	function masterlist($dep,$period){
		$tgl=$period;
	$query="SELECT name,nik,kg_position.title as posisi,education,date_hire_since,rekening,jamsostek,sex,date_start_contract,date_end_contract,blood_type,employe_status,religion,place_of_birth,date_of_birth,address,kg_marrital_status.title as statusnikah FROM kg_employee ";
	$query.="LEFT JOIN kg_position ON kg_position.id=kg_employee.id_position ";
	$query.="LEFT JOIN kg_marrital_status ON kg_marrital_status.id=kg_employee.id_marrital_status";
	$query.=" WHERE ";
	if($dep!=''){
		$query.="id_department='$dep' AND ";
		}
	
	$query.="date_hire_since<='$tgl' AND
		(  date_end_contract='0000-00-00' OR date_end_contract>='$tgl' )";
		$query.=" AND is_active='Active' order by employe_status";
	//echo $query;
	$q=$this->db->query($query);
	return $q->result();
	
	}
	
	function training($period){
		$query="SELECT * FROM kg_training";
		$query.=" LEFT JOIN kg_department ON kg_department.id=kg_training.departement_training";
		$query.=" WHERE SUBSTR( tgl_mulai, 1, 7 )='$period' OR SUBSTR( tgl_selesai, 1, 7 )='$period'";
	$q=$this->db->query($query);
	return $q->result();
		}
		
	function expiration($period){
		$tgl=$period;
		$bln=substr($tgl,5,2);
	$query="SELECT name,nik,kg_position.title as posisi,kg_department.title as department,education,date_hire_since,rekening,jamsostek,sex,date_start_contract,date_end_contract,blood_type,employe_status,religion,place_of_birth,date_of_birth,address,kg_marrital_status.title as statusnikah FROM kg_employee ";
	$query.="LEFT JOIN kg_position ON kg_position.id=kg_employee.id_position ";
	$query.="LEFT JOIN kg_marrital_status ON kg_marrital_status.id=kg_employee.id_marrital_status ";
	$query.="LEFT JOIN kg_department ON kg_department.id=kg_employee.id_department ";
	$query.="WHERE ";

	$query.="DATEDIFF('$tgl',date_end_contract) BETWEEN 28 AND 62";
		$query.=" AND is_active='Active'";
	//$query.="MONTH(date_end_contract)=$bln-1";
	//echo $query;
	$q=$this->db->query($query);
	return $q->result();
	
	}
	
	function sortnik($period){
		$tgl=$period;
		$tgl = substr($tgl, 0, 7);
		/*$this->db->select('*')->from('kg_employee');
		$this->db->where*/
	$query="SELECT * FROM kg_employee ";
	$query.="LEFT JOIN kg_position ON kg_position.id=kg_employee.id_position ";
	$query.="WHERE DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' )
		AND is_active='Active' order by employe_status, nik";
	//echo $query;
	$q=$this->db->query($query);
	return $q->result();
	
	}
	function perdep($period,$seldep){
		$tgl=$period;
		$tgl = substr($tgl, 0, 7);
		/*$this->db->select('*')->from('kg_employee');
		$this->db->where*/
	$query="SELECT * FROM kg_employee ";
	$query.="LEFT JOIN kg_position ON kg_position.id=kg_employee.id_position ";
	$query.="WHERE DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='$seldep' AND is_active='Active'";
	//echo $query;
	$q=$this->db->query($query);
	return $q->result();
	
	}
	
	function summary_religion($tgl){
	$result=array();
	$query=mysql_query("SELECT * FROM kg_department");
	$i=1;
	while($dep=mysql_fetch_row($query)){
		$result[$i][1]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE religion='Moslem' AND id_department='".$dep[0]."' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) "));
		$result[$i][2]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE religion='Christian' AND is_active='Active' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][3]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE religion='Catholic' AND is_active='Active' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][4]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE religion='Hindu' AND is_active='Active' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][5]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE religion='Budha' AND is_active='Active' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][6]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE religion NOT IN ('Moslem','Christian','Catholic','Hindu','Budha') AND is_active='Active' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
	$i++;
	} 
		return $result;
	}
	
	function summary_listshifting($tgl){
	$result=array();
	$bulan=substr($tgl,5,2);
	$tahun=substr($tgl,0,4);
	$query=mysql_query("SELECT * FROM kg_department");
	$i=1;
	while($dep=mysql_fetch_row($query)){
		$result[$i][1]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee LEFT JOIN kg_jadwal_shift ON kg_jadwal_shift.id_employee=kg_employee.id WHERE employe_status='permanent'
		AND place_of_birth IN ('Barabaki','Punjab','Muzaffarnagar','Kanpur Dehat','Durgapur','Mannargurdi','Deoria','Pullamangalam') AND is_active='Active'
		 AND id_department='".$dep[0]."' AND kg_jadwal_shift.bulan='$bulan' AND kg_jadwal_shift.tahun='$tahun' AND employe_status!='daily w.'"));
		
		$result[$i][2]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee LEFT JOIN kg_jadwal_shift ON kg_jadwal_shift.id_employee=kg_employee.id WHERE id_position IN (1,2) AND id_department='".$dep[0]."' AND date_hire_since<='$tgl' AND is_active='Active' AND kg_jadwal_shift.bulan='$bulan' AND kg_jadwal_shift.tahun='$tahun' AND employe_status!='daily w.' AND jum_p=0 AND jum_s=0 AND jum_m=0  "));
		
		$result[$i][3]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee LEFT JOIN kg_jadwal_shift ON kg_jadwal_shift.id_employee=kg_employee.id WHERE id_position IN (3) AND id_department='".$dep[0]."' AND date_hire_since<='$tgl' AND is_active='Active' AND kg_jadwal_shift.bulan='$bulan' AND kg_jadwal_shift.tahun='$tahun' AND employe_status!='daily w.' AND jum_p=0 AND jum_s=0 AND jum_m=0  "));
		
		
		$result[$i][4]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee LEFT JOIN kg_jadwal_shift ON kg_jadwal_shift.id_employee=kg_employee.id WHERE id_position IN (4) AND id_department='".$dep[0]."' AND date_hire_since<='$tgl' AND is_active='Active' AND kg_jadwal_shift.bulan='$bulan' AND kg_jadwal_shift.tahun='$tahun' AND employe_status!='daily w.' AND jum_p=0 AND jum_s=0 AND jum_m=0  "));
		
		
		$result[$i][5]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee LEFT JOIN kg_jadwal_shift ON kg_jadwal_shift.id_employee=kg_employee.id WHERE id_position IN (5) AND id_department='".$dep[0]."' AND date_hire_since<='$tgl' AND is_active='Active' AND kg_jadwal_shift.bulan='$bulan' AND kg_jadwal_shift.tahun='$tahun' AND employe_status!='daily w.' AND jum_p=0 AND jum_s=0 AND jum_m=0  "));
		
		$result[$i][6]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee LEFT JOIN kg_jadwal_shift ON kg_jadwal_shift.id_employee=kg_employee.id WHERE id_position NOT IN (1,2,3,4,5) AND id_department='".$dep[0]."' AND date_hire_since<='$tgl' AND is_active='Active' AND kg_jadwal_shift.bulan='$bulan' AND kg_jadwal_shift.tahun='$tahun' AND employe_status!='daily w.' AND jum_p=0 AND jum_s=0 AND jum_m=0  "));
		
		$result[$i][7]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee LEFT JOIN kg_jadwal_shift ON kg_jadwal_shift.id_employee=kg_employee.id WHERE id_department='".$dep[0]."' AND date_hire_since<='$tgl' AND is_active='Active' AND kg_jadwal_shift.bulan='$bulan' AND kg_jadwal_shift.tahun='$tahun' AND employe_status='daily w.' AND jum_p=0 AND jum_s=0 AND jum_m=0  "));
		
		$result[$i][8]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee LEFT JOIN kg_jadwal_shift ON kg_jadwal_shift.id_employee=kg_employee.id WHERE id_position IN (1,2) AND id_department='".$dep[0]."' AND date_hire_since<='$tgl' AND is_active='Active' AND kg_jadwal_shift.bulan='$bulan' AND kg_jadwal_shift.tahun='$tahun' AND employe_status!='daily w.' AND jum_ns!=0  "));
		
		$result[$i][9]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee LEFT JOIN kg_jadwal_shift ON kg_jadwal_shift.id_employee=kg_employee.id WHERE id_position IN (3) AND id_department='".$dep[0]."' AND date_hire_since<='$tgl' AND is_active='Active' AND kg_jadwal_shift.bulan='$bulan' AND kg_jadwal_shift.tahun='$tahun' AND employe_status!='daily w.' AND jum_ns!=0  "));
		
		
		$result[$i][10]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee LEFT JOIN kg_jadwal_shift ON kg_jadwal_shift.id_employee=kg_employee.id WHERE id_position IN (4) AND id_department='".$dep[0]."' AND date_hire_since<='$tgl' AND is_active='Active' AND kg_jadwal_shift.bulan='$bulan' AND kg_jadwal_shift.tahun='$tahun' AND employe_status!='daily w.' AND jum_ns!=0  "));
		
		
		$result[$i][11]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee LEFT JOIN kg_jadwal_shift ON kg_jadwal_shift.id_employee=kg_employee.id WHERE id_position IN (5) AND id_department='".$dep[0]."' AND date_hire_since<='$tgl' AND is_active='Active' AND kg_jadwal_shift.bulan='$bulan' AND kg_jadwal_shift.tahun='$tahun' AND employe_status!='daily w.' AND jum_ns!=0  "));
		
		$result[$i][12]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee LEFT JOIN kg_jadwal_shift ON kg_jadwal_shift.id_employee=kg_employee.id WHERE id_position NOT IN (1,2,3,4,5) AND id_department='".$dep[0]."' AND date_hire_since<='$tgl' AND is_active='Active' AND kg_jadwal_shift.bulan='$bulan' AND kg_jadwal_shift.tahun='$tahun' AND employe_status!='daily w.' AND jum_ns!=0  "));
		
		$result[$i][13]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee LEFT JOIN kg_jadwal_shift ON kg_jadwal_shift.id_employee=kg_employee.id WHERE id_department='".$dep[0]."' AND date_hire_since<='$tgl' AND is_active='Active' AND kg_jadwal_shift.bulan='$bulan' AND kg_jadwal_shift.tahun='$tahun' AND employe_status='daily w.' AND  jum_ns!=0  "));
		
		
				$i++;
	} 
		return $result;
			
	}
	function summary_gender($tgl){
		$result=array();
	$query=mysql_query("SELECT * FROM kg_department");
	$i=1;
	while($dep=mysql_fetch_row($query)){
		$result[$i][1]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE sex='Laki-laki' AND id_department='".$dep[0]."' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) "));
		$result[$i][2]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE sex='Perempuan' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][3]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE sex NOT IN ('Laki-laki','Perempuan') AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$i++;
	} 
		return $result;
		
		}
	function summary_marrital_status($tgl){
		$result=array();
	$query=mysql_query("SELECT * FROM kg_department");
	$i=1;
	while($dep=mysql_fetch_row($query)){
		$result[$i][1]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE id_marrital_status IN (2,3,4,5,6,7,8) AND id_department='".$dep[0]."' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) "));
		$result[$i][2]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE id_marrital_status='1' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][3]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE id_marrital_status NOT IN (1,2,3,4,5,6,7,8) AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$i++;
	} 
		return $result;
		
		}
		
	function summary_job_title($tgl){
	$result=array();
	$query=mysql_query("SELECT * FROM kg_department");
	$i=1;
	while($dep=mysql_fetch_row($query)){
		$result[$i][1]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE id_position IN (1,2) AND id_department='".$dep[0]."' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND (  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND employe_status!='daily w.' "));
		$result[$i][2]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE id_position IN (3) AND id_department='".$dep[0]."' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND (  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND employe_status!='daily w.'  "));
		$result[$i][3]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE id_position IN (4) AND id_department='".$dep[0]."' AND is_active='Active' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND (  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND employe_status!='daily w.'  "));
		$result[$i][4]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE id_position IN (5,6) AND id_department='".$dep[0]."' AND is_active='Active' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND (  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND employe_status!='daily w.'  "));
		$result[$i][5]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE id_position IN (11,12) AND id_department='".$dep[0]."' AND is_active='Active' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND (  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND employe_status!='daily w.'  "));
		$result[$i][6]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE id_position IN (9,21,7,13) AND id_department='".$dep[0]."' AND is_active='Active' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND (  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND employe_status!='daily w.'  "));
		$result[$i][7]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE id_position IN (15,18,19,20) AND id_department='".$dep[0]."' AND is_active='Active' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND (  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND employe_status!='daily w.'  "));
		$result[$i][8]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE id_position IN (17) AND id_department='".$dep[0]."' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND (  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND employe_status!='daily w.'  "));
		$result[$i][9]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE id_position IN (8,10,16,22,14) AND id_department='".$dep[0]."' AND is_active='Active' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND (  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND employe_status!='daily w.'  "));
		$result[$i][10]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE employe_status='daily w.'  AND id_department='".$dep[0]."' AND is_active='Active' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND (  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) "));
		
	$i++;
	} 
		return $result;
	}
	
	function summary_membershift_of_jamsostek($tgl){
		$result=array();
	$query=mysql_query("SELECT * FROM kg_department");
	$i=1;
	while($dep=mysql_fetch_row($query)){
		$result[$i][1]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE jamsostek!='-' AND id_department='".$dep[0]."' AND date_hire_since<='$tgl' AND
		(  date_end_contract='0000-00-00' OR date_end_contract>='$tgl' ) "));
		$result[$i][2]='&nbsp;';
		$result[$i][3]='&nbsp;';
		$result[$i][4]='&nbsp;';
		$result[$i][5]=$result[$i][1]+$result[$i][2]+$result[$i][3]+$result[$i][4];
		$result[$i][6]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE jamsostek='-' AND date_hire_since<='$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR date_end_contract>='$tgl' ) AND id_department='".$dep[0]."'"));
		$i++;
	} 
		return $result;
		
		}
		function summary_education($tgl)
		{
		$result=array();
	$query=mysql_query("SELECT * FROM kg_department");
	$i=1;
	while($dep=mysql_fetch_row($query)){
		$result[$i][1]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE education REGEXP 'Univ|S1' AND id_department='".$dep[0]."' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) "));
		$result[$i][2]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE education REGEXP 'D3|D 3' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][3]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE education REGEXP 'D2|D 2' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][4]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE education REGEXP 'D1|D 1' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][5]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE education REGEXP 'THS-M|THS M' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][6]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE education REGEXP 'THS-E|THS E' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][7]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE education REGEXP 'THS|SMK' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][8]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE education REGEXP 'SHS of Ecm' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][9]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE (education='SHS' OR education='SHS +') AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][10]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE education REGEXP 'Aliyah' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][11]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE education='JHS' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][12]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE education REGEXP 'JHS of' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][13]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE education REGEXP 'ES|Elem' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$result[$i][14]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE education='-' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND is_active='Active' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		$i++;
	}  
		return $result;
		
		}
		function summary_employee_status($tgl){
		$result=array();
	$query=mysql_query("SELECT * FROM kg_department");
	$i=1;
	while($dep=mysql_fetch_row($query)){
		$result[$i][1]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE employe_status='permanent'
		AND place_of_birth IN ('Barabaki','Punjab','Muzaffarnagar','Kanpur Dehat','Durgapur','Mannargurdi','Deoria','Pullamangalam') AND is_active='Active'
		 AND id_department='".$dep[0]."' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) "));
		
		$result[$i][2]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE employe_status='permanent' 
		AND place_of_birth NOT IN ('Barabaki','Punjab','Muzaffarnagar','Kanpur Dehat','Durgapur','Mannargurdi','Deoria','Pullamangalam') AND is_active='Active' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		
		$result[$i][3]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE employe_status='contract'
		AND ((DATEDIFF(date_end_contract,date_start_contract) BETWEEN 178 AND 181) OR (DATEDIFF(date_end_contract,date_start_contract) is NULL)) AND is_active='Active'
		 AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		
		$result[$i][4]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE employe_status='contract'
		AND DATEDIFF(date_end_contract,date_start_contract) BETWEEN 364 AND 367 AND is_active='Active'
		 AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND is_active='Active' AND id_department='".$dep[0]."'"));
		
		$result[$i][5]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE employe_status='contract' 
		AND DATEDIFF(date_end_contract,date_start_contract) BETWEEN 728 AND 731 AND is_active='Active'
		AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND id_department='".$dep[0]."'"));
		
		$result[$i][6]=mysql_num_rows(mysql_query("SELECT * FROM kg_employee WHERE employe_status='daily w.' AND DATE_FORMAT(date_hire_since,'%Y-%m') <= '$tgl' AND
		(  date_end_contract='0000-00-00' OR DATE_FORMAT(date_end_contract,'%Y-%m') >= '$tgl' ) AND is_active='Active' AND id_department='".$dep[0]."'"));
		$i++;
	} 
		return $result;
		
		}
		
	function keterlambatan(){
		
			$query="SELECT * FROM kg_view_kehadiran a LEFT JOIN kg_employee b ON b.id=a.id_employee WHERE terlambat='1' AND is_active='Active'";
			$query.=" AND date_full>='".$this->input->post('start_date')."' AND date_full<='".$this->input->post('end_date')."'";
		/*$p=$this->input->post('pilihperiod');
		
		if($p=='periodday')
		{$query.=" AND tanggal='".$this->input->post('d')."' AND bulan='".$this->input->post('m')."' AND tahun='".$this->input->post('Y')."'";
			}
		else{
			$query.=" AND bulan='".$this->input->post('bulan')."' AND tahun='".$this->input->post('tahun')."'";
			}*/
	$q=$this->db->query($query);
	return $q->result();
	}
	
	function rekapkehadiran($dep,$period){
		$query="SELECT * FROM kg_employee LEFT JOIN kg_gaji ON kg_gaji.id_employee=kg_employee.id LEFT JOIN kg_position ON kg_employee.id_position=kg_position.id WHERE kg_employee.id_department='$dep'";
		$q=$this->db->query($query);
		return $q;
		
		}
	function resignation($period){
	$query="SELECT name,nik,kg_position.title as posisi,kg_department.title as department,education,kg_employee.modify_date as resignation_date,kg_exitmng.alasan_keluar as ket FROM kg_employee ";
	$query.="LEFT JOIN kg_position ON kg_position.id=kg_employee.id_position ";
	$query.="LEFT JOIN kg_department ON kg_department.id=kg_employee.id_department ";
	$query.="LEFT JOIN kg_exitmng ON kg_exitmng.id_employee=kg_employee.id ";
	$query.="WHERE kg_employee.is_active='inActive'";
	$q=$this->db->query($query);
	return $q->result();
		}
		
	function daftargaji()
	{
		$data=array();
		if($this->input->post("seldep")) $dep = "WHERE id='".$this->input->post('seldep')."'";
		else $dep="";
		
		$dep=$this->db->query("SELECT * FROM kg_department $dep");
		foreach($dep->result_array() as $r)
		{
			$a = $r['id'];
			$query=mysql_query("SELECT * FROM kg_employee LEFT JOIN kg_gaji ON kg_gaji.id_employee=kg_employee.id LEFT JOIN kg_position ON kg_employee.id_position=kg_position.id WHERE kg_employee.id_department='$a' AND id_position NOT IN (1,2,3)");
			$i=1;
			while($isi=mysql_fetch_assoc($query))
			{
		$data[$a][$i]['nama']=$isi['name'];
		$data[$a][$i]['nik']=$isi['nik'];
		$data[$a][$i]['title']=$isi['title'];
		$data[$a][$i]['datehire']=$isi['date_hire_since'];
		$data[$a][$i]['rekening']=$isi['rekening'];
		$data[$a][$i]['all_shf']=$isi['all_shf'];
		$data[$a][$i]['con_allw']=$isi['con_allw'];
		$data[$a][$i]['overtime']=$isi['overtime'];
		$data[$a][$i]['basic']=$isi['basic'];
		$data[$a][$i]['bulan_ini']=$isi['bulan_ini'];
		$data[$a][$i]['rapel']=$isi['rapel'];
		$data[$a][$i]['rp_all_shf']=$isi['all_shf'] / 173 * $isi['basic'];
		$data[$a][$i]['rp_con_allw']=$isi['con_allw'] / 173 * $isi['basic'];
		$data[$a][$i]['rp_overtime']=$isi['overtime'] / 173 * $isi['basic'];
		$data[$a][$i]['tj_transport']=$isi['tj_transport'];
		$data[$a][$i]['tj_kehadiran']=$isi['tj_kehadiran'];
		$data[$a][$i]['mkhr']=$isi['mkhr'];
		$data[$a][$i]['uang_makan']=$isi['uang_makan'];
		$data[$a][$i]['bruto']=$data[$a][$i]['bulan_ini']+$data[$a][$i]['rapel']+$data[$a][$i]['rp_all_shf']+$data[$a][$i]['rp_con_allw']+$data[$a][$i]['rp_overtime']+$data[$a][$i]['tj_transport']+$data[$a][$i]['tj_kehadiran']+$data[$a][$i]['mkhr']+$data[$a][$i]['uang_makan'];
		if(!$isi['bulan_ini']) $isi['bulan_ini']=1;
		$data[$a][$i]['lembur']= round(($data[$a][$i]['rp_overtime'] / $isi['bulan_ini']) * 100);
		$data[$a][$i]['jamsostek']=2/100*$isi['basic'];
		$data[$a][$i]['absen']=$isi['absen'];
		$data[$a][$i]['bpr']=$isi['bpr'];
		$data[$a][$i]['btn']=$isi['btn'];
		$data[$a][$i]['pot']=$data[$a][$i]['jamsostek']+$data[$a][$i]['absen']+$data[$a][$i]['bpr']+$data[$a][$i]['btn'];
		$data[$a][$i]['totals']=$data[$a][$i]['bruto']-$data[$a][$i]['pot'];
		$i++;
			}
		}
		return $data;
	}
	function slipgaji($idemploy,$period){
		$query="SELECT * FROM kg_employee LEFT JOIN kg_gaji ON kg_gaji.id_employee=kg_employee.id LEFT JOIN kg_position ON kg_employee.id_position=kg_position.id WHERE kg_employee.id='$idemploy'";
		$q=$this->db->query($query);
		return $q;
		}
		
		function claim_insurance($period){
		
	$query="SELECT kg_employee.name as nama,kg_insurance.tanggal as tgl,kg_position.title as posisi,kg_department.title as department,kg_insurance.jenis_klaim as koc,kg_insurance.value as val,kg_insurance.remark as rm FROM kg_employee ";
	$query.="LEFT JOIN kg_position ON kg_position.id=kg_employee.id_position ";
	$query.="LEFT JOIN kg_department ON kg_department.id=kg_employee.id_department ";
	$query.="LEFT JOIN kg_insurance ON kg_insurance.nama=kg_employee.id ";
	$query.="WHERE SUBSTR( kg_insurance.tanggal, 1, 7 )='$period'";
	$q=$this->db->query($query);
	return $q->result();
	
		}
		
		function dailyworker($period){
		$result=array();
	$query=mysql_query("SELECT * FROM kg_department");
	$i=1;
	while($dep=mysql_fetch_row($query)){
		$result[$i][1]=mysql_num_rows(mysql_query("SELECT * FROM kg_dailyworker WHERE position IN (8,10,14) AND departement='".$dep[0]."' AND (SUBSTR( tgl_mulai, 1, 7 )='$period' OR SUBSTR( tgl_selesai, 1, 7 )='$period')"));
		$result[$i][2]=mysql_num_rows(mysql_query("SELECT * FROM kg_dailyworker WHERE position IN (18,15,16,21,22) AND departement='".$dep[0]."' AND (SUBSTR( tgl_mulai, 1, 7 )='$period' OR SUBSTR( tgl_selesai, 1, 7 )='$period')"));
		$result[$i][3]=mysql_num_rows(mysql_query("SELECT * FROM kg_dailyworker WHERE position IN (17) AND departement='".$dep[0]."' AND (SUBSTR( tgl_mulai, 1, 7 )='$period' OR SUBSTR( tgl_selesai, 1, 7 )='$period')"));
		$result[$i][4]=mysql_num_rows(mysql_query("SELECT * FROM kg_dailyworker WHERE pendidikan='Universitas' AND departement='".$dep[0]."' AND (SUBSTR( tgl_mulai, 1, 7 )='$period' OR SUBSTR( tgl_selesai, 1, 7 )='$period')"));
		$result[$i][5]=mysql_num_rows(mysql_query("SELECT * FROM kg_dailyworker WHERE pendidikan='D1-D3' AND departement='".$dep[0]."' AND (SUBSTR( tgl_mulai, 1, 7 )='$period' OR SUBSTR( tgl_selesai, 1, 7 )='$period')"));
		$result[$i][6]=mysql_num_rows(mysql_query("SELECT * FROM kg_dailyworker WHERE pendidikan='SHS' AND departement='".$dep[0]."' AND (SUBSTR( tgl_mulai, 1, 7 )='$period' OR SUBSTR( tgl_selesai, 1, 7 )='$period')"));
		$result[$i][7]=mysql_num_rows(mysql_query("SELECT * FROM kg_dailyworker WHERE pendidikan='THS' AND departement='".$dep[0]."' AND (SUBSTR( tgl_mulai, 1, 7 )='$period' OR SUBSTR( tgl_selesai, 1, 7 )='$period')"));
		$result[$i][8]=mysql_num_rows(mysql_query("SELECT * FROM kg_dailyworker WHERE pendidikan='JHS' AND departement='".$dep[0]."' AND (SUBSTR( tgl_mulai, 1, 7 )='$period' OR SUBSTR( tgl_selesai, 1, 7 )='$period')"));
		$q9=mysql_fetch_row(mysql_query("SELECT MIN(tgl_mulai) FROM kg_dailyworker WHERE departement='".$dep[0]."' AND (SUBSTR( tgl_mulai, 1, 7 )='$period' OR SUBSTR( tgl_selesai, 1, 7 )='$period')"));
		$result[$i][9]=tgl_indo($q9[0]);
		$q10=mysql_fetch_row(mysql_query("SELECT MAX(tgl_selesai) FROM kg_dailyworker WHERE departement='".$dep[0]."' AND (SUBSTR( tgl_mulai, 1, 7 )='$period' OR SUBSTR( tgl_selesai, 1, 7 )='$period')"));
		$result[$i][10]=tgl_indo($q10[0]);
		$q11=mysql_fetch_row(mysql_query("SELECT remark FROM kg_dailyworker WHERE departement='".$dep[0]."' AND (SUBSTR( tgl_mulai, 1, 7 )='$period' OR SUBSTR( tgl_selesai, 1, 7 )='$period')"));
		$result[$i][11]=$q11[0];
		
		
	$i++;
	} 
		return $result;
		}
	
	function personnelrecord($dep,$period){
			
	$query="SELECT kg_employee.name as nama,kg_position.title as posisi,kg_department.title as department,kg_riwayatsanksi.alasan as alasan,kg_riwayatsanksi.tindakan as tindakan,kg_riwayatsanksi.tgl_sanksi as tgl,kg_riwayatsanksi.batas_sanksi as batas,kg_riwayatsanksi.remark as rm FROM kg_employee ";
	$query.="LEFT JOIN kg_position ON kg_position.id=kg_employee.id_position ";
	$query.="LEFT JOIN kg_department ON kg_department.id=kg_employee.id_department ";
	$query.="LEFT JOIN kg_riwayatsanksi ON kg_riwayatsanksi.karyawan=kg_employee.id ";
	$query.="WHERE '$period' BETWEEN SUBSTR(kg_riwayatsanksi.tgl_sanksi,1,7) AND SUBSTR(kg_riwayatsanksi.batas_sanksi,1,7)";
	if($dep!=''){
		$query.=" AND id_department='$dep'";
	}
	$q=$this->db->query($query);
	return $q->result();
		}
		
		function reportfinger($tgl){
		$query="SELECT * FROM kg_view_kehadiran WHERE date_full='$tgl' ORDER BY name ASC";
		return $this->db->query($query)->result();
		}
	function promotion($tgl){
		
		$query="SELECT * FROM kg_promotion WHERE SUBSTR(date,1,7)='$tgl' ORDER BY name ASC";
		return $this->db->query($query)->result();
	}
	function demotion($tgl){
		
		$query="SELECT * FROM kg_demotion WHERE SUBSTR(date,1,7)='$tgl' ORDER BY name ASC";
		return $this->db->query($query)->result();
	}
	function rolling($tgl){
		
		$query="SELECT * FROM kg_rolling WHERE SUBSTR(date,1,7)='$tgl' ORDER BY name ASC";
		return $this->db->query($query)->result();
	}
	function polashift($per,$dep){
		$q="SELECT * FROM kg_employee LEFT JOIN kg_jadwal_shift ON kg_jadwal_shift.id_employee=kg_employee.id WHERE kg_employee.id_department='$dep' AND kg_jadwal_shift.bulan='".substr($per,5,2)."' AND kg_jadwal_shift.tahun='".substr($per,0,4)."'";
		
		return $this->db->query($q)->result();
		}
	
}