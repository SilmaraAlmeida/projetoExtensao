<?= formTitulo("UF") ?>

<div class="m-2">

    <form method="POST" action="<?= $this->request->formAction() ?>">

        <div class="row">
            <div class="col-2 mb-3">
                <label for="sigla" class="form-label">Sigla</label>
                <input type="text" class="form-control" 
                    id="sigla" 
                    name="sigla" 
                    placeholder="Sigla UF"
                    maxlength="2"
                    required
                    autofocus>
            </div>

            <div class="col-10 mb-3">
                <label for="nome" class="form-label">Descrição</label>
                <input type="text" class="form-control" 
                    id="nome" 
                    name="nome" 
                    placeholder="Nome da UF"
                    maxlength="50"
                    required>
            </div>
        </div>

        <?= formButton() ?>

    </form>

</div>