# Projeto Leitor de PDF

Este projeto é um leitor de PDF que extrai texto de arquivos PDF. Ele é construído em PHP e utiliza o Composer para gerenciar suas dependências. Além disso, o projeto tem a capacidade de implementar novas funcionalidades com a biblioteca ilovepdf.

## Como executar o projeto baixado

1. Verifique se o Composer está instalado corretamente na sua máquina. Para isso, execute o seguinte comando no terminal:
```bash
composer -v
```
2. Instale todas as dependências indicadas pelo arquivo `package.json` com o seguinte comando:
```bash
composer install
```

## Sequência para criar o projeto

1. Verifique se o Composer está instalado corretamente na sua máquina. Para isso, execute o seguinte comando no terminal:
```bash
composer -v
```
2. Crie o arquivo `composer.json` com o seguinte comando:
```bash
composer init
```
3. Baixe a biblioteca `smalot/pdfparser` utilizando o Composer para ler PDFs com o seguinte comando:
```bash
composer require smalot/pdfparser
```
4. Baixe a biblioteca `ilovepdf/ilovepdf-php` via Composer para a implementação de novas funcionalidades posteriormente com o seguinte comando:
```bash
composer require ilovepdf/ilovepdf-php
```

## Observações

O leitor de PDF funciona automaticamente. Basta inserir o arquivo que a leitura e extração de texto serão executadas automaticamente.
