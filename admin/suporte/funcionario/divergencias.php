<head>
    <meta charset="iso-8859-1">
</head>

<?php 

	if ( function_exists( ProtUser ) ) {
		if ( !ProtUser( $_SESSION[ 'autUser' ][ 'id' ] ) ) {
			header( 'Location: painel.php?execute=suporte/403' );
		}
	}
	
	


	if(!isset($_SESSION['dataExtrato'])){
		
		$data1 = converteData1();
		$data2 = converteData2();
		$_SESSION['inicio']=$data1;
		$_SESSION['fim']=$data2;
		
	}else{
		
		$data1 = $_SESSION['inicio'];
		$data2 = $_SESSION['fim'];
		
	}

	if ( isset( $_POST[ 'relatorio-pdf' ] ) ) {
		
		$data1 = $_POST[ 'inicio' ];
		$data2 = $_POST[ 'fim' ];
		$divergencia = $_POST[ 'divergencia' ];
		$status = $_POST[ 'status' ];
		
		$_SESSION['inicio']=$data1;
		$_SESSION['fim']=$data2;
		$_SESSION['divergencia']=$divergencia;
		$_SESSION['status']=$status;
		
		echo '<script type="text/javascript">';
		echo 'window.open("painel.php?execute=suporte/relatorio/relatorio-funcionario-divergencia-pdf");';
		echo '</script>';
	}


	if ( isset( $_POST[ 'relatorio-excel' ] ) ) {
		
		$data1 = $_POST[ 'inicio' ];
		$data2 = $_POST[ 'fim' ];
		$divergencia = $_POST[ 'divergencia' ];
		$status = $_POST[ 'status' ];
		
		$_SESSION['inicio']=$data1;
		$_SESSION['fim']=$data2;
		$_SESSION['divergencia']=$divergencia;
		$_SESSION['status']=$status;
		
		header( 'Location: ../admin/suporte/relatorio/relatorio-funcionario-divergencia-excel.php' );
	}


	$total = conta('funcionario_divergencia',"WHERE id AND data_solicitacao>='$data1' AND data_solicitacao<='$data2' ORDER BY data_solicitacao ASC ");

	$leitura = read('funcionario_divergencia',"WHERE id AND data_solicitacao>='$data1' AND data_solicitacao<='$data2' ORDER BY data_solicitacao DESC, hora_solicitacao DESC");

	
	if(isset($_POST['pesquisar'])){
		
		$data1 = $_POST[ 'inicio' ];
		$data2 = $_POST[ 'fim' ];
		$divergencia = $_POST[ 'divergencia' ];
		$status = $_POST[ 'status' ];

		$total = conta('funcionario_divergencia',"WHERE id AND data_solicitacao>='$data1' AND data_solicitacao<='$data2' ORDER BY data_solicitacao ASC");
		$leitura = read('funcionario_divergencia',"WHERE id AND data_solicitacao>='$data1' AND data_solicitacao<='$data2' ORDER BY data_solicitacao ASC");
		
	}

	if(!empty($status)){
		$total = conta('funcionario_divergencia',"WHERE id AND data_solicitacao>='$data1' AND data_solicitacao<='$data2' AND status='$status'");
		$leitura = read('funcionario_divergencia',"WHERE id AND data_solicitacao>='$data1' AND data_solicitacao<='$data2' AND status='$status' ORDER BY data_solicitacao ASC");
	}
		

	if(!empty($divergencia)){
		$total = conta('funcionario_divergencia',"WHERE id AND data_solicitacao>='$data1' AND data_solicitacao<='$data2' AND id_divergencia='$divergencia'");
		$leitura = read('funcionario_divergencia',"WHERE id AND data_solicitacao>='$data1' AND data_solicitacao<='$data2' AND id_divergencia='$divergencia' ORDER BY data_solicitacao ASC");
	}
		
	if(!empty($status) && !empty($divergencia ) ){
		$total = conta('funcionario_divergencia',"WHERE id AND data_solicitacao>='$data1' AND data_solicitacao<='$data2' 
			AND status='$status' AND id_divergencia='$divergencia'");
		$leitura = read('funcionario_divergencia',"WHERE id AND data_solicitacao>='$data1' AND data_solicitacao<='$data2'
			AND status='$status' AND id_divergencia='$divergencia' ORDER BY data_solicitacao ASC");
	}


	$_SESSION[ 'url' ] = $_SERVER[ 'REQUEST_URI' ];

?>

<div class="content-wrapper">
	
  <section class="content-header">
       <h1>Divergencias</h1>
        <ol class="breadcrumb">
            <li>Home</a>
            <li>Funcionario</a>
            <li class="active">Divergencias</li>
          </ol>
 </section>

<section class="content">
	
  <div class="row">
   <div class="col-md-12">  
     <div class="box box-default">
		 
		 	<div class="box-header">       
                  <div class="col-xs-10 col-md-9 pull-right">
                     <form name="form-pesquisa" method="post" class="form-inline" role="form">
                       
                         <div class="form-group pull-left">
                            <input name="inicio" type="date" value="<?php echo date('Y-m-d',strtotime($data1)) ?>" class="form-control input-sm" >
                        </div><!-- /.input-group -->
                        <div class="form-group pull-left">
                            <input name="fim" type="date" value="<?php echo date('Y-m-d',strtotime($data2)) ?>" class="form-control input-sm" >
                        </div><!-- /.input-group -->
						 
						  <div class="form-group pull-left">
								<select name="divergencia" class="form-control input-sm">
									<option value="">Selecione a Divergecias</option>
									<?php 
										$readContrato = read('funcionario_divergencia_motivo',"WHERE id ORDER BY nome ASC");
										if(!$readContrato){
											echo '<option value="">Nao registro no momento</option>';	
											}else{
											foreach($readContrato as $mae):
												if($divergencia == $mae['id']){
														echo '<option value="'.$mae['id'].'"selected="selected">'.$mae['nome'].'</option>';
													 }else{
														echo '<option value="'.$mae['id'].'">'.$mae['nome'].'</option>';
													}
											endforeach;	
										}
									?> 
							    </select>
						   </div> 
						 
						  
						  <div class="form-group pull-left">
								<select name="status" class="form-control input-sm">
							  <option value="">Selecione Status</option>
							  <option <?php if($status== 'Aguardando') echo' selected="selected"';?> value="Aguardando">Aguardando</option>
							  <option <?php if($status == 'OK') echo' selected="selected"';?> value="OK">OK</option>
							 </select>
						</div><!-- /.row -->
                                         
                         <div class="form-group pull-left">
                         	<button class="btn btn-sm btn-default pull-right" type="submit" name="pesquisar" title="Pesquisar">
                        	 <i class="fa fa-search"></i></button>
                         </div><!-- /.input-group -->
                          
                         <div class="form-group pull-left">
                                <button class="btn btn-sm btn-default pull-right" type="submit" name="relatorio-pdf"><i class="fa fa-file-pdf-o" title="Relat�rio PDF"></i></button>
                         </div>  <!-- /.input-group -->
                            
                         <div class="form-group pull-left">
                                <button class="btn btn-sm btn-default pull-right" type="submit" name="relatorio-excel"><i class="fa fa-file-excel-o" title="Rela�rio Excel"></i></button>
                          </div>   <!-- /.input-group -->
                            
                    </form> 
					  
           </div><!-- /col-xs-10 col-md-7 pull-right-->
        </div> <!-- /.box-header -->
 	<div class="box-body table-responsive">
     
 <?php

	if($leitura){
				echo '<table class="table table-hover">
					<tr class="set">
					<td align="center">Id</td>
					<td align="center">Nome</td>
					<td align="center">Divergencia</td>
					<td align="center">Data</td>
					<td align="center">Solicitacao</td>
					<td align="center">Status</td>
					<td align="center">Solu��o</td>
					<td align="center">P/I</td>
					<td align="center" colspan="7">Gerenciar</td>
				</tr>';
		foreach($leitura as $mostra):
		 	echo '<tr>';
		
				echo '<td>'.$mostra['id'].'</td>';
	
				$funcionarioId = $mostra['id_funcionario'];
				$divergenciaId = $mostra['id_divergencia'];
				$funcionario = mostra('funcionario',"WHERE id ='$funcionarioId '");
		
				echo '<td>'.substr($funcionario['nome'],0,15).'</td>';
		
				$divergencia = mostra('funcionario_divergencia_motivo',"WHERE id ='$divergenciaId'");
				echo '<td>'.$divergencia['nome'].'</td>';
		
				echo '<td>'.converteData($mostra['data_solicitacao']).'</td>';

				echo '<td>'.substr($mostra['solicitacao'],0,25).'</td>';

				echo '<td>'.$mostra['status'].'</td>';
		
				echo '<td>'.substr($mostra['solucao'],0,25).'</td>';
		
				if($mostra['procedente']=='1'){
				  echo '<td>P</td>';
				}elseif($mostra['procedente']=='0'){
				 echo '<td>I</td>';
				}elseif($mostra['procedente']=='2'){
				 echo '<td>E</td>';
				}else{
				 echo '<td>-</td>';	
				}
		
				echo '<td align="center">
				<a href="painel.php?execute=suporte/funcionario/divergencia-editar&divergenciaVisualizar='.$mostra['id'].'">
			  				<img src="ico/visualizar.png" title="Visualizar" />
              			</a>
				      </td>';
		
				echo '<td align="center">
				<a href="painel.php?execute=suporte/funcionario/divergencia-editar&divergenciaDeletar='.$mostra['id'].'">
			  				<img src="ico/excluir.png" title="Excluir" />
              			</a>
				      </td>';
		
				echo '<td align="center">
				<a href="painel.php?execute=suporte/funcionario/divergencia-editar&divergenciaBaixar='.$mostra['id'].'">
			  				<img src="ico/baixar.png" title="Baixar"/>
              			</a>
				      </td>';
		
				// imprimir ordem
				echo '<td align="center">
						<a href="painel.php?execute=suporte/funcionario/divergenciaImprimir&divergencia='.$mostra['id'].'" target="_blank">
							<img src="ico/imprimir.png" title="Imprimir"  />
						</a>
					 </td>';	
		
				$pdf='../uploads/funcionarios/divergencia1/'.$mostra['id'].'.pdf';
				if(file_exists($pdf)){
					echo '<td align="center">
						<a href="../uploads/funcionarios/divergencia1/'.$mostra['id'].'.pdf" target="_blank">
							<img src="ico/pdf.png" alt="Comprovante" title="Comprovante" />
              			</a>
						</td>';	
				}else{
					echo '<td align="center">-</td>';	
				}
				$pdf='../uploads/funcionarios/divergencia2/'.$mostra['id'].'.pdf';
				if(file_exists($pdf)){
					echo '<td align="center">
						<a href="../uploads/funcionarios/divergencia2/'.$mostra['id'].'.pdf" target="_blank">
							<img src="ico/pdf.png" alt="Comprovante" title="Comprovante" />
              			</a>
						</td>';	
				}else{
					echo '<td align="center">-</td>';	
				}
		
				$pdf='../uploads/funcionarios/divergencia3/'.$mostra['id'].'.pdf';
				if(file_exists($pdf)){
					echo '<td align="center">
						<a href="../uploads/funcionarios/divergencia3/'.$mostra['id'].'.pdf" target="_blank">
							<img src="ico/pdf.png" alt="Comprovante" title="Comprovante" />
              			</a>
						</td>';	
				}else{
					echo '<td align="center">-</td>';	
				}
					
			echo '</tr>';
		 endforeach;
		echo '<tfoot>';
                        echo '<tr>';
                            echo '<td colspan="13">' . 'Total de Registros : ' .  $total . '</td>';
                        echo '</tr>';
                     echo '</tfoot>';
        
                 echo '</table>'; 

                }
           ?>

    </div><!-- /.box-body table-responsive -->
        <div class="box-footer">
            <?php echo $_SESSION['cadastro'];
			unset($_SESSION['cadastro']);
			?> 
       </div><!-- /.box-footer-->
    </div><!-- /.box -->
  </div><!-- /.col-md-12 -->
 </div><!-- /.row -->
</section><!-- /.content -->

</div><!-- /.content-wrapper -->
