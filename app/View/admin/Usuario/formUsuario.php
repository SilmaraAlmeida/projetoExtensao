<?= formTitulo("UF") ?>

<div class="m-2">

    <form method="POST" action="<?= $this->request->formAction() ?>">

        <div class="row">
            <div class="col-2 mb-3">
                <label for="sigla" class="form-label">Nome</label>
                <input type="text" class="form-control" 
                    id="nome" 
                    name="nome" 
                    placeholder="Nome"
                    maxlength="150"
                    required
                    autofocus>
            </div>

            <div class="col-10 mb-3">
                <label for="login" class="form-label">Email</label>
                <input type="text" class="form-control" 
                    id="login" 
                    name="login" 
                    placeholder="Email do Usuario"
                    maxlength="50"
                    required>
            </div>
        </div>
        
        <div class="row">
            <div class="col-2 mb-3">
                <label for="sigla" class="form-label">Nome</label>
                <input type="text" class="form-control" 
                    id="nome" 
                    name="nome" 
                    placeholder="Nome"
                    maxlength="150"
                    required
                    autofocus>
            </div>

            <div class="col-10 mb-3">
                <label for="login" class="form-label">Email</label>
                <input type="text" class="form-control" 
                    id="login" 
                    name="login" 
                    placeholder="Email do Usuario"
                    maxlength="50"
                    required>
            </div>
        </div>

        

        <?= formButton() ?>

    </form>

</div>