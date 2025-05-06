<?php

namespace Core\Library;

use Core\Library\Session;
use Exception;

class Files
{
    private $pathFile;
    private $allowedTypes = [];
    private $maxSize;

    /**
     * construct
     *
     * @param string $uploadPath 
     * @param array $allowedTypes 
     * @param int $maxSizeMB 
     */
    public function __construct(
        $uploadPath = '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR,
        array $allowedTypes = FILE_ALLOWEDTYPES,
        int $maxSizeMB = FILE_MAXSIZE
    ) {
        $this->pathFile = $uploadPath;
        $this->allowedTypes = $allowedTypes;
        $this->maxSize = $maxSizeMB * 1024 * 1024; // Converte MB para bytes
    }

    /**
     * Upload de arquivos
     *
     * @param array $arquivos
     * @param string $pasta
     * @param string $nomeArquivoAntigo (opcional)
     * @return array|false Retorna um array com os nomes dos arquivos ou false em caso de erro.
     * @throws Exception
     */
    public function upload(array $arquivos, string $pasta, string $nomeArquivoAntigo = ''): array|false
    {
        $diretorioUpload = $this->pathFile . $pasta . DIRECTORY_SEPARATOR;
        $arquivosUploadSucesso = [];
        $erros = [];

        if (!is_dir($diretorioUpload) && !mkdir($diretorioUpload, 0777, true)) {
            $erros[] = "Falha ao criar o diretório de upload: {$diretorioUpload}";
        }

        if (!is_writable($diretorioUpload)) {
            $erros[] = "O diretório de upload não tem permissões de escrita: {$diretorioUpload}";
        }

        if (!empty($erros)) {
            Session::set('msgError', implode('<br>', $erros));
            return false;
        }

        foreach ($arquivos as $arquivo) {
            if ($arquivo['error'] !== UPLOAD_ERR_OK) {
                $erros[] = "Erro no upload do arquivo: {$arquivo['name']}";
                continue;
            }

            if (!empty($this->allowedTypes) && !in_array($arquivo['type'], $this->allowedTypes)) {
                $erros[] = "Tipo de arquivo inválido: {$arquivo['name']}";
                continue;
            }

            if ($arquivo['size'] > $this->maxSize) {
                $erros[] = "Tamanho do arquivo excedido: {$arquivo['name']}";
                continue;
            }

            $nomeArquivo = uniqid() . '_' . pathinfo($arquivo['name'], PATHINFO_FILENAME) . '.' . pathinfo($arquivo['name'], PATHINFO_EXTENSION);
            $caminhoCompleto = $diretorioUpload . $nomeArquivo;

            if (!empty($nomeArquivoAntigo)) {
                $caminhoArquivoAntigo = $diretorioUpload . $nomeArquivoAntigo;
                if (file_exists($caminhoArquivoAntigo)) {
                    unlink($caminhoArquivoAntigo);
                }
            }

            if (!move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)) {
                $erros[] = "Falha ao mover o arquivo: {$arquivo['name']}";
                continue;
            }

            $arquivosUploadSucesso[] = $nomeArquivo;
        }

        if (!empty($erros)) {
            Session::set('msgError', implode('<br>', $erros));
            return false;
        }

        return $arquivosUploadSucesso;
    }

    /**
     * Deleta um arquivo
     *
     * @param string $nomeArquivo
     * @param string $pasta
     * @return bool
     */
    public function delete(string $nomeArquivo, string $pasta): bool
    {
        $caminhoCompleto = $this->pathFile . $pasta . DIRECTORY_SEPARATOR . $nomeArquivo;

        if (file_exists($caminhoCompleto)) {
            if (unlink($caminhoCompleto)) {
                return true;
            }
        }

        return false;
    }
}