<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
 <?php echo $cliente['nome'];?>
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $cliente['nome'] ;?></h4>
      </div>
      <div class="modal-body">
      
         Endere�o : <?php echo $cliente['endereco'].', '.$cliente['numero'].'/'.$cliente['complemento'];?> <br>
         Bairro : <?php echo $cliente['bairro']. ' || '.$cliente['cidade'] ;?><br>
         CEP : <?php echo $cliente['cep'];?><br>
         Telefone : <?php echo $cliente['telefone'] . ' || '.$cliente['celular']. ' || '.$cliente['contato'];?><br>
         Email : <?php echo $cliente['email'];?> Email Financeiro : <?php echo $cliente['email_financeiro'];?><br>
         CNPJ/CPF : <?php echo $cliente['cnpj']. ' || '.$cliente['cpf'] ;?><br>
         Restri�ao : <?php echo $cliente['restricao'];?><br>
     	           
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>