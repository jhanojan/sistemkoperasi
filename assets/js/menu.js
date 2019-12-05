/* 
Simple JQuery menu.
HTML structure to use:

Notes: 

1: each menu MUST have an ID set. It doesn't matter what this ID is as long as it's there.
2: each menu MUST have a class 'menu' set. If the menu doesn't have this, the JS won't make it dynamic

Optional extra classnames:

noaccordion : no accordion functionality
collapsible : menu works like an accordion but can be fully collapsed
expandfirst : first menu item expanded at page load

<ul id="menu1" class="menu [optional class] [optional class]">
<li><a href="#">Sub menu heading</a>
<ul>
<li><a href="http://site.com/">Link</a></li>
<li><a href="http://site.com/">Link</a></li>
<li><a href="http://site.com/">Link</a></li>
...
...
</ul>
<li><a href="#">Sub menu heading</a>
<ul>
<li><a href="http://site.com/">Link</a></li>
<li><a href="http://site.com/">Link</a></li>
<li><a href="http://site.com/">Link</a></li>
...
...
</ul>
...
...
</ul>

Copyright 2008 by Marco van Hylckama Vlieg

web: http://www.i-marco.nl/weblog/
email: marco@i-marco.nl

Free for non-commercial use
*/

function initMenus() 
{
	var contain = document.getElementById("contain_menu");
	$('ul.menu ul').hide();
	$('ul.menu ul ul').show();
	$.each($('ul.menu'), function()
	{
		if(contain.value.length > 0) {$('#' + this.id + '.expandfirst ul:contains("'+contain.value+'")').show();}
		else $('#' + this.id).show();
	});
	$('ul.menu li a').click(
		function() {
			var checkElement = $(this).next();
			var parent = this.parentNode.parentNode.id;

			if($('#' + parent).hasClass('noaccordion')) {
				$(this).next().slideToggle('normal');
				return false;
			}
			if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
				if($('#' + parent).hasClass('collapsible')) {
					$('#' + parent + ' ul:visible').slideUp('normal');
				}
				return false;
			}
			if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
				$('#' + parent + ' ul:visible').slideUp('normal');
				checkElement.slideDown('normal');
				return false;
			}
		}
	);
}

function initExpandableList() 
{
	$('ul.expandable-list li div.expandablecontent').hide();
	$('ul.expandable-list li a.head').click(
		function() {
			var clickedLink = $(this).parent();
			var activeIndex = $('ul.expandable-list li.list').index(clickedLink);
			
			//alert(activeIndex);
			
			if(clickedLink.hasClass('activelist')){
				//do nothing				
			}
			else{
				
				clickedLink.siblings().removeClass('activelist');
				clickedLink.addClass('activelist');					
							
				//$('div.expandablecontent').show();
				$('div.expandablecontent').slideUp();
				$('div.expandablecontent').removeClass('activelist');
				//$('div.expandablecontent').hide();
				$('div.expandablecontent').eq(activeIndex).slideDown();
				$('div.expandablecontent').eq(activeIndex).addClass('activelist');
			}
		}
	);
}

$(document).ready(function() {initMenus();initExpandableList();});