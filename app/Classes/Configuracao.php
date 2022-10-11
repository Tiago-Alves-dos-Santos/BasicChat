<?php
namespace App\Classes;


define('PRODUCAO', false);
//tempo de desaparecimento do toast, false = permanente
define('TIME_TOAST',5000);
class Configuracao
{
    public static $LIMITE_PAGINA = 10;
    /**
     * [Description for isProduction]
     *
     * @return [type]
     *
     */
    public static function isProduction()
    {
        return PRODUCAO;
    }


    public static function setPathIntervetion($path)
    {
        $cliente_perfil = public_path()."/storage/user-perfil/";
        switch($path){
            case 'perfil':
                return $cliente_perfil;
            break;
            default:

            break;
        }
    }
    /**
     * [Description for getPathCliente]
     *
     * @param mixed $path
     *
     * @return [type]
     * exemplo de uso
     *  <img src="{{asset(Configuracao::getPath('perfil',true).'/'.$value->logo)}}" class="img-fluid"/>
     */
    public static function getPath($path, $front = false)
    {
        if($front){
            $cliente_perfil = 'storage/user-perfil';
        }else{
            $cliente_perfil = 'public/user-perfil';
        }
        switch($path){
            case 'perfil':
                return $cliente_perfil;
            break;
            default:

            break;
        }
    }


    //usado em conjunto com a função maskMoney javascript,
    //ele convert um formato mascarado em double do php que oq vai pro banco
	//caso realmente queira um double com casa decimais para calculos, faça -> (double)Configuracao::convertToMoney($valor)
    public static function convertToMoney($money)
    {
        $source = array('.', ',');
        $replace = array('', '.');
        return str_replace($source ,$replace,$money);
    }

    //ao pegar um dado do banco usamos o numero format para delimitar os decimais com ','
    //convert o dado do banco em money
    public static function getDbMoney($money)
    {
        return number_format($money, 2 ,',','.');
    }
	
	public static function excluirPosicaoVetor($posicao_excuir, $vetor) {
        unset($vetor[$posicao_excuir]);
        return array_values($vetor);
    }

    public static function validarCPF($cpf)
    {
        // Verifica se um número foi informado
        if(empty($cpf)) {
            return false;
        }

        // Elimina possivel mascara
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequências invalidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999') {
            return false;
        // Calcula os digitos verificadores para verificar se o
        // CPF é válido
        } else {

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    return false;
                }
            }

            return true;
        }
    }

    public static function calcIdade($data_nascimento)
    {

        $date = $data_nascimento;
    	$time = strtotime($date);
    	if($time === false){
            return 0;
        }
        $year_diff = '';
        $date = date('Y-m-d', $time);
        list($year,$month,$day) = explode('-',$date);
        $year_diff = date('Y') - $year;
        $month_diff = date('m') - $month;
        $day_diff = (date('d') - $day) * -1;
        if ($month_diff < 0 || ($month == date('m') && $day > date('d')) ){
            $year_diff--;

        }
        return $year_diff;
        //echo $year_diff." ".$month_diff." ".$day_diff;
    }

    public static function tipoAlerta($tipo)
    {
        switch ($tipo) {
            case 'error':
                return 0;
                break;
            case 'success':
                return 1;
                break;
            case 'warning':
                return 2;
                break;
            case 'info':
                return 3;
                break;
            case 'info-purple':
                return 4;
                break;
            case 'info-dark':
                return 5;
                break;

            default:
                throw new \Exception("Paramêtro 'tipo': $tipo, possui valor não reconhecido na função ");
                break;
        }
    }

}