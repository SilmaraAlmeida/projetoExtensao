<?php
// EscolaridadeModel.php
namespace App\Model;

use Core\Library\ModelMain;

class EscolaridadeModel extends ModelMain
{
    protected $table = "escolaridade";
    protected $primaryKey = "escolaridade_id";

    public $validationRules = [];
}
