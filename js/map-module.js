var app = angular.module('AngularGoogleMap', ['google-maps']);

app.config( [ '$locationProvider', function( $locationProvider ) {
   $locationProvider.html5Mode( true );
}]);
 
app.controller('MapCtrl', ['$scope', function ($scope) {
	
	function fetchGetVariables() {
      var loc = window.location.href; // Use this in actual use
      var result = {};

      var parts = loc.split("?");

      if (parts.length > 0) {
        var params = parts[1].split("&");

        for (var i = 0; i < params.length; i++) {
          var keyValuePair = params[i].split("=");

          var key = keyValuePair[0];
          var value = "";
          if (keyValuePair.length > 0) {
            value = keyValuePair[1];
          } 

          result[key] = value;
        }
      }

      return result;
    }
    

	$scope.map = {
		center: {
			latitude: fetchGetVariables().latitude, 
			longitude: fetchGetVariables().longitude
		}, 
		zoom: 12,
		options : {
			scrollwheel: false
		},
		control: {}
	};
	$scope.marker = {
		id: 0,
		coords: {
			latitude: fetchGetVariables().latitude,
			longitude: fetchGetVariables().longitude
		},
		options: {
			draggable: true
		}
	};
}]);