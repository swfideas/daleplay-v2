angular.module('App',[	'ui.bootstrap',	'dialogs.main',	'ui.router',	'srph.timestamp-filter',	'vesparny.fancyModal',	'angularFileUpload',	'Controllers',	'angularUUID2'	])
	.config(function($stateProvider, $urlRouterProvider){
			$urlRouterProvider.otherwise('/Login');
			$stateProvider
	        // HOME STATES AND NESTED VIEWS ========================================					.state('Login', {
	            url: '/Login',
							templateUrl: '/ci22/adminpanel_controller/login',
							controller: 'LoginController',
      				authenticate: false,
							Title : 'Login',
							cache: false,
							Admin: false
					})
	        .state('Dashboard', {	            url: '/Dashboard',							templateUrl: '/ci22/adminpanel_controller/dashboard',      				authenticate: true,							Title : 'Dashboard',							cache: false,							Admin: true	        })					.state('Categorias', {	            url: '/Categorias',							templateUrl: '/ci22/categorias_controller',							controller: 'Categoriasv2Controller',      				authenticate: true,							Title : 'Categorias',							cache: false,							Admin: true	        })					.state('Idiomas', {	            url: '/Idiomas',							templateUrl: '/ci22/idiomas_controller',							controller: 'IdiomasController',      				authenticate: true,							Title : 'Idiomas',							cache: false,							Admin: true	        })					.state('Contenidos', {	            url: '/Contenidos',							templateUrl: '/ci22/contenidos_controller',							controller: 'ContenidosController',      				authenticate: true,							Title : 'Contenidos',							cache: false,							Admin: true	        })					.state('Usuarios', {	            url: '/Usuarios',							templateUrl: '/ci22/usuario_controller',							controller: 'UsuariosController',      				authenticate: true,							Title : 'Usuarios',							cache: false,							Admin: true	        })					.state('DashboardUser', {	            url: '/DashboardUser',							templateUrl: '/ci22/adminpanel_controller/dashboarduser',      				authenticate: true,							Title : 'Dashboard',							cache: false,							Admin: false	        })					.state('ContenidosUs', {	            url: '/ContenidosUs',							templateUrl: '/ci22/contenidos_controller/indexuser',							controller: 'ContenidosController',      				authenticate: true,							Title : 'ContenidosUs',							cache: false,							Admin: false	        })					.state('MyPrep', {	            url: '/MyPrep',							templateUrl: '/ci22/adminpanel_controller/dashboarduser',      				authenticate: true,							Title : 'MyPrep',							cache: false,							Admin: false	        })					;}).factory('TitleMenuService', function($rootScope) {    var sharedService = {};    sharedService.titulo = '';    sharedService.prepForBroadcast = function(newtitulo) {        this.titulo = newtitulo;        this.broadcastItem();    };    sharedService.broadcastItem = function() {        $rootScope.$broadcast('handleTitleBroadcast');    };    return sharedService;}).factory('MegaMenuService', function($rootScope) {    var sharedMegaMenuService = {};		sharedMegaMenuService.menu = {};		sharedMegaMenuService.prepForBroadcast = function(newmenu) {        this.menu = newmenu;        this.broadcastItem();    };		sharedMegaMenuService.broadcastItem = function() {        $rootScope.$broadcast('handleMegaMenuBroadcast');    };    return sharedMegaMenuService;})// .factory('FilterService', function($rootScope) {//     var sharedFilterService = {};// 		sharedFilterService.filter = {};// 		sharedFilterService.prepForBroadcast = function(newfilter) {//         this.filter = newfilter;//         this.broadcastItem();//     };// 		sharedFilterService.broadcastItem = function() {//         $rootScope.$broadcast('handleFilterBroadcast');//     };//     return sharedFilterService;// }).run(function ($rootScope, $state, AuthService, TitleMenuService) {  $rootScope.$on("$stateChangeStart", function(event, toState, toParams, fromState, fromParams){		TitleMenuService.prepForBroadcast(toState.Title);		if(toState.url == '/Login')		{			$rootScope.uuid = null;			$rootScope.ListFilters = [];		}		else if (toState.authenticate && (!AuthService.isAuthenticated() || !(toState.Admin == AuthService.isAuthAdmin())))		{      $state.transitionTo("Login");      event.preventDefault();			$rootScope.ListFilters = [];    }	});}).controller('DashboardController',
  function($scope, $rootScope, $location, AuthService, TitleMenuService, MegaMenuService) {		console.info('ini DashboardController ');		$scope.titulo = 'Login';		var path = $location.path();		$rootScope.uuid = null;		$scope.megamenu = {};		$rootScope.ListFilters = [];
		if(AuthService.isAuthenticated())
		{
			switch(path)
			{
				case '/Categorias': $scope.titulo = 'Categorias';break;
				case '/Idiomas': $scope.titulo = 'Idiomas';break;
				case '/Contenidos': $scope.titulo = 'Contenidos';break;
				case '/Usuarios': $scope.titulo = 'Usuarios';break;
			}
		}
		$location.hash('');    $scope.go = function(newtitulo,path) {			if(AuthService.isAuthenticated()) $scope.titulo = newtitulo;    	console.info(path);			$location.path( path );			$location.hash('');			$rootScope.ListFilters = [];  	}    $scope.goFiltered = function(newtitulo, path, FilterId, Categoria) {			if(AuthService.isAuthenticated()) $scope.titulo = newtitulo;    	console.info(path);			$location.path( path );			$location.hash('');			if(FilterId == -1) $rootScope.ListFilters = [];			else			{				$scope.foundFilter = false;				angular.forEach($rootScope.ListFilters, function(item)				{			    if(item.FK_Categoria == FilterId)					{						$scope.foundFilter = true;					}			  })				if(!$scope.foundFilter)				{					var filter = {};					filter.FK_Categoria = FilterId;					filter.Categoria = Categoria;	      	$rootScope.ListFilters.push(filter);				}			}  	}		$scope.$on('handleTitleBroadcast', function() {			if(AuthService.isAuthenticated()) $scope.titulo = TitleMenuService.titulo;    })		$scope.$on('handleMegaMenuBroadcast', function() {			$scope.megamenu = MegaMenuService.menu;    })		$scope.isAdmin = function() {    	return AuthService.isAuthenticated() && $rootScope.TypeUser == true;  	};		$scope.isUser = function() {    	return AuthService.isAuthenticated() && $rootScope.TypeUser == false;  	};}).service('AuthService', function($rootScope) {  this.isAuthenticated = function() {    return $rootScope.uuid !== null;  };	this.isAuthAdmin = function() {    return $rootScope.TypeUser;  };});