<?= formTitulo('Lista de Usuários', true) ?>

<?= exibeAlerta() ?>

<?php if (count($aDados) > 0): ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table id="tblUsuarios" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nome
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($aDados as $value): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?= $value['usuario_id'] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?= $value['nome'] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?= $value['login'] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        <?php 
                                        switch($value['tipo']) {
                                            case 'G':
                                                echo 'bg-purple-100 text-purple-800';
                                                break;
                                            case 'A':
                                                echo 'bg-blue-100 text-blue-800';
                                                break;
                                            case 'CN':
                                                echo 'bg-green-100 text-green-800';
                                                break;
                                            default:
                                                echo 'bg-gray-100 text-gray-800';
                                        }
                                        ?>">
                                        <?php 
                                        switch($value['tipo']) {
                                            case 'G':
                                                echo 'Gestor';
                                                break;
                                            case 'A':
                                                echo 'Anunciante';
                                                break;
                                            case 'CN':
                                                echo 'Candidato';
                                                break;
                                            default:
                                                echo $value['tipo'];
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <?= buttons('view', $value['usuario_id']) ?>
                                        <?= buttons('update', $value['usuario_id']) ?>
                                        <?= buttons('delete', $value['usuario_id']) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?= datatables('tblUsuarios') ?>

<?php else: ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <i class="fas fa-users text-5xl text-gray-300 mb-4"></i>
            <p class="text-gray-600 text-lg font-medium mb-2">Nenhum usuário encontrado</p>
            <p class="text-gray-500 text-sm">Comece cadastrando o primeiro usuário do sistema</p>
        </div>
    </div>

<?php endif; ?>
