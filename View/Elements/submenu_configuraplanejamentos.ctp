<div class = "submenusuperior">
    <?php
    if (!empty($this->params['pass']['0'])) {
        echo $this->Html->link('Listar', '/configuraplanejamentos/index/', array('class' => 'aba'));
        echo " | ";
        echo $this->Html->link('Editar', '/configuraplanejamentos/edit/' . $this->params['pass']['0'], array('class' => 'aba'));
        echo " | ";
        echo $this->Html->link('Excluir', '/configuraplanejamentos/delete/' . $this->params['pass']['0'], array('class' => 'aba'), array('onClick' => 'return confirm ("Tem certeza?");'));
    } else {
        echo $this->Html->link('Listar', '/configuraplanejamentos/index/', array('class' => 'aba'));
        echo " | ";
        echo $this->Html->link('Inserir', '/configuraplanejamentos/add', array('class' => 'aba'));
    }
    ?>
    <?php // pr($this->params);   ?>
</div>