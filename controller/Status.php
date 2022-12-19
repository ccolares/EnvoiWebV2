<?php

@session_start();

class Status
{
    static public function check($status)
    {
        $obj = new stdClass;
        $pat = ['/1/', '/2/', '/3/', '/4/', '/5/', '/6/'];
        $rep = [
            '<i class="fa fa-hourglass-o"></i> Pendente',
            '<i class="fa fa-hourglass-2"></i> Em Produção',
            '<i class="fa fa-motorcycle"></i>  Saiu para entrega',
            '<i class="fa fa-check-circle-o"></i> Entregue',
            '<i class="fa fa-remove"></i> Cancelado',
            '<i class="fa fa-check-circle-o"></i> Disponível para retirada',
        ];
        $txt = [
            'Pendente',
            'Em produção',
            'Saiu para entrega',
            'Entregue',
            'Cancelado',
            'Disponível para retirada',
        ];
        $obj->icon = preg_replace($pat, $rep, $status);
        $pat = ['/1/', '/2/', '/3/', '/4/', '/5/', '/6/'];
        $rep = ['warning', 'info', 'info', 'success', 'danger', 'success'];
        $obj->color = preg_replace($pat, $rep, $status);
        $obj->text = preg_replace($pat, $txt, $status);
        return $obj;
    }

    static public function pagseguro($status)
    {

        $obj = new stdClass;
        $pat = ['/0/','/1/', '/2/', '/3/', '/4/', '/5/', '/6/','/7/','/8/','/9/'];
        $rep = [
            '<i class="fa fa-money"></i> Não Utilizado',
            '<i class="fa fa-hourglass-o"></i> Aguardando pagamento',
            '<i class="fa fa-hourglass-2"></i> Em análise',
            '<i class="fa fa-check-circle-o"></i>  Pago',
            '<i class="fa fa-check-circle-o"></i> Disponível',
            '<i class="fa fa-remove"></i> Em disputa',
            '<i class="fa fa-remove"></i> Devolvida',
            '<i class="fa fa-remove"></i> Pagto Não Aprovado',
            '<i class="fa fa-check-circle-o"></i> Debitado',
            '<i class="fa fa-remove"></i> Retenção temporária',
        ];
        $txt = [
            'Não Utilizado',
            'Aguardando pagamento',
            'Em análise',
            'Pago',
            'Disponível',
            'Em disputa',
            'Devolvida',
            'Cancelada',
            'Debitado',
            'Retenção temporária',
        ];
        $obj->icon = preg_replace($pat, $rep, $status);
        $pat = ['/0/','/1/', '/2/', '/3/', '/4/', '/5/', '/6/','/7/','/8/','/9/'];
        $rep = ['','warning', 'info', 'success', 'success', 'danger', 'danger', 'danger', 'success', 'danger'];
        $obj->color = preg_replace($pat, $rep, $status);
        $obj->text = preg_replace($pat, $txt, $status);
        return $obj;
    }
}

