app.controller('feedSetsCtrl',function($scope,storage,$rootScope,utility) {


	//Listener
	$scope.$on('data loaded', function(event, args) {
		

		angular.forEach($scope.feedSets,function(val,key) {
			//val.tags=utility.getTags(val.pictures);
			$scope.$watchCollection(function() {return val.pictures;} , function(newValue,oldValue) {
				val.tags=utility.getTags(newValue);
				console.log("tags changed");
			});
			
		});
		$scope.$digest();
	});

	$scope.initFeedSets=function(lastTab) {

		storage.fetchFeedSets().then(function(response) {
			$scope.feedSets=response;
			if (lastTab) $scope.tabs=$scope.feedSets.length-1;
			$rootScope.$broadcast('data loaded');
		},function(error) {

		});		
	}

	$scope.checkActive=function(val) {
		if (val==$scope.tabs) {
			return true;
		}
	}
	$scope.checkEditing=function(feedSet) {
		if (feedSet.editing==true) {
			return true;
		}
		else return false;
	}
	
	$scope.setTab=function(val) {
		$scope.tabs=val;
	}
	$scope.editTab=function(feedSet) {
		feedSet.editing=true;
	}
	$scope.addTab=function() {
		//var feedSetArray=[];
		//feedSetArray['name']="New Tab";
		if ($scope.newFeedSetName=="") $scope.newFeedSetName="Please fill in the name";
		else {
			params={'name':$scope.newFeedSetName}
			storage.addFeedSet(params).then (function(response) {
				if(response) {
					$scope.initFeedSets(true);
					$scope.newFeedSetName="";
				}
			});		
		}
	}

	$scope.removeTab=function(feedSet) {
		params={'feedSet-uid':feedSet.uid};
		storage.removeFeedSet(params).then (function (response) {
			if (response) {
				$scope.feedSets.splice($scope.feedSets.indexOf(feedSet),1);
				$scope.tabs=0;
				$scope.$digest();
			}
		});
	}
	$scope.saveEditTab=function(feedSet) {
		params={'feedSet-uid':feedSet.uid,'name':feedSet.name};
		storage.editFeedSet(params).then (function (response) {
			if (response) {
				feedSet.editing=false;
				$scope.$digest();
			}
		});
		
	}
	$scope.addFeeds=function(feedSet) {
		feedSet.submitted=true;
		params={'feedSet-uid':feedSet.uid,'hashtags':feedSet.hashTags};
		storage.addFeeds(params).then(function(response) {
			if(response) {
				$scope.initFeedSets(false);
				feedSet.hashTags="";
				feedSet.submitted=false;
			}
			else feedSet.submitted=false;
		});
	}
	$scope.changeSelect=function(feed,feedSet) {
		params={'feed-uid':feed.uid,'feedSet-uid':feedSet.uid,'selected':!feed.selected};
		storage.updateSetSelect(params).then (function(response) {
			if(response) {

				feed.selected=!feed.selected;
				$scope.$digest();
			}
		});
	}
	$scope.removeFeed=function(feed,feedSet) {
		params={'feed-uid':feed.uid,'feedSet-uid':feedSet.uid};
		storage.removeSetFeed(params).then(function(response) {
			if(response) {
				feedSet.pictures.splice(feedSet.pictures.indexOf(feed),1);
				$scope.$digest();
			}
		});
	}
	//test-out
	$scope.notes="Create your campaigns";
	//Iniit

	$scope.tabs=0;
	$scope.initFeedSets(false);

});

app.controller('singleFeedSet',function($scope,storage,utility) {
	$scope.feeds={};
	$scope.isSelected=function(feed) {
		return feed.selected?'selected':'';
	}

	$scope.changeSelect=function(feed) {

		params={'uid':feed.uid,'selected':!feed.selected};
		
		storage.updateSelect(params).then(function(response) {
			if(response) {
				feed.selected=!feed.selected;
				$scope.$digest();
			}
		});

	}
	$scope.removeFeed=function(feed) {
		params={'uid':feed.uid};
		storage.removeFeed(params).then(function(response) {
			if(response) {
				$scope.feeds.splice($scope.feeds.indexOf(feed),1);
				$scope.$digest();
			}
		});
	}
	$scope.$watchCollection(function() {return $scope.feeds;} , function(newValue,oldValue) {
		$scope.tags=utility.getTags(newValue);
	});
	storage.fetchFeeds().then(function(response) { 
		$scope.feeds=response;
		$scope.$digest();
	},function(error) {

	});

});

