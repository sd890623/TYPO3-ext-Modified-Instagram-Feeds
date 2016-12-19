app.controller('feedSetsCtrl',function($scope,storage,$rootScope,utility) {


	//Listener
	$scope.$on('first data loaded', function(event, args) {
		
		angular.forEach($scope.feedSets,function(val,key) {
			//$scope.changeFeeds(val);				
		});
	});

	//Funcs
	$scope.initFeedSets=function(lastTab,first) {
		first= first || 0;

		storage.fetchFeedSets().then(function(response) {
			$scope.feedSets=response;
			for (var i=0;i<feedSets.length;i++) {
				feedSets[i].showHashInput=feedSets[i].hashTags?false:true;
				feedSets[i].tags=utility.getTags(feedSets[i].pictures);
			}
			if (lastTab) $scope.tabs=$scope.feedSets.length-1;
			$scope.$digest();
			if (first) $rootScope.$broadcast('first data loaded');
			
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
					$scope.initFeedSets(true,true);
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
	$scope.changeFeeds=function(feedSet) {
		feedSet.submitted="Sending, please wait.";
		params={'feedSet-uid':feedSet.uid,'hashtags':feedSet.hashTags};
		storage.changeFeeds(params).then(function(response) {
			if(response) {
				feedSet.submitted=false;
				feedSet.showHashInput=false;
				$scope.initFeedSets(false);

			}
			else {feedSet.submitted=false;}
			//utility.showError("hashtags not exist",$scope);}
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

	$scope.showObjects=function() {
		console.log($scope.feedSets);
	}
	//test-out
	$scope.notes="Create your campaigns";
	$scope.debug=true;

	//Iniit
	$scope.tabs=0;
	$scope.initFeedSets(false,true);


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

