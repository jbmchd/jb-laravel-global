<?php

namespace JbGlobal\Traits;

use Illuminate\Http\UploadedFile;

trait TFile
{
    public static function salvarArquivo(UploadedFile $UploadedFile, $pasta = 'tmp', $unico=true, $s3=true)
    {
        if ($unico) {
            $file_name = self::criaNomeArquivoDatetime($UploadedFile);
        }

        if($s3){
            $path = $UploadedFile->storeAs($pasta, $file_name, 's3');
        }
        else {
            $path = $UploadedFile->storeAs('tmp', $file_name, 'local');
        }


        $retorno = [
            'pasta' => $pasta,
            'arquivo_nome' => $file_name,
            'caminho_storage' => $path,
        ];

        return $retorno;
    }

    public static function criaCaminho(...$partes)
    {
        $partes = array_filter($partes); //remove elementos null
        $caminho_completo = self::normalizarCaminho(implode(DIRECTORY_SEPARATOR, $partes));
        return $caminho_completo;
    }

    public static function normalizarCaminho($caminho)
    {
        return implode(DIRECTORY_SEPARATOR, explode('/', preg_replace('/\\\\/', '/', $caminho)));
    }

    public static function criaDiretorio($caminho)
    {
        if (! file_exists($caminho)) {
            mkdir($caminho, 0777, true);
        }
        return $caminho;
    }

    public static function criaNomeArquivoDatetime($file_name, $tem_extensao=true)
    {
        if ($file_name instanceof UploadedFile) {
            $file_name = $file_name->getClientOriginalName();
            $tem_extensao = true;
        }

        if ($tem_extensao) {
            $partes = explode('.', $file_name) ;
            $file_name = $partes[0];
            $extensao = $partes[1];
        }

        $file_name .= "__" . (new \Datetime())->format('YmdHisu');

        if ($tem_extensao) {
            $file_name .= ".$extensao";
        }

        return $file_name;
    }

    public static function getStorageTempFolder()
    {
        return self::criaCaminho(storage_path('app'), 'tmp');
    }

    public static function apagarDiretorioComArquivos($dir)
    {
        if (! file_exists($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? self::apagarDiretorioComArquivos("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    public static function extrairNomeArquivoDeCaminho($nome, $com_extensao=true)
    {
        $nome = self::normalizarCaminho($nome);
        $nome = explode(DIRECTORY_SEPARATOR, $nome);
        $nome = array_pop($nome);
        if ($com_extensao) {
            return $nome;
        } else {
            $nome = explode('.', $nome);
            return array_shift($nome);
        }
    }
}
