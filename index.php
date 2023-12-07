<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>LEITOR - Upload e Ler PDF</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>

    <div class="container">
        <h2>Ler Arquivo PDF</h2>

        <form id="upload-form" method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file-input">Arquivos PDF:</label>
                <input type="file" id="file-input" name="arquivos[]" accept="application/pdf" multiple>
            </div>

            <div class="alert alert-warning" role="alert">
                Para seleção de múltiplos arquivos, pressione a tecla CTRL e selecione os arquivos.
            </div>

            <div class="form-group">
                <label for="texto">Texto extraído:</label>
                <textarea id="texto" name="texto" rows="10" cols="190" readonly></textarea>
            </div>

        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Quando o usuário selecionar um arquivo, envie o formulário
            $('#file-input').change(function() {
                $('#upload-form').submit();
            });
        });
    </script>

    <?php
    require 'vendor/autoload.php'; // Carrega o autoload do Composer

    function smartAlert($mensagem, $tipo)
    {
        // Mapeia o tipo 'danger' para 'error' para usar o ícone correto
        $tipo = ($tipo === 'danger') ? 'error' : $tipo;

        // Exibe um alerta usando SweetAlert2
        echo "<script>Swal.fire({icon: '$tipo', title: '$mensagem', showConfirmButton: false, timer: 2000});</script>";
        error_log($tipo . ': ' . $mensagem);
    }

    function processarFormulario()
    {
        $arquivos = $_FILES['arquivos'];

        foreach ($arquivos['tmp_name'] as $key => $tmp_name) {
            if ($arquivos['type'][$key] != 'application/pdf') {
                throw new Exception("Erro: Necessário enviar arquivo PDF!");
            } else {
                $nome_original = $arquivos['name'][$key];
                $caminho_upload = "arquivos/";

                if (!file_exists($caminho_upload) && !mkdir($caminho_upload) && !is_dir($caminho_upload)) {
                    throw new Exception("Erro: Falha ao criar o diretório de upload.");
                }

                if (move_uploaded_file($tmp_name, $caminho_upload . $nome_original)) {
                    $texto_extraido = lerPDF($caminho_upload . $nome_original, $nome_original);
                    if ($texto_extraido === false) {
                        throw new Exception("Erro: Não foi possível extrair o texto do arquivo.");
                    }
                    echo "<script>document.getElementById('texto').value += " . json_encode($texto_extraido) . ";</script>";
                    unlink($caminho_upload . $nome_original);
                } else {
                    throw new Exception("Erro: Arquivo não enviado!");
                }
            }
        }
    }

    function lerPDF($caminho_arquivo, $nome_arquivo)
    {
        require_once 'vendor/autoload.php'; // Composer autoload

        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($caminho_arquivo);

        $pages = $pdf->getPages();
        $texto_extraido = '';

        foreach ($pages as $numero_pagina => $page) {
            $numero_pagina++;
            $texto_extraido .= "PDF: $nome_arquivo, Página $numero_pagina :\n";
            $texto_extraido .= $page->getText() . "\n\n";
        }

        return $texto_extraido;
    }

    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            processarFormulario();
            smartAlert("Arquivo(s) enviado(s) com sucesso!", "success");
        }
    } catch (Exception $e) {
        smartAlert($e->getMessage(), "danger");
    }

    ?>
</body>

</html>