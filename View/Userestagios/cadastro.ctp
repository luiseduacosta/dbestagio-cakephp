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
    <?php echo $this->Form->input('numero', ['required', 'label' => ['text' => 'Número (DRE, SIAPE ou CRESS)', 'class' => 'col-lg-3 col-form-label']]); ?>
    <?php echo $this->Form->input('email', ['required', 'label' => ['text' => 'E-mail', 'class' => 'col-lg-3 col-form-label']]); ?>
    <?php echo $this->Form->input('password', ['required', 'label' => ['text' => 'Senha', 'class' => 'col-lg-3 col-form-label']]); ?>
    <?php echo $this->Form->input('Confirmar senha', ['required', 'label' => ['text' => 'Confirmar senha', 'class' => 'col-lg-3 col-form-label'], 'type' => 'password']); ?>
    <?php echo $this->Form->input('Confirmar', ['label' => false, 'type' => 'submit', 'class' => 'btn btn-success position-static']); ?>
    <?php echo $this->Form->end(); ?>

</div>
