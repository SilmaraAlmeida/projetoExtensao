<?= formTitulo("Lista de Pessoas Físicas", true) ?>
<div class="m-2">

    <table class="table table-bordered table-striped table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">CPF</th>
                <th scope="col">Visitante ID</th>
                <th scope="col">Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($aDados as $value): ?>
                <tr>
                    <td><?= $value['pessoa_fisica_id'] ?></td>
                    <td><?= htmlspecialchars($value['nome']) ?></td>
                    <td>
                        <?php if (!empty($value['cpf'])): ?>
                            <?php
                            $cpf = $value['cpf'];
                            $cpfFormatado = strlen($cpf) == 11 ?
                                substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2) :
                                $cpf;
                            echo $cpfFormatado;
                            ?>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($value['visitante_id'])): ?>
                            <span class="badge bg-info"><?= $value['visitante_id'] ?></span>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= buttons('view', $value['pessoa_fisica_id'])  ?>
                        <?= buttons('update', $value['pessoa_fisica_id'])  ?>
                        <?= buttons('delete', $value['pessoa_fisica_id'])  ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>