<?= formTitulo("Lista de Telefones", true) ?>
<div class="m-2">

    <table class="table table-bordered table-striped table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Número</th>
                <th scope="col">Tipo</th>
                <th scope="col">Estabelecimento</th>
                <th scope="col">Usuário</th>
                <th scope="col">Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($aDados as $value): ?>
                <tr>
                    <td><?= $value['telefone_id'] ?></td>
                    <td>
                        <?php 
                        $numero = $value['numero'];
                        if (strlen($numero) == 11) {
                            // Celular: (32) 99999-9999
                            $numeroFormatado = '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 5) . '-' . substr($numero, 7, 4);
                        } else if (strlen($numero) == 10) {
                            // Fixo: (32) 3333-3333
                            $numeroFormatado = '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 4) . '-' . substr($numero, 6, 4);
                        } else {
                            $numeroFormatado = $numero;
                        }
                        echo $numeroFormatado;
                        ?>
                    </td>
                    <td>
                        <?php if ($value['tipo'] == 'm'): ?>
                            <span class="badge bg-primary">
                                <i class="fas fa-mobile-alt me-1"></i>Móvel
                            </span>
                        <?php else: ?>
                            <span class="badge bg-secondary">
                                <i class="fas fa-phone me-1"></i>Fixo
                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($value['estabelecimento_nome'])): ?>
                            <strong><?= htmlspecialchars($value['estabelecimento_nome']) ?></strong>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($value['usuario_nome'])): ?>
                            <?= htmlspecialchars($value['usuario_nome']) ?>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= buttons('view', $value['telefone_id'])  ?>
                        <?= buttons('update', $value['telefone_id'])  ?>
                        <?= buttons('delete', $value['telefone_id'])  ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
