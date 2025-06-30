<?= formTitulo("Lista de Usuários", true) ?>
<div class="m-2">

    <table class="table table-bordered table-striped table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Tipo</th>
                <th scope="col">Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($aDados as $value): ?>
                <tr>
                    <td><?= $value['usuario_id'] ?></td>
                    <td><?= $value['nome'] ?></td>
                    <td><?= $value['login'] ?></td>
                    <td><?= $value['tipo'] ?></td>
                    <td>
                        <?= buttons('view', $value['usuario_id'])  ?>
                        <?= buttons('update', $value['usuario_id'])  ?>
                        <?= buttons('delete', $value['usuario_id'])  ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>