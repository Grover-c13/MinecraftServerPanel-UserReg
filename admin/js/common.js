function editfy(element)
{
	console.info(element.edified);
	if (element.attr("data-edified"))
	{
		return;
	}
	element.attr("data-raw", element.text());
	element.html(colourfy(element.text()));
	var input = $("<input type='text'>");
	input.css("display", "none");
	input.partnerElement = element;
	element.after(input);
	var image = $("<img  class='editicon' src='images/edit.png'>");
	element.append(image);
	element.editImage = image;
	
	element.click(function()
	{
		element.editImage.remove();
		element.css("display", "none");
		input.css("display", "inherit");
		input.val(element.attr("data-raw"));
		input.focus();
	});
	
	input.focusout(function()
	{
		element.attr("data-raw", input.val())
		input.partnerElement.html(colourfy(input.val()));
		input.partnerElement.css("display", "inherit");
		var image = $("<img class='editicon' src='images/edit.png'>");
		element.append(image);
		element.editImage = image;
		input.css("display", "none");
	});
	
	input.change(function()
	{
		input.partnerElement.val(input.val());
		handleAjax(input.partnerElement, function(result) { console.info(result); } );
	});
	
	element.attr("data-edified" , "true");
}


var colours = {
0:"#000000",
1:"#0000AA",
2:"#00AA00",
3:"#00AAAA",
4:"#AA0000",
5:"#AA00AA",
6:"#FFAA00",
7:"#AAAAAA",
8:"#555555",
9:"#5555FF",
a:"#55FF55",
b:"#55FFFF",
c:"#FF5555",
d:"#FF55FF",
e:"#FFFF55",
f:"#FFFFFF"
};


function colourfy(string)
{
	var newString = "";
	var started = false;
	var skip = false;
	for (var i = 0, len = string.length; i < len; i++) 
	{

		if(string[i] == "&")
		{
			skip = true;
			var code = colours[string[i+1]];
			if(code !== undefined)
			{
				var colour = code;
				var colourCode = i+1;
				if(started)
				{
					newString += "</span>";
				}
				newString += "<span style='color: " + code + "'>";
				started = true;
			}
			
			
			
		} else {
			if (skip)
			{
				skip = false;
				continue;
			}
			newString += string[i];
		}
	}
	
	if(started)
	{
		newString += "</span>";
	}
	
	return newString;
}


function handleAjax(element, done)
{
	var url = element.attr("data-url");
	var fill = element.attr("data-get-fill");
	var get = JSON.parse(element.attr("data-get"));
	
	if (fill !== undefined)
	{
		get[fill] = element.val();
	}
	console.info(get);
  var newDone= function(data)
  {
    console.info(data);
    done(data);
  }
	$.ajax({type: "GET", url: url, data:  get}).done(newDone);
	console.info(url);
	console.info(get);
}


$(function()
{
	$('#server').change(function(e)
	{
		$.ajax({type: "GET", url: "php/server/setsession.php?index=" + $(e.currentTarget).prop('selectedIndex')});
	});

});


function doEditfy()
{
		var elements = $(".editfy");
		$.each(elements, function(index, value)
		{
			editfy($(value));
		});
}