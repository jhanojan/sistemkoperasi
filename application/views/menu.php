<?php
$menu=$current_menu="";
if($this->uri->segment(1) != "home")
{
	$path_file = $this->uri->segment(1);
	$webmaster_grup = $this->session->userdata("webmaster_grup");
	$this->db->where("id_parents",0);
	$this->db->where("is_publish", "Publish");
	$this->db->order_by("id_parents", "asc");
	$this->db->order_by("sort", "asc"); 
	$query=$this->db->get("menu_admin");
	foreach($query->result() as $row)
	{
		if($row->filez == $path_file) $current_menu=$row->title;
		$this->db->where("id_parents",$row->id);
		$this->db->where("is_publish", "Publish");
		//if($multi_lang) $this->db->where("id_lang",$this->session->userdata("ses_id_lang"));
		$this->db->order_by("sort", "asc"); 
		$query2=$this->db->get("menu_admin");
		$sub_menu="";
		if($query2->num_rows() > 0)
		{
			$sub_menu.="<ul class='sub'>";
			foreach($query2->result() as $row2)
			{
				if($row2->filez == $path_file) $current_menu=$row2->title;
				
				$this->db->where("id_parents",$row2->id);
				$this->db->where("is_publish", "Publish");
				$this->db->order_by("sort", "asc"); 
				$query3=$this->db->get("menu_admin");
				$sub_menu2="";
				if($query3->num_rows() > 0)
				{
					$sub_menu2 .="<ul class='sub'>";
					foreach($query3->result() as $row3)
					{
						if($row3->filez == $path_file) $current_menu=$row3->title;
						
						$this->db->where("id_parents",$row3->id);
						$this->db->where("is_publish", "Publish");
						$this->db->order_by("sort", "asc"); 
						$query4=$this->db->get("menu_admin");
						$sub_menu3="";
						if($query4->num_rows() > 0)
						{
							$sub_menu3 .="<ul class='sub'>";
							foreach($query4->result() as $row4)
							{
								if($row4->filez == $path_file) $current_menu=$row4->title;
								
								if(cek_akses($this->db, $row4->id, $webmaster_grup) || $webmaster_grup == "8910")
								$sub_menu3 .="<li style='margin-left:34px;'><a href='".base_url().$row4->filez."' title='".$row4->title."'><span class='text'>".$row4->title."</span></a></li>";
							}
							$sub_menu3 .="</ul>";
						}
						if(cek_akses($this->db, $row3->id, $webmaster_grup) || $webmaster_grup == "8910")
						{
							if($row3->filez != '#') $sub_menu2 .="<li style='margin-left:-4px;'><a href='".base_url().$row3->filez."' title='".$row3->title."'><span class='text'>".$row3->title."</span></a>".$sub_menu3."</li>";
							else $sub_menu2 .="<li style='margin-left:-4px;'><a title='".$row3->title."'><span class='text'>".$row3->title."</span></a>".$sub_menu3."</li>";
						}
					}
					$sub_menu2 .="</ul>";
				}
				if(cek_akses($this->db, $row2->id, $webmaster_grup) || $webmaster_grup == "8910")
				{
					if($row2->filez != '#') $sub_menu.="<li><a href='".base_url().$row2->filez."' title='".$row2->title."'><span class='text'>".$row2->title."</span></a>".$sub_menu2."</li>";
					else $sub_menu.="<li><a title='".$row2->title."'><span class='text'>".$row2->title."</span></a>".$sub_menu2."</li>";
				}
			}
			$sub_menu.="</ul>";
		}
		
		if(cek_akses($this->db, $row->id, $webmaster_grup) || $webmaster_grup == "8910")
		{
			if($row->filez != "#")
			{
				$menu.= "<li>
									<a class='submenu' title='".$row->title."' href='".base_url().$row->filez."'>
										<span class='openheader menuheader'>".$row->title."</span>
									</a>
									".$sub_menu."
								</li>";
			}
			else $menu.= "<li><a><span class='openheader menuheader'>".$row->title."</span></a>".$sub_menu."</li>";
		}
	}
}
?>

<input type="hidden" id="contain_menu" value="<?php echo $current_menu;?>"/>

<?php
if($menu)
{
	echo "<div id='menu' style='display:none;'>$menu</div>";
}
?>