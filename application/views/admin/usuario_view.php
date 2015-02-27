<!-- content area -->
<div class="content_fullwidth less2" ng-controller="UsuariosController">

    <div class="container">
        <div class="one_full" >

            <div class="dp_form1">
                <form
                accept-charset="utf-8"
                class="sky-form" id="sky-form" name="skyform"
                ng-submit="save()"
                >
                <header>Agregar <strong>Usuario</strong></header>

                <fieldset>
                    <section>
                        <label class="input">
                          <i class="icon-append fa-key"></i>
                          <input type="text" name="usuario" ng-model="usuario.UserName" placeholder="Usuario" required ng-minlength="5" ng-maxlength="15">
                          <span style="color:red" ng-show="skyform.usuario.$dirty && skyform.usuario.$invalid">
                          <span ng-show="skyform.usuario.$error.required">Usuario Requerido.</span>
                          <span ng-show="skyform.usuario.$error.minlength">Usuario Minimo 5 Caracteres.</span>
                          <span ng-show="skyform.usuario.$error.maxlength">Usuario Máximo 15 Caracteres.</span>
                        </label>
                    </section>

                    <section>
                        <label class="input">
                          <i class="icon-append fa-globe"></i>
                          <input type="password" name="password" ng-model="usuario.Password" placeholder="Contraseña" required ng-minlength="5" ng-maxlength="15">
                          <span style="color:red" ng-show="skyform.password.$dirty && skyform.password.$invalid">
                          <span ng-show="skyform.password.$error.required">Contraseña Requerida.</span>
                          <span ng-show="skyform.password.$error.minlength">Contraseña Minimo 5 Caracteres.</span>
                          <span ng-show="skyform.password.$error.maxlength">Contraseña Máximo 15 Caracteres.</span>
                        </label>
                    </section>

                    <section>
                        <label class="input">
                          <i class="icon-append fa-globe"></i>
                          <input type="password" name="confirmapassword" ng-model="usuario.ConfirmaPassword" placeholder="Confirma Contraseña"
                                 ng-required="!skyform.password.$pristine"
                                 password-verify="usuario.Password"
                                 ng-show="!skyform.password.$pristine"
                                 >
                          <span style="color:red" ng-show="skyform.confirmapassword.$dirty && skyform.confirmapassword.$invalid">
                          <span ng-show="skyform.confirmapassword.$error.passwordVerify">Las Contraseñas No Son Iguales.</span>
                        </label>
                    </section>

                    <section>
                    	<label class="input">
                    		<i class="icon-append fa-globe"></i>
                          <input type="email" name="email" ng-model="usuario.Email" placeholder="Email" required>
                          <span style="color:red" ng-show="skyform.email.$dirty && skyform.email.$invalid">
                          <span ng-show="skyform.email.$error.required">Email Requerido.</span>
                          <span ng-show="skyform.email.$error.email">Email Inválido.</span>
          							<i></i>
          						</label>
                    </section>

                    <section>
                    	<label class="input">
                    		<i class="icon-append fa-globe"></i>
                          <input type="text" name="telefono" ng-model="usuario.Telefono" placeholder="Teléfono" ng-maxlength="50">
                          <span style="color:red" ng-show="skyform.telefono.$dirty && skyform.telefono.$invalid">
                          <span ng-show="skyform.telefono.$error.maxlength">Usuario Máximo 50 Caracteres.</span>
          							<i></i>
          						</label>
                    </section>

                    <section>
                    	<label class="checkbox">
                    		<i class=""></i>
							                 <?php echo form_checkbox(array('id' => 'EsAdmin'
                                                            , 'name' => 'EsAdmin'
                                                            , 'ng-model'=>'usuario.EsAdmin'
                                                            , 'ng-true-value'=>'true'
                                                            , 'ng-false-value'=>'false')); ?>

          							<i></i>
                        Es Administrador
          						</label>
                    </section>

                    <section>
                    	<label class="checkbox">
                    		<i class=""></i>
							                 <?php echo form_checkbox(array('id' => 'UsuarioActivo'
                                                            , 'name' => 'UsuarioActivo'
                                                            , 'ng-model'=>'usuario.UsuarioActivo'
                                                            , 'ng-true-value'=>'true'
                                                            , 'ng-false-value'=>'false')); ?>

          							<i></i>
                        Usuario Activo
          						</label>
                    </section>

                </fieldset>
                <footer>
                    <button type="button" class="button button-secondary" ng-click="refresh()">Cancelar</button>
                    <input type="submit" class="button" value="Guardar"
                           ng-class="{'state-disabled' : skyform.usuario.$invalid || skyform.password.$invalid || skyform.confirmapassword.$invalid || skyform.email.$invalid }"
                           ng-disabled="skyform.usuario.$invalid || skyform.password.$invalid || skyform.confirmapassword.$invalid || skyform.email.$invalid"/>
                    <!-- <pre>usuario {{usuario  | json}}</pre> -->
                </footer>
                </form>
            </div>

        </div>

        <div class="one_full">

            <table border="0" cellpadding="4" cellspacing="0" class="table " >
		        <thead>

		            <tr>
		                <th>Usuario</th>
		                <th>Email</th>
		                <th>Tipo</th>
		                <th>Activo</th>
		                <th></th>
		            </tr>
		        </thead>
		        <tbody ng-repeat="usuario in usuarios">
		            <tr>
                    <td style="width:100px;">{{ usuario.UserName }}<span class="dp_tinydetail">ID: {{ usuario.PK_Usuario }}</span></td>
		                <td>{{ usuario.Email }}</td>
                    <td><p class="dp_infolabel">{{ EsAdmin(usuario.EsAdmin) }}</p></td>
                    <td><p class="dp_infolabel">{{ UsuarioActivo(usuario.UsuarioActivo) }}</p></td>
		                <td class="alicent dp_actions">
		                	<a href="javascript:void(0)" class="smlinks" ng-click="edit(usuario)"><i class="fa fa-edit"></i> Editar</a>
		                	<a href="javascript:void(0)" class="smlinks" ng-click="delete(usuario)"><i class="fa fa-trash-o"></i> Borrar</a>
                      <a href="javascript:void(0)" class="smlinks" ng-click="detalle(usuario, $index)"><i class="fa fa-check-square-o"></i> Privilegios</a>
		                </td>
		            </tr>

                <tr ng-show="evaluate($index)" class="animate fadeIn" style="background:#FAFAFA">
                  <td colspan="5">
                    <form ng-submit="savecats()" class="sky-form">
                      <label class="checkbox" style="font-weight:bold;">
                        <i class=""></i>
                        <input type="checkbox" ng-model="selall.Selected" ng-change="changeall()" />
                        <i class=""></i>
                        Seleccionar Todos
                      </label>
                      <div class="container">
                        <div ng-class="$index % 3 == 0 ? 'one_third last' : 'one_third'" ng-repeat="cat in categorias">
                          <label class="checkbox">
                            <i class=""></i>
                            <input type="checkbox" ng-model="cat.Exist" ng-change="unselectall(cat)"
                            ng-true-value="true" ng-false-value="false"  />
                            <i class=""></i>
                            {{cat.Categoria}}
                          </label>
                        </div>
                      </div>
                      <footer>
                        <input type="submit" class="button pull-right" value="Guardar"/>
                      </footer>
                    </form>
                    <!-- <pre>categorias {{categorias  | json}}</pre> -->
                  </td>
                </tr>
		        </tbody>
		    </table>



        </div>


    </div>

</div><!-- ./content area -->
<div class="clearfix"></div>
