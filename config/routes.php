<?php

/* Configuração de Rotas Alternativas da Aplicação */
$routes = array(
    "sobre" => "Index:sobre",
    "busca" => "Index:busca",
    "promocoes" => "Index:promocoes",

    //"cadastro" => "Cadastro:novo",
    "meus-dados" => "Cadastro:editar",

    //"meu-cadastro-salvar" => "Cadastro:gravar",
    //"meu-endereco-salvar" => "Local:gravar",

    "meus-enderecos" => "Local:lista",
    "novo-endereco" => "Local:novo",
    "editar-endereco" => "Local:editar",
    "cliente-remover-endereco" => "Local:remove",

    "meus-pedidos" => "Pedido:lista",
    "detalhes-do-pedido" => "Pedido:exibir",

    "pedido-ficha-cliente" => "Ficha:cliente",
    "pedido-ficha-admin" => "Ficha:admin",

    "entrar" => "loginCliente:indexAction",
    "sair" => "loginCliente:logout",
    "cliente-login-entrar" => "loginCliente:entrar",
    "recupera-senha" => "LoginCliente:recupera_senha",
    "nova-senha" => "LoginCliente:nova_senha",


    "configuracao-email" => "Smtp:indexAction",
    "configuracao-email-atualizar" => "Smtp:gravar",
);
