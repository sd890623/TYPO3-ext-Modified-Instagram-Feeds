app.filter ('lengthTrim',function() {
	return function(input) {
		if (input.length>20) return input.substr(0,24)+"...";
	};
});