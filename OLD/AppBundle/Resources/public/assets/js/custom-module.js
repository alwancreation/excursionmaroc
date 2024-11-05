//*INIT*//
var app = angular.module("productApp", ['ngSanitize']);

app.factory('jQuery', function() {
    return $;
});








app.controller("customPropCtrl", function($scope, propService) {
    $scope.props = [];
    $scope.productId = 57;
    $scope.customProperty = {};
    $scope.customPropertyType = 1;


    propService.getProps($scope.productId,function(dataResponse) {
        $scope.props = dataResponse;
    });

    $scope.addProp = function(){
        propService.addProp($scope.customProperty,function(dataResponse) {
            $scope.props = dataResponse;
            $scope.customProperty.name = "";
            $scope.customProperty.description = "";
        });
        return false;
    }





    $scope.newProperty = function(){
        $scope.formEditProperty = false;
        $scope.formAddProperty = !$scope.formAddProperty;
        $scope.customProperty.name = "";
        $scope.customProperty.description = "";
    }
    $scope.editProperty = function(property){
        $scope.customProperty = property;
        $scope.formAddProperty = true;
        $scope.formEditProperty = true;
    }

    $scope.deleteProp = function(property){

        if(!$scope.deletingProperty && confirm('Confirm !')){
            $scope.deletingProperty = true;
        }else{
            return;
        }

        propService.deleteProperty({id:property.id},function(data) {
            var index = $scope.props.indexOf(property);
            if (index > -1) {
                $scope.props.splice(index, 1);
                $scope.pagedItems = [$scope.claim];
                $scope.deletingProperty = false;
            }
        });
    }




});



app.service("propService", function($http) {

    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    this.postData = function (params,url,callbackFunc){
        $http.post(url,$.param(params)).success(function(data){
            callbackFunc(data);
        }).error(function(){
        });
    };

    this.addProp = function(property,callbackFunc) {
        this.postData(property,Routing.generate("product_add_custom_property"),callbackFunc);
    };

    this.deleteProperty = function(params,callbackFunc) {
        this.postData(params,Routing.generate("product_delete_custom_property"),callbackFunc);
    };

    this.getProps = function(id,callbackFunc) {
        this.postData({product_id:id},Routing.generate("product_get_custom_properties"),callbackFunc);
    };


});