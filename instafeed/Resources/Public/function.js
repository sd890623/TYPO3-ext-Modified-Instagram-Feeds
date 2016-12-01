function changeToBollean(value) {
	if (value==null||value==''||value==0||value.length==0) {
		return 1;
	}
	else return 0;
}

function changeToReverse(object,val) {
	object.attr("select",val);
	if(val==0) {
		object.fadeTo(800,0.5);
	}
	else {
		object.fadeTo(800,1);
	}
}

$(document).ready(function() {
	$('.tx_instafeed .singleFeed').click(function(){
		reverseSelect($(this));
	});

	$('button.fetchJson').click(function(){
		$.ajax({
			url:getJsonUrl,
			cache:false,
			dataType:'html',
			method:"POST",
			data:{},
			success:function(htmldata) {
				console.log(htmldata);
			}			
		})
	});

	function reverseSelect(object) {
		var url=urlSelectUpdate;
		//console.log(changeToBollean(object.attr("select")));

		$.ajax({
			url:url,
			cache:false,
			dataType:'html',
			method:"POST",
			data: {'changeTo':changeToBollean(object.attr("select")),'itemID':object.attr("id-field")},
			success: function (htmldata) {
				//console.log(htmldata);
				changeToReverse(object,changeToBollean(object.attr("select")));
			}
		})
	}
});


var app=angular.module('instagramFeed',[]);
var app2=angular.module('instagramFeed2',[]);
var homeAddr='http://typo3.daniel.test.cerebrum/';