<?php
function obterStatusInfo($status): array
{
    return match ((int)$status) {
        1 => ['texto' => 'Pré Vaga', 'class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fas fa-clock'],
        11 => ['texto' => 'Em Aberto', 'class' => 'bg-green-100 text-green-800', 'icon' => 'fas fa-check-circle'],
        91 => ['texto' => 'Suspensa', 'class' => 'bg-red-100 text-red-800', 'icon' => 'fas fa-pause-circle'],
        99 => ['texto' => 'Finalizada', 'class' => 'bg-gray-100 text-gray-800', 'icon' => 'fas fa-times-circle'],
        default => ['texto' => 'Status Desconhecido', 'class' => 'bg-gray-100 text-gray-800', 'icon' => 'fas fa-question-circle'],
    };
}

function obterVinculoInfo($vinculo): array
{
    return match ((int)$vinculo) {
        1 => ['texto' => 'CLT', 'icon' => 'fas fa-file-contract'],
        2 => ['texto' => 'Pessoa Jurídica', 'icon' => 'fas fa-building'],
        default => ['texto' => 'Não Informado', 'icon' => 'fas fa-question'],
    };
}

function obterModalidadeInfo($modalidade): array
{
    return match ((int)$modalidade) {
        1 => ['texto' => 'Presencial', 'icon' => 'fas fa-building', 'color' => 'purple'],
        2 => ['texto' => 'Remoto', 'icon' => 'fas fa-laptop', 'color' => 'blue'],
        default => ['texto' => 'Não Informado', 'icon' => 'fas fa-question', 'color' => 'gray'],
    };
}