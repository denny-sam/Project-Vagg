
		var postid;
		var ups=0;
		var downs=0;
		var id='';
		$(document).ready(function(){
			$('.butupvote').bind('click', upvote);
			$('.butdownvote').bind('click', downvote);
			$('#followbutton').bind('click', followstat);
			$('.numups').bind('click', numupvote);
			$('.numdowns').bind('click', numdownvote);
		});
		
//<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
//<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>




function upvote()
	{
		var currClass= $(this).attr('class');
		var sibClass=$(this).next().attr('class');
		if (currClass=="butupvote" && sibClass=="butdownvote butdownvoted")
		{
			$(this).next().trigger('click');
		}
		
		if(currClass=="butupvote")
		{
			$(this).html("<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>");
		}
		else{
			$(this).html("<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>");
		}
		$(this).prev().trigger('click');
		$(this).toggleClass('butupvoted');
			
}

function numupvote()
{
	var nums=$(this).text()*1;
	id=$(this).next().attr('id');
	if ($(this).next().attr('class')=="butupvote")
{
	nums+=1;
}
else{
	nums-=1;
}
	$(this).text(nums);
	
	var xmlHttp=createRequest();
	xmlHttp.open("GET", "voting.php?postid="+id+"&nums="+nums+"&type=upvote",true);
	xmlHttp.send();
}

function downvote()
	{
		var currClass= $(this).attr('class');
		var sibClass=$(this).prev().attr('class');
		if (currClass=="butdownvote" && sibClass=="butupvote butupvoted")
		{
			$(this).prev().trigger('click');
		}
		if(currClass=="butdownvote")
		{
			$(this).html("<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>");
		}
		else{
			$(this).html("<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>");
		}
		
		$(this).next().trigger('click');
		$(this).toggleClass('butdownvoted');
		
	}

function numdownvote()
{
	var nums=$(this).text()*1;
	id=$(this).prev().attr('id');
	if ($(this).prev().attr('class')=="butdownvote")
{
	nums+=1;
}
else{
	nums-=1;
}
	$(this).text(nums);
	
	var xmlHttp=createRequest();
	xmlHttp.open("GET", "voting.php?postid="+id+"&nums="+nums+"&type=downvote",true);
	xmlHttp.send();
	
}

function createRequest()
	{
		var xmlHttp= new XMLHttpRequest();
		return xmlHttp;

	}


function followstat()
{
	var clas=$(this).attr('class');

	if (clas=='btn btn-danger btn-sm')
	{

	$(this).toggleClass('btn btn-danger btn-sm', false);
	$(this).toggleClass('btn btn-primary btn-sm',true);
	$(this).text("Follow");

	var xmlHttp=createRequest();
	xmlHttp.open("GET", "followstat.php?type=unfollow");
	xmlHttp.send();


	}

	else
	{

	$(this).toggleClass('btn btn-primary btn-sm', false);
	$(this).toggleClass('btn btn-danger btn-sm',true);
	$(this).text("Unfollow");

	var xmlHttp=createRequest();
	xmlHttp.open("GET", "followstat.php?type=follow");
	xmlHttp.send();

	}
}