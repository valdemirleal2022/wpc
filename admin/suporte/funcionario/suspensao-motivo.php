<?php

if ( function_exists( ProtUser ) ) {
    if ( !ProtUser( $_SESSION[ 'autUser' ][ 'id' ] ) ) {
        header( 'Location: painel.php?execute=suporte/403' );
    }
}

$_SESSION[ 'url' ] = $_SERVER[ 'REQUEST_URI' ];

?><head>
    <meta charset="iso-8859-1">
</head>



<div class="content-wrapper">
    <section class="content-header">
        <h1>Motivo Suspens&otilde;es</h1>
        <ol class="breadcrumb">
            <li><a href="painel.php?execute=painel"><i class="fa fa-home"></i>Home</a>
            </li>
            <li><a href="#">Cadastro</a>
            </li>
            <li class="active">Motivo Suspens&otilde;es</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header">
                        <a href="painel.php?execute=suporte/funcionario/suspensao-motivo-editar" class="btnnovo">
                      <img src="ico/novo.png" alt="Criar Novo" title="Criar Novo" class="tip" />
                 </a>
              </div>
            <!-- /.box-header -->

    <div class="box-body table-responsive data-spy='scroll'">
     	<div class="col-md-12 scrool">  
			<div class="box-body table-responsive">

    <?php 
	 

 	$leitura = read('funcionario_suspensao_motivo',"WHERE id ORDER BY id ASC");
	if($leitura){
			echo '<table class="table table-hover">	
					<tr class="set">
					<td align="center">Id</td>
					<td align="center">Nome</td>
					<td align="center" colspan="3">Gerenciar</td>
				</tr>';
		foreach($leitura as $mostra):
	 
		 	echo '<tr>';
				
				echo '<td>'.$mostra['id'].'</td>';
				echo '<td>'.$mostra['nome'].'</td>';
			
				echo '<td align="center">
				<a href="painel.php?execute=suporte/funcionario/suspensao-motivo-editar&movitosuspensaoEditar='.$mostra['id'].'">
			  				<img src="ico/editar.png" title="Editar" />
              			</a>
				      </td>';
				echo '<td align="center">
			  			<a href="painel.php?execute=suporte/funcionario/suspensao-motivo-editar&movitosuspensaoDeletar='.$mostra['id'].'">
							<img src="ico/excluir.png" title="Excluir" />
              			</a>
						</td>';
			echo '</tr>';
		
		 endforeach;
		
		echo '</table>';
		
			
		}
	?>

                  <div class="box-footer">
            <?php echo $_SESSION['cadastro'];
			unset($_SESSION['cadastro']);
			?>
        </div><!-- /.box-footer-->

	    </div><!--/box-body table-responsive-->   
	  </div><!-- /.col-md-12 scrool -->
 	  </div><!-- /.box-body table-responsive -->
 	  	  
    </div><!-- /.box -->
  </div><!-- /.col-md-12 -->
 </div><!-- /.row -->
 
 </section><!-- /.content -->
</div><!-- /.content-wrapper -->