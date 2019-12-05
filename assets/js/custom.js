$(document).ready(function() {
	//Alert Message//////////////////////////////////////////////////////
	$('.close').click(function(){
		$(".alert-message").alert('close');
	});
	
	//Show Hide Search//////////////////////////////////////////////////////
	$('img.show_search').click(function(){
		$( ".fieldset_search" ).toggleClass("fieldset_search_new", 500);				
	});
	
	//Validate//////////////////////////////////////////////////////
	$.validator.addMethod("passwordFormat", function(value, element) {
    return this.optional(element) ||
       /^.*(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).*$/.test(value);
	}, "The password must contain of one lower case, upper case, number and special character"
  );
           
	$("#form_edit").validate({
		rules: {
				userpass: {
					required: true,
					minlength: 8,
					passwordFormat: true
				},
		}
	});
	
	//Sort//////////////////////////////////////////////////////
	/*$("#sortable" ).sortable({
		placeholder: "ui-state-highlight",
		update: function (event, ui) 
		{
			var sortz = $(this).sortable('toArray').toString();
			var uri = $(this).attr("rel");
			var pg = $(this).attr("title");
			var data  = { sortz: sortz, pg: pg};
			$.ajax({ type: "POST", url: uri, data: data,  dataType: "html", success : function(data) {
				
			}});
		}
	});*/
});

function checkedAll (id, checked) 
{
	var el = document.getElementById(id);
	var temp_id = document.getElementById('temp_id');
	var frm = document.getElementById("primary_check");
	if(frm.checked == true) checked = true;
	else checked = false;
		
	for (var i = 0; i < el.elements.length; i++) 
	{
	  el.elements[i].checked = checked;
	  var frm = $("#listz-"+el.elements[i].value).children('td');
	  if(el.elements[i].type == "checkbox" && el.elements[i].value > 0)
	  {
	  	if(checked == true)
	  	{
				frm
				.css({
				        backgroundColor:'#F90'
				      });
				     
				temp_id.value += el.elements[i].value+"-";
				$('input.delete_button').attr('disabled', false);
			}
			else
			{
				frm
				.css({
				        backgroundColor:''
				      });
				      
				temp_id.value = temp_id.value.replace(el.elements[i].value+'-','');
				$('input.delete_button').attr('disabled', true);
			}
	  }
	}
}