<?php
$menu=$current_menu="";
$webmaster_grup = $this->session->userdata("webmaster_grup");
$sub_dir = $this->uri->segment(1);
$id = GetValue("id","menu_admin", array("filez"=> "where/".$this->uri->segment(2)));
$this->db->where("category", strtoupper($sub_dir));
$this->db->where("id_parents",$id);
$this->db->order_by("id_parents", "asc");
$this->db->order_by("sort", "asc"); 
$query=$this->db->get("menu_admin");
foreach($query->result() as $row)
{
	if($row->filez == $this->uri->segment(2)) $current_menu=$row->title;
	$this->db->where("id_parents",$row->id);
	if($multi_lang) $this->db->where("id_lang",$this->session->userdata("ses_id_lang"));
	$this->db->order_by("sort", "asc"); 
	$query2=$this->db->get("menu_admin");
	$sub_menu="";
	if($query2->num_rows() > 0)
	{
		$sub_menu.="<ul class='sub'>";
		foreach($query2->result() as $row2)
		{
			if($row2->filez == $this->uri->segment(2)) $current_menu=$row2->title;
			
			if(cek_akses($this->db, $row2->id, $webmaster_grup) || $webmaster_grup == "8910")
			$sub_menu.="<li><a href='".base_url()."index.php/webmaster/".$row2->filez."' title='".$row2->title."'><span class='text'>".$row2->title."</span></a></li>";
		}
		$sub_menu.="</ul>";
	}
	
	if(cek_akses($this->db, $row->id, $webmaster_grup) || $webmaster_grup == "8910")
	{
		if($row->filez != "#")
		{
			$menu.= "<li>
								<a class='submenu' title='".$row->title."' href='".base_url()."index.php/webmaster/".$row->filez."'>
									<span class='openheader menuheader'>".$row->title."</span>
								</a>
							</li>";
		}
		else $menu.= "<li><a><span class='openheader menuheader'>".$row->title."</span></a>".$sub_menu."</li>";
	}
}
?>

<input type="hidden" id="contain_menu" value="<?php echo $current_menu;?>"/>

<?php
if($menu)
{
?>
<div class="well">
	<div class="arrowlistmenu">
		<div id="side-menu-container">
			<ul id="side-menu" class="menu expandfirst">
				<?php echo $menu;?>
			</ul>
		</div>
	</div>
</div>
<?php
}
?>