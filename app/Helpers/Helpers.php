<?php

namespace App\Helpers;

use App\Models\CategoriaConta;
use App\Models\ContaCorrente;
use App\Models\FormaPagamento;
use App\Models\Supplier;
use Faker\Core\Number;
use Illuminate\Support\Str;

class Helpers
{
    public static function formata_cpf_cnpj($cpf_cnpj)
    {
        /*
            Pega qualquer CPF e CNPJ e formata

            CPF: 000.000.000-00
            CNPJ: 00.000.000/0000-00
        */

        ## Retirando tudo que não for número.
        $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);
        $tipo_dado = NULL;
        if(strlen($cpf_cnpj)==11){
            $tipo_dado = "cpf";
        }
        if(strlen($cpf_cnpj)==14){
            $tipo_dado = "cnpj";
        }
        switch($tipo_dado){
            default:
                $cpf_cnpj_formatado = "";
                break;

            case "cpf":
                $bloco_1 = substr($cpf_cnpj,0,3);
                $bloco_2 = substr($cpf_cnpj,3,3);
                $bloco_3 = substr($cpf_cnpj,6,3);
                $dig_verificador = substr($cpf_cnpj,-2);
                $cpf_cnpj_formatado = $bloco_1.".".$bloco_2.".".$bloco_3."-".$dig_verificador;
                break;

            case "cnpj":
                $bloco_1 = substr($cpf_cnpj,0,2);
                $bloco_2 = substr($cpf_cnpj,2,3);
                $bloco_3 = substr($cpf_cnpj,5,3);
                $bloco_4 = substr($cpf_cnpj,8,4);
                $digito_verificador = substr($cpf_cnpj,-2);
                $cpf_cnpj_formatado = $bloco_1.".".$bloco_2.".".$bloco_3."/".$bloco_4."-".$digito_verificador;
                break;
        }
        return $cpf_cnpj_formatado;
    }

    public static function formata_cep ($string)
    {
        $string = preg_replace("[^0-9]", "", $string);
        $cep_formatado = substr($string, 0, 5) . '-' . substr($string, 5, 3);

        return $cep_formatado;
    }

    public static function setProposalNumber ($id)
    {
        $proposal_number = Str::padLeft($id, 9, '0');

        $proposal_array = str_split($proposal_number, 3);

        $proposal_number = $proposal_array[0].'.'.$proposal_array[1].'.'.$proposal_array[2];

        return $proposal_number;
    }

    public static function unmask_input($mask)
    {
        return preg_replace('/[^0-9]/', '', $mask);
    }

    public static function arrayToUpper(array $array)
    {
        

        array_walk($array, function(&$value)
        {
            
            if (gettype($value) === "string") {
                $value = mb_strtoupper($value, 'UTF-8');
            }
            
        });

        return $array;
    }

    public static function formataTelefone($numero)
    {
        if ($numero != null) {
            if(strlen($numero) == 10){
                $novo = substr_replace($numero, '(', 0, 0);
                $novo = substr_replace($novo, '-', 7, 0);
                $novo = substr_replace($novo, ') ', 3, 0);
            }else{
                $novo = substr_replace($numero, '(', 0, 0);
                $novo = substr_replace($novo, '-', 8, 0);
                $novo = substr_replace($novo, ') ', 3, 0);
            }

            return $novo;
        } else {
            return null;
        }
        
    }

    public static function getCpfCnpj($data, $table)
    {
        
        switch ($table) {
            case 'partners':

                if ($data->person_type_id == 1) {

                    if ($data->pf_partner->count() != 0) {
                        return $data->pf_partner[0]->cpf;
                    } 
        
                } else if ($data->person_type_id == 2) {
        
                    if ($data->pj_partner->count() != 0) {
                        return $data->pj_partner[0]->cnpj;
                    } 
        
                } else {
        
                    return null;
        
                }

                break;

            case 'customers':
                
                if ($data->person_type_id == 1) {

                    if ($data->pf_customer->count() != 0) {
                        return $data->pf_customer[0]->cpf;
                    } 
        
                } else if ($data->person_type_id == 2) {

                    if ($data->pj_customer->count() != 0) {
                        return $data->pj_customer[0]->cnpj;
                    } 
        
                    
        
                } else {
        
                    return null;
        
                }

                break;

            case 'suppliers':
                
                if ($data->person_type_id == 1) {

                    if ($data->pf_supplier->count() != 0) {
                        return $data->pf_supplier[0]->cpf;
                    } 
        
                } else if ($data->person_type_id == 2) {

                    if ($data->pj_supplier->count() != 0) {
                        return $data->pj_supplier[0]->cnpj;
                    } 
        
                } else {
        
                    return null;
        
                }

                break;
            
            default:

                return null;

                break;
        }
        
    }

    public static function getDescricaoReceber ($data, $parcela_atual = 1)
    {
        
        $categoria = CategoriaConta::find($data['categoria_conta_id']);
        $pagamento = FormaPagamento::find($data['forma_pagamento_id']);
        $conta = ContaCorrente::find($data['conta_corrente_id']);
        
        $descricao = trim($data['customer_nome']) . ' | ' . 
                        'PARCELA: ' . $parcela_atual . ' DE ' . $data['qtd_parcelas'] . ' | ' .
                        'PEDIDO Nº: ' . $data['order_id'] . ' | ' .
                        $categoria->nome . ' | ' .
                        $pagamento->nome . ' | ' .
                        $conta->banco . ' (AG:' . $conta->agencia . ' - CC:' . $conta->conta . ') | ' .
                        'DOCUMENTO: ' . $data['documento'] . ' | ' . 
                        'OUTRAS OBSERVAÇÕES: ' . trim($data['observacoes']);
        
        return $descricao;
    }

    public static function getDescricaoPagar ($data, $parcela_atual = 1)
    {
        
        $categoria = CategoriaConta::find($data['categoria_conta_id']);
        $pagamento = FormaPagamento::find($data['forma_pagamento_id']);
        $conta = ContaCorrente::find($data['conta_corrente_id']);
        $fornecedor = Supplier::find($data['supplier_id']);
        
        $descricao =    $fornecedor->nome . ' | ' . 
                        'PARCELA: ' . $parcela_atual . ' DE ' . $data['qtd_parcelas'] . ' | ' .
                        $categoria->nome . ' | ' .
                        $pagamento->nome . ' | ' .
                        $conta->banco . ' (AG:' . $conta->agencia . ' - CC:' . $conta->conta . ') | ' .
                        'DOCUMENTO: ' . $data['documento'] . ' | ' . 
                        'OUTRAS OBSERVAÇÕES: ' . trim($data['observacoes']);
        
        return $descricao;
    }

    public static function getRealCurrency ($amount)
    {
        
        return 'R$' . number_format($amount, 2, ',', '.');
    }

}
