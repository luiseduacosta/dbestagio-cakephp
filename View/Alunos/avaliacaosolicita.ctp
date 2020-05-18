<h1>Digite o seu número de DRE para solicitar o formulário de avaliação discente</h1>
<br />
<p>No processo de solicitação do formulário de avaliação discente será solicitado verificar e, se for necessário, completar a informação sobre o supervisor de campo. Os dados solicitaçãos são: Nome, Cress, telefone ou celular e e-mail. Todos os campos são obrigatórios.</p>
<br />
<p>Caso deseje mudar a instituição cadastrada como campo de estágio deve fazer uma nova solicitação de <?php echo $this->Html->link('termo de compromisso', '/Inscricoes/termosoliciata/'); ?>, selecionando a instituição e o supervisor. Feito isso, pode solicitar o formulário de avalição discente.</p>
<br />

<?php

echo $this->Form->create('Aluno');
echo $this->Form->input('registro', array('label'=>'Registro (DRE)', 'size'=>'9', 'maxlength'=>'9', 'default'=>$this->Session->read('numero')));
echo $this->Form->end('Confirma');

?>
