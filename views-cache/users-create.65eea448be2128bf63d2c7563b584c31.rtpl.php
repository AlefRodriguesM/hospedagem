<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de usuários
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i>Início</a></li>
    <li><a href="/admin/users">Usuários</a></li>
    <li class="active"><a href="/admin/users/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Novo usuário</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/users/create" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="DS_LOGIN">Usuário</label>
              <input type="text" class="form-control" id="DS_LOGIN" name="DS_LOGIN" placeholder="Usuário..">
            </div>
            <div class="form-group">
              <label for="DS_PASSWORD">Senha</label>
              <input type="password" class="form-control" id="DS_PASSWORD" name="DS_PASSWORD" placeholder="Senha..">
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" name="TG_ADMIN" value="1"> Acesso de administrador
              </label>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success">Cadastrar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
