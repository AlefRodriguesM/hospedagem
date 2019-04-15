<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de usuários
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i>Início</a></li>
    <li class="active"><a href="/admin/users">Usuários</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">

            <div class="box-header">
              <a href="/admin/users/create" class="btn btn-success">Cadastrar usuário</a>
            </div>

            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th style="width: 20px">#</th>
                    <th>Usuário</th>
                    <th>E-Mail</th>
                    <th style="width: 60px">Administrador</th>
                    <th style="width: 60px">Inativo</th>
                    <th>Dt. Cadastro</th>
                    <th style="width: 140px">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $counter1=-1;  if( isset($users) && ( is_array($users) || $users instanceof Traversable ) && sizeof($users) ) foreach( $users as $key1 => $value1 ){ $counter1++; ?>
                  <tr>
                    <td><?php echo htmlspecialchars( $value1["PK_ID"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><img src="C:\xampp\htdocs\hospedagem\res\img\wifi.png" class="img-fluid"></img></td>
                    <td><?php echo htmlspecialchars( $value1["DS_LOGIN"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["DS_EMAIL"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php if( $value1["TG_ADMIN"] == 1 ){ ?>Sim<?php }else{ ?>Não<?php } ?></td>
                    <td><?php if( $value1["TG_INATIVO"] == 1 ){ ?>Sim<?php }else{ ?>Não<?php } ?></td>
                    <td><?php echo htmlspecialchars( $value1["DH_INCLUSAO"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td>
                      <a href="/admin/users/<?php echo htmlspecialchars( $value1["PK_ID"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Editar</a>
                      <a href="/admin/users/<?php echo htmlspecialchars( $value1["PK_ID"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" onclick="return confirm('Você tem certeza que deseja deletar este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Deletar</a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
