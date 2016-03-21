(function () {
    angular.module('CrudGenerator', ['ui.bootstrap'])
            .controller('FormGeneratorController', ['$scope', '$timeout', '$http', '$uibModal', function ($scope, $timeout, $http, $uibModal) {
                    var controller = this;
                    this.data = {};
                    this.data.entidad = '--';
                    this.data.columnas = {};
                    this.val_generar_todo = false;
                    this.val_listar_todo = false;
                    this.val_ordenar_todo = false;
                    this.relacion_input_tipo_columna = {
                        'text': 'textarea',
                        'varchar': 'text',
                        'int': 'number',
                        'smallint': 'number',
                        'char': 'text',
                    };
                    this.inputs_disponibles = {
                        'textarea': 'textarea',
                        'number': 'input type="number"',
                        'text': 'input type="text"',
                        'email': 'input type="email"',
                        'hidden': 'input type="hidden"',
                        'checkbox': 'input type="checkbox"',
                        'select': 'select',
                        'select_fk': 'select FK',
                    };

                    this.toggle_generar_todo = function () {
                        angular.forEach(controller.data.columnas, function (dataColumna, key) {
                            controller.data.columnas[dataColumna.name].generar_input = controller.val_generar_todo;
                        });
                    };
                    this.toggle_listar_todo = function () {
                        angular.forEach(controller.data.columnas, function (dataColumna, key) {
                            controller.data.columnas[dataColumna.name].mostrar_listado = controller.val_listar_todo;
                        });
                    };
                    this.togge_ordenar_todo = function () {
                        angular.forEach(controller.data.columnas, function (dataColumna, key) {
                            controller.data.columnas[dataColumna.name].ordenable = controller.val_ordenar_todo;
                        });
                    }
                    this.init = function (entidad) {
                        this._fill_model(entidad);
                    };
                    this._fill_model = function (tabla) {
                        controller.data.entidad = tabla;
                        controller.data.tabla = tabla;
                        var url = '/crud_generator/ajax_get_data_entidad';
                        var params = {entidad: tabla};
                        var config = {headers: {'Content-Type': 'application/x-www-form-urlencoded'}};
                        var successCallback = function (response) {
                            angular.forEach(response.columnas, function (dataColumna, key) {
                                controller.data.columnas[dataColumna.name] = dataColumna;
                            });

                        };
                        var errorCallback = function (response) {

                        };
                        //$http.post('/crud_generator/ajax_get_data_entidad', data, config).then(successCallback, errorCallback);
                        $http({
                            url: url,
                            data: $.param(params),
                            method: 'POST',
                            headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                        }).success(successCallback);
                        console.log(controller.data);
                    }
                    this.seleccionar_todo = function () {
                        alert('Apretó seleccionar todo');
                    };
                    this.seleccionar_tipo_campo = function (value) {
                        console.log(controller.data.columnas[value]);
                        console.info(value);
                    };
                    this.openModal = function (id_modal) {
                        console.log("Abre " + size);
                        var modalInstance = $uibModal.open({
                            animation: false,
                            templateUrl: id_modal,
                            controller: 'ModalInstanceCtrl',
                            size: size,
                            resolve: {
                            }
                        });

                        modalInstance.result.then(function () {
                        }, function () {
                            console.log("Testing " + new Date())
                        });
                    };

                }])
            .controller('ModalInstanceCtrl', function ($scope, $uibModalInstance) {
                $scope.ok = function () {
                    $uibModalInstance.close();
                };

                $scope.cancel = function () {
                    $uibModalInstance.dismiss('cancel');
                };
            });

})();