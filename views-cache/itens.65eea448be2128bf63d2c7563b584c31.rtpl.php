<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de itens
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i>Início</a></li>
    <li class="active"><a href="/admin/itens">Itens</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">

            <div class="box-header">
              <a href="/admin/itens/create" class="btn btn-success">Cadastrar item</a>
            </div>

            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th style="width: 64px">Imagem</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th style="width: 60px">Inativo</th>
                    <th>Dt. Cadastro</th>
                    <th style="width: 140px">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $counter1=-1;  if( isset($itens) && ( is_array($itens) || $itens instanceof Traversable ) && sizeof($itens) ) foreach( $itens as $key1 => $value1 ){ $counter1++; ?>
                  <tr>
                    <td><?php echo htmlspecialchars( $value1["PK_ID"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><img src="../res/admin/img/itens/<?php echo htmlspecialchars( $value1["PK_ID"], ENT_COMPAT, 'UTF-8', FALSE ); ?>.png"></img></td>
                    <td><?php echo htmlspecialchars( $value1["DS_NOME"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["DS_DESCRICAO"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php if( $value1["TG_INATIVO"] == 1 ){ ?>Sim<?php }else{ ?>Não<?php } ?></td>
                    <td><?php echo htmlspecialchars( $value1["DH_INCLUSAO"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td>
                      <a href="/admin/itens/<?php echo htmlspecialchars( $value1["PK_ID"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Editar</a>
                      <a href="/admin/itens/<?php echo htmlspecialchars( $value1["PK_ID"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" onclick="return confirm('Você tem certeza que deseja deletar este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Deletar</a>
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
