<?php ?>
<script>

    $(document).ready(function () {
        $("#UserestagioCategoria").change(function () {

            var categoria = $(this).val();

            if (categoria == 2) {
                $("label:eq(1)").text("DRE");
            } else if (categoria == 3) {
                $("label:eq(1)").text("SIAPE");
            } else if (categoria == 4) {
                $("label:eq(1)").text("CRESS 7ª Região");
            }

        })
    })
</script>

<div class="container">

    <?php
    echo $this->Form->create("Userestagio", ['inputDefaults' => [
            'div' => ['class' => 'form-group row'],
            'label' => ['class' => 'col-lg-3 col-form-label'],
            'between' => '<div class = "col-lg-9">',
            'after' => '</div>',
            'class' => 'form-control']
    ]);
    ?>
    
    <h5>Cadastro de usuário</h5>

    <?php echo $this->Form->input('categoria', ['label' => ['text' => 'Segmento', 'class' => 'col-lg-3 col-form-label'], 'options' => ['9' => '- Selecione -', '2' => 'Estudante', '3' => 'Professor', '4' => 'Supervisor'], 'default' => '9']); ?>
    <?php echo $this->Form->input('numero', ['label' => ['text' => 'Número (DRE, SIAPE ou CRESS)', 'class' => 'col-lg-3 col-form-label']]); ?>
    <?php echo $this->Form->input('email', ['label' => ['text' => 'E-mail', 'class' => 'col-lg-3 col-form-label']]); ?>
    <?php echo $this->Form->input('password', ['label' => ['text' => 'Senha', 'class' => 'col-lg-3 col-form-label']]); ?>
    <?php echo $this->Form->input('Confirmar senha', ['label' => ['text' => 'Confirmar senha', 'class' => 'col-lg-3 col-form-label'], 'type' => 'password']); ?>
    <?php echo $this->Form->input('Enviar', ['label' => false, 'type' => 'submit', 'class' => 'btn btn-primary position-static']); ?>
    <?php echo $this->Form->end(); ?>

</div>
