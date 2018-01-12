var page = 0;

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
var groupHtml = "";
$(function() { load(); });
function load()
{
		$.ajax({url: "php/pex/entity/getgroups.php"}).done(function(json)
							{
								var records = JSON.parse(json);
								
								for (key in records) {
									groupHtml += "<option>" + records[key].name + "</option>";
								}
								
								loadUsers();
							
							});
		
	
	$("#search").change(function()
	{
		loadUsers({ search: $("#search").val()  });
	});

	$(".next").click(function() {page++; loadUsers();});
	$(".previous").click(function() {if (page > 0) { page--; loadUsers(); }});
}




function loadUsers(dataA)
{
		if(page == 0)
		{
			$(".previous").css("display", "none");
		} else {
			$(".previous").css("display", "inherit");
		}
		if (dataA !== undefined)
		{
			var param = {
						  type: "GET",
						  url: "php/pex/entity/get.php?page=" + page,
						  data:  dataA
						}
		} else {
						var param = {
						  type: "GET",
						  url: "php/pex/entity/get.php?page=" + page
						}
		}
		
		$("#perms").find("tr > td").parent().remove();
		
		$.ajax(param).done(function(json)
							{
								
								var records = JSON.parse(json);
								for (key in records) {
									var status = records[key].status;
									var html = "<tr id='row" + records[key].id +  "'>";
									html += "<td class='id'>" + records[key].id + "</td>";
									html += "<td class='nameTd'>" + getFullDisplay(records[key].prefix, records[key].name, records[key].suffix) + "</td>";
									html += "<td class='reg'>" + ((status == "1") ? "<img src='images/tick.png' />" : "<img src='images/x.png' />")  + "</td>";
									html += "<td><select id='groups" + records[key].id + "' data-name='" + records[key].name + "'>" + groupHtml  + "</select></td>";
									html += "<td><a href='userdetails.php?name=" + records[key].name + "'>View details...</a> </td>";
									html += "<td><a href='prism.php?uuid=" + records[key].uuid + "&name=" + records[key].name +"'>PRISM</a></td></tr>";
									var e = $(html);
									e.appendTo("#perms");
					
									var opts = $("#groups" + records[key].id).children("option");
									
									$("#groups" + records[key].id).change(function(e)
									{
										var t = $(e.currentTarget);
										changeGroup(t.attr("data-name"), t.val());
									
									});
									
									for(option in opts)
									{
										option = opts[option];
										if(option.text === records[key].group)
										{
											$(option).prop('selected', true);
										}
									}
								}
								doClicking();
							});

}


function doClicking()
{
	$(".prefix").click(function(e)
	{
		var t = $(e.currentTarget);
		var name = t.parent().find(".name").attr("data-original");
		var suf = t.parent().find(".suffix").attr("data-original");
		var input = $("<input>");
		input.attr("value", t.attr("data-original"));
		input.attr("data-name", name);
		input.attr("data-suf", suf);
		input.focusout(function(e)
		{
			
			var t = $(e.currentTarget);
			var newHtml = getFullDisplay(t.val(), t.attr("data-name"), t.attr("data-suf"));
			updatePrefix(t.parent().parent().find(".id").text(), t.val());
			t.parent().html(newHtml);
			doClicking();
		});
		
		input.keyup(function(e)
		{
			if(event.keyCode == 13){
				var t = $(e.currentTarget);
				var newHtml = getFullDisplay(t.val(), t.attr("data-name"), t.attr("data-suf"));
				updatePrefix(t.parent().parent().find(".id").text(), t.val());
				t.parent().html(newHtml);
				doClicking();
			}
		});
		
		t.replaceWith(input);
		input.focus();
	});
	
	
	$(".suffix").click(function(e)
	{
		var t = $(e.currentTarget);
		var name = t.parent().find(".name").attr("data-original");
		var pre = t.parent().find(".prefix").attr("data-original");
		var input = $("<input>");
		input.attr("value", t.attr("data-original"));
		input.attr("data-name", name);
		input.attr("data-pre", pre);
		input.focusout(function(e)
		{
			var t = $(e.currentTarget);
			var newHtml = getFullDisplay(t.attr("data-pre"), t.attr("data-name"), t.val());
			updateSuffix(t.parent().parent().find(".id").text(), t.val());
			t.parent().html(newHtml);
			doClicking();
		});
		
				
		input.keyup(function(e)
		{
			if(event.keyCode == 13){
				var t = $(e.currentTarget);
				var newHtml = getFullDisplay(t.attr("data-pre"), t.attr("data-name"), t.val());
				updateSuffix(t.parent().parent().find(".id").text(), t.val());
				t.parent().html(newHtml);
				doClicking();
			}
		});
		
		t.replaceWith(input);
		input.focus();
	});
}


function changeGroup(name, to)
{
	$.ajax({url: "php/pex/entity/changegroup.php?name=" + name+ "&group=" + to});


}

function updatePrefix(id, prefix)
{
		$.ajax({url: "php/pex/entity/edit.php?id=" + id + "&prefix=" + encodeURIComponent(prefix)})
}

function updateSuffix(id, suffix)
{
		$.ajax({url: "php/pex/entity/edit.php?id=" + id + "&suffix=" + encodeURIComponent(suffix)})
}

function getFullDisplay(pre, name, suf)
{
  return name;
}

function get2FullDisplay(pre, name, suf)
{
	var string = pre+name+suf;
	var newString = "<div class='lone prefix' value='prefix' data-original='" + pre + "'>";
	var started = false;
	var skip =  false;
	var colour = false;
	var colourCode = false;
	for (var i = 0, len = string.length; i < len; i++) 
	{
		if (i == pre.length)
		{
			newString += "</div><div class='lone name' value='name' data-original='" + name + "'>";
			if (colour !== false) newString += "<span style='color: " + colour + "'>"; 
		}
		
		if (i == pre.length+name.length)
		{
			newString += "</div><div class='lone suffix' value='suffix' data-original='" + suf + "'>";
		}
		
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
	
	if (suf.length == 0)
	{
		newString += "</div><div class='lone suffix' value='suffix' data-original='" + suf + "'></div>";
	}
	
	return newString;
	
}


function orderBy(field, direction)
{
	

}