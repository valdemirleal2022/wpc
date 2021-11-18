
	<?php 

		if(function_exists(ProtUser)){
			if(!ProtUser($_SESSION['autUser']['id'])){
				header('Location: painel.php?execute=suporte/403');	
			}	
		}
		
		if(!empty($_GET['agendaEditar'])){
			$agendaId = $_GET['agendaEditar'];
			$acao = "atualizar";
		}
		if(!empty($_GET['agendaDeletar'])){
			$agendaId = $_GET['agendaDeletar'];
			$acao = "deletar";
		}
		if(!empty($_GET['agendaBaixar'])){
			$agendaId = $_GET['agendaBaixar'];
			$acao = "baixar";
		}
		if(!empty($_GET['contratoId'])){
			$contratoId = $_GET['contratoId'];
			$acao = "cadastrar";
		}
		
		if(!empty($agendaId)){
			$readagenda = read('agenda',"WHERE id = '$agendaId'");
			if(!$readagenda){
				header('Location: painel.php?execute=suporte/naoencontrado');	
			}
			foreach($readagenda as $edit);
			$contratoId=$edit['id_contrato'];
			$clienteId = $edit['id_cliente'];
		}


		if(!empty($contratoId)){
			$contrato = mostra('contrato',"WHERE id = '$contratoId'");
			if(!$contrato){
				header('Location: painel.php?execute=suporte/naoencontrado');	
			}
			$clienteId = $contrato['id_cliente'];
			$cliente = mostra('cliente',"WHERE id = '$clienteId'");
			if(!$cliente){
				header('Location: painel.php?execute=suporte/naoencontrado');	
			}
		}


 ?>

 <div class="content-wrapper">
     <section class="content-header">
              <h1>Agenda </h1>
              <ol class="breadcrumb">
                <li><a href="painel.php?execute=painel"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="#">Cliente</a></li>
                <li><a href="#">Agenda</a></li>
                 <li class="active">Editar</li>
              </ol>
      </section>
	 <section class="content">
      <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><small><?php echo $cliente['nome'].' || '.$cliente['email'];?></small></h3>
                 
                 <div class="box-tools">
              	
            		<small>
            		 <?php if($acao=='cadastrar') echo 'Cadastrando';?>
                     <?php if($acao=='deletar') echo 'Deletando';?>
                     <?php if($acao=='atualizar') echo 'Alterando';?>
                    </small>
          		</div><!-- /box-tools-->
      	  </div><!-- /.box-header -->
     <div class="box-body">   
	<?php 
	
		if(isset($_POST['cadastrar'])){
			$cad['atendente'] = mysql_real_escape_string($_POST['atendente']);
			$cad['interacao'] = mysql_real_escape_string($_POST['interacao']);
			$cad['retorno'] = mysql_real_escape_string($_POST['retorno']);
			$cad['descricao'] = mysql_real_escape_string($_POST['descricao']);
			$cad['id_contrato'] = $contratoId;
			$cad['id_cliente'] = $clienteId;
			$cad['interacao']= date('Y/m/d H:i:s');
			$cad['status'] =1;
			if(empty($cad['retorno'])){
				$cad['status'] =2;	
			}
			create('agenda',$cad);	
			header("Location: ".$_SESSION['contrato-editar']);
		}
		
		if(isset($_POST['atualizar'])){
			$cad['atendente'] = mysql_real_escape_string($_POST['atendente']);
			$cad['retorno'] = mysql_real_escape_string($_POST['retorno']);
			$cad['descricao'] = mysql_real_escape_string($_POST['descricao']);
			$cad['interacao']= date('Y/m/d H:i:s');
			update('agenda',$cad,"id = '$agendaId'");	
			header("Location: ".$_SESSION['contrato-editar']);
		}
		if(isset($_POST['baixar'])){
			$cad['atendente'] = mysql_real_escape_string($_POST['atendente']);
			$cad['retorno'] = mysql_real_escape_string($_POST['retorno']);
			$cad['descricao'] = mysql_real_escape_string($_POST['descricao']);
			$cad['interacao']= date('Y/m/d H:i:s');
			$cad['status'] =2;
			update('agenda',$cad,"id = '$agendaId'");	
			header("Location: ".$_SESSION['contrato-editar']);
		}

		if(isset($_POST['deletar'])){
			delete('agenda',"id = '$agendaId'");
			header("Location: ".$_SESSION['contrato-editar']);
		}
		
		
	?>
	
  	<form name="formulario" action="" class="formulario" method="post" enctype="multipart/form-interacao">
    
            	<div class="form-group col-xs-12 col-md-3"> 
               		<label>Id</label>
              		<input name="id" type="text" value="<?php echo $edit['id'];?>" class="form-control" disabled /> 
                 </div><!-- /.col-md-12 -->
                 
                 <div class="form-group col-xs-12 col-md-3"> 
              		<label>Intera��o</label>
   					<input name="interacao" type="text" value="<?php echo date('d/m/Y H:i:s',strtotime($edit['interacao']));?>" class="form-control" readonly  /> 
                </div><!-- /.col-md-12 -->
           		
                <div class="form-group col-xs-12 col-md-3"> 
                    <label>Atendente </label>
                    <select name="atendente" <?php echo $disabled;?> class="form-control"/>
                            <option value="">Selecione o Atendente</option>
                                <?php 
                                    $leitura = read('contrato_atendente',"WHERE id ORDER BY nome ASC");
                                    if(!$leitura){
                                        echo '<option value="">N�o temos Atendente no momento</option>';	
                                    }else{
                                        foreach($leitura as $mae):
                                           if($edit['atendente'] == $mae['id']){
                                                echo '<option value="'.$mae['id'].'"selected="selected">'.$mae['nome'].'</option>';
                                             }else{
                                                echo '<option value="'.$mae['id'].'">'.$mae['nome'].'</option>';
                                            }
                                        endforeach;	
                                    }
                                ?> 
                    </select>
                 </div><!-- /.col-md-12 -->
                 
                 <div class="form-group col-xs-12 col-md-3"> 
                <label>Retorno:</label>
              		<input name="retorno" type="date" value="<?php echo $edit['retorno'];?>" class="form-control" /> 
			 	</div><!-- /.col-md-12 -->
                 
           		<div class="form-group col-xs-12 col-md-12"> 
               		<label>Descri��o</label>
              		<textarea name="descricao" cols="140" rows="5" class="form-control" /> <?php echo $edit['descricao'];?></textarea>
   				</div><!-- /.col-md-12 -->
   
            <div class="box-footer">
       		  <a href="javascript:window.history.go(-1)"><input type="button" value="Voltar" class="btn btn-warning"> </a>
          	  
           	  <?php 
                if($acao=="baixar"){
                    echo '<input type="submit" name="baixar" value="Baixar" class="btn btn-success" />';	
                }
				 if($acao=="atualizar"){
                    echo '<input type="submit" name="atualizar" value="Atualizar" class="btn btn-primary" />';
					echo '<input type="submit" name="deletar" value="Deletar"  class="btn btn-danger" />';		
                }
                if($acao=="deletar"){
                    echo '<input type="submit" name="deletar" value="Deletar"  class="btn btn-danger" />';	
                }
                if($acao=="cadastrar"){
                    echo '<input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-primary" />';	
                }
                if($acao=="enviar"){
                    echo '<input type="submit" name="enviar" value="Enviar" class="btn btn-primary" />';	
                }
             ?> 
              
          </div> 
		</form>
  	</div><!-- /.box-body -->
    </div><!-- /.box box-default -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
