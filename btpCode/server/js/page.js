$(document).ready(function(){
$('.small-text').live('click',showMessage);
function showMessage()
{
		openBox();
		$('#confirm_submit').live('click',closeBox);
		
}

});
