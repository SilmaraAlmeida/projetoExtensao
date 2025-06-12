<?php

namespace Core\Library;

class Validator 
{
    public static function make(array $data, array $rules)
    {
        $errors = null;

        foreach ($rules as $ruleKey => $ruleValue) {

            $itensRule = explode("|", $ruleValue['rules']);

            if (isset($data[$ruleKey])) {

                foreach ($itensRule as $itemKey) {

                        $items = explode(":", $itemKey);

                        switch ($items[0]) {

                            case 'required' :

                                if (($data[$ruleKey] == "") || (empty($data[$ruleKey]))) {
                                    $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> deve ser preenchido.";
                                }
                    
                                break;

                            case 'email' :

                                if (!filter_var($data[$ruleKey], FILTER_VALIDATE_EMAIL)){
                                    $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> não é válido.";
                                }

                                break;

                            case 'float' :

                                if (!filter_var($data[$ruleKey], FILTER_VALIDATE_FLOAT)){
                                    $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> deve conter número decimal.";
                                }

                                break;

                            case 'int' :

                                if (!filter_var($data[$ruleKey], FILTER_VALIDATE_INT)){
                                    $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> deve conter número inteiro.";
                                }

                                break;

                            case "min" :                    
                                
                                if (strlen(strip_tags($data[$ruleKey])) < $items[ 1 ] ){
                                    $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> dever conter um mínimo " . $items[ 1 ] . " caracteres.";
                                }

                                break;
                            
                            case 'max' :
                    
                                if (strlen(strip_tags($data[$ruleKey])) > $items[ 1 ] ){
                                    $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> dever conter um maximo " . $items[ 1 ] . " caracteres.";
                                }

                                break;
                            
                            case 'date' :

                                if (!validateDate($data[$ruleKey], 'Y-m-d')) {
                                    $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> está com o formato incorreto, formato esperado é Y-m-d";
                                }

                                break;

                            case 'datetime' :

                                if (!validateDate($data[$ruleKey], 'Y-m-d H:i:s')) {
                                    $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> está com o formato incorreto, formato esperado é Y-m-d";
                                }

                                break;
                                
                            default :
                                break;
                        }

                }
            } else {
                $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> é obrigatório [" . $data[$ruleKey] . "].";
            }
        }

        if ($errors) {                          // Se encontrar erros na validação
            Session::set('errors', $errors);
            Session::set('inputs', $data);
            return true;
        } else {
            Session::destroy('errors');
            Session::destroy('inputs');
            return false;
        }
    }
}