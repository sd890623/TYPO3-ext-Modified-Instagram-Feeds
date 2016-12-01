var feedSets=null;

app.service('api',function($http){



	this.fetchFeeds=function() {
		return $http.get(getJsonUrl);
	}
	this.updateSingleFeed=function(data) {
		//$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
		//return $http.post(feedUpdateUrl, data);
		return $.ajax({
			url:feedUpdateUrl,
			method:"POST",
			cache:false,
			data:data
		});
	}
	//for feedSets
	this.fetchFeedSets= function() {
		return $http.get(getFeedSetsUrl);
	}
	this.updateFeedSet=function(data) {	
		return $.ajax({
			url:feedUpdateUrl,
			method:"POST",
			cache:false,
			data:data
		});
	},
	this.addFeedSet=function(data) {	
		return $.ajax({
			url:addFeedSetUrl,
			method:"POST",
			cache:false,
			data:data
		});
	},
	this.removeFeedSet=function(data) {	
		return $.ajax({
			url:removeFeedSetUrl,
			method:"POST",
			cache:false,
			data:data
		});
	},
	this.editFeedSet=function(data) {	
		return $.ajax({
			url:editFeedSetUrl,
			method:"POST",
			cache:false,
			data:data
		});
	}	
	

});

app.service('storage',function(api) {
	this.fetchFeedSets=function() {
		return new Promise(function(resolve,reject) {
			api.fetchFeedSets().then(
				function (response) {
					feedSets=response.data;
					resolve(feedSets);
				},
				function(response) {
					console.log("Error"+response);
					reject(Error(response));
				}
			);

		});

	},
	this.fetchFeeds=function() {
		return new Promise(function(resolve,reject) {
			api.fetchFeeds().then(
				function (response) {
					resolve(response.data);
				},
				function(response) {
					console.log("Error",response);
					reject(Error(response));
				}
			);
		});
	},
	this.addFeeds=function(paramArray) {
		return new Promise(function(resolve,reject) {
			paramArray["type"]="add";
			api.updateFeedSet(paramArray).done(function(data) {
				console.log(data);
				if (data==null || data=="") reject (Error("error"));
				else if (data=="feeds added") resolve(true);
				else resolve(false);
			});
		});
	},

	this.updateSelect=function(paramArray) {
		return new Promise(function(resolve,reject) {
			paramArray["type"]="select";
			api.updateSingleFeed(paramArray).done(function(data) {
				//console.log(data);
				if (data==null || data=="") reject (Error("error"));
				else if (data=="select Updated") resolve(true);
				else resolve(false);
			});
		});
	},
	this.removeFeed=function(paramArray) {
		return new Promise(function(resolve,reject) {
			paramArray["type"]="remove";
			api.updateSingleFeed(paramArray).done(function(data) {
				//console.log(data);
				if (data==null || data=="") reject (Error("error"));
				else if (data=="removed") resolve(true);
				else resolve(false);
			});
		});
	},
//for feed sets
	this.updateSetSelect=function(paramArray) {
		return new Promise(function(resolve,reject) {
			paramArray["type"]="select";
			api.updateFeedSet(paramArray).done(function(data) {
				
				if (data==null || data=="") reject (Error("error"));
				else if (data=="select Updated") resolve(true);
				else resolve(false);
			});
		});
	},
	this.removeSetFeed=function(paramArray) {
		return new Promise(function(resolve,reject) {
			paramArray["type"]="remove";
			api.updateFeedSet(paramArray).done(function(data) {
				console.log(data);
				if (data==null || data=="") reject (Error("error"));
				else if (data=="removed") resolve(true);
				else resolve(false);
			});
		});
	},	
	this.addFeedSet=function(paramArray) {
		return new Promise(function(resolve,reject) {
			
			api.addFeedSet(paramArray).done(function(data) {
				console.log(data);
				if (data==null || data=="") reject (Error("error"));
				else if (data=="feedSet added") resolve(true);
				else resolve(false);
			});
		});
	},
	this.removeFeedSet=function(paramArray) {
		return new Promise(function(resolve,reject) {
			
			api.removeFeedSet(paramArray).done(function(data) {
				if (data==null || data=="") reject (Error("error"));
				else if (data=="feedSet removed") resolve(true);
				else resolve(false);
			});
		});
	},
	this.editFeedSet=function(paramArray) {
		return new Promise(function(resolve,reject) {
			api.editFeedSet(paramArray).done(function(data) {
				if (data==null || data=="") reject (Error("error"));
				else if (data=="feedSet updated") resolve(true);
				else resolve(false);
			});
		});
	}
	

});


app.service('utility',function() {
	this.getTags=function(objects) {
		var tags=[];
		for (var i=0; i<objects.length;i++) {
			var tagsArray=objects[i].hashtag.split(",");
			for(var m=0;m<tagsArray.length;m++) {
				var exist=false;
				for (var j=0; j<tags.length;j++) {
					if (tagsArray[m]==tags[j]) exist=true;
				}
				if (!exist) tags.push(tagsArray[m]);
			}

		}
		return tags;
	}
});