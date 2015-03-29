var app = angular.module('myApp', ['ngRoute']);
app.factory("services", ['$http', function($http) {
  var serviceBase = 'services/'
    var obj = {};
    obj.getTarefas = function(){
        return $http.get(serviceBase + 'tarefas');
    }
    obj.getTarefa = function(tarefaID){
        return $http.get(serviceBase + 'tarefa?id=' + tarefaID);
    }

    obj.insertTarefa = function (tarefa) {
    return $http.post(serviceBase + 'insertTarefa', tarefa).then(function (results) {
        return results;
    });
	};

	obj.updateTarefa = function (id,tarefa) {
	    return $http.post(serviceBase + 'updateTarefa', {id:id, tarefa:tarefa}).then(function (status) {
	        return status.data;
	    });
	};

	obj.deleteTarefa = function (id) {
	    return $http.delete(serviceBase + 'deleteTarefa?id=' + id).then(function (status) {
	        return status.data;
	    });
	};

    return obj;   
}]);

app.controller('listCtrl', function ($scope, services) {
    services.getTarefas().then(function(data){
        $scope.tarefas = data.data;
    });
});

app.controller('editCtrl', function ($scope, $rootScope, $location, $routeParams, services, tarefa) {
    var tarefaID = ($routeParams.tarefaID) ? parseInt($routeParams.tarefaID) : 0;
    $rootScope.title = (tarefaID > 0) ? 'Editar Tarefa' : 'Nova Tarefa';
    $scope.buttonText = (tarefaID > 0) ? 'Alterar Tarefa' : 'Incluir Nova Tarefa';
      var original = tarefa.data;
      original._id = tarefaID;
      $scope.tarefa = angular.copy(original);
      $scope.tarefa._id = tarefaID;

      $scope.isClean = function() {
        return angular.equals(original, $scope.tarefa);
      }

      $scope.deleteTarefa = function(tarefa) {
        $location.path('/');
        if(confirm("Tem certeza que deseja apagar a tarefa numero: "+$scope.tarefa._id)==true)
        services.deleteTarefa(tarefa.id);
      };

      $scope.saveTarefa = function(tarefa) {
        $location.path('/');
        if (tarefaID <= 0) {
            services.insertTarefa(tarefa);
        }
        else {
            services.updateTarefa(tarefaID, tarefa);
        }
    };
});

app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/', {
        title: 'Tarefas',
        templateUrl: 'paginas/tarefas.html',
        controller: 'listCtrl'
      })
      .when('/edit-tarefa/:tarefaID', {
        title: 'Editar Tarefas',
        templateUrl: 'paginas/editar-tarefa.html',
        controller: 'editCtrl',
        resolve: {
          tarefa: function(services, $route){
            var tarefaID = $route.current.params.tarefaID;
            return services.getTarefa(tarefaID);
          }
        }
      })
      .otherwise({
        redirectTo: '/'
      });
}]);
app.run(['$location', '$rootScope', function($location, $rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
    });
}]);