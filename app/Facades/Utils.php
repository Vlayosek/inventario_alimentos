<?php
/**
 * Created by PhpStorm.
 * User: blacksato
 * Date: 14/5/2017
 * Time: 22:50
 */

namespace nextcore\Facades;


use Illuminate\Support\Collection;

class Utils
{
    public function getFormatDateSQL($date = true, $time = true)
    {
        if ($date && $time) {
            if (PHP_OS == "Linux") {
                return 'Y-m-d H:i:s';
            } else {
                return 'd/m/Y H:i:s.000';
                //return 'Y-m-d H:i:s.000';
            }

        } else if ($date) {
            if (PHP_OS == "Linux") {
                return 'Y-m-d';
            } else {
                return 'd/m/Y';
                //return 'Y-m-d';
            }
        } else {
            return 'H:i:s';
        }
    }

    public function parsearMenu($strXml, $fileXsl = "")
    {
        // Cargar el archivo XML
        $xml = new \DOMDocument;
        $xml->loadXML($strXml);

        // Cargar el archivo XSL
        $xsl = new \DOMDocument();
        $xsl->loadXML("$fileXsl");

        // Configurar el transformador
        $proc = new \XSLTProcessor;
        $proc->importStyleSheet($xsl); // incorporar las reglas xsl
        return $proc->transformToXML($xml);
    }

    public function getOptionSystem($arrayroles = array())
    {
        try {
            $array_options = array();
            if (count($arrayroles) < 1) {
                $arrayroles[] = 0;
            }
            $rsData = \DB::table('options as O')
                ->join('roles_option as OP', function ($join) use ($arrayroles) {
                    $join->on('O.id', '=', 'OP.option_id')
                        ->whereIn('OP.roles_id', $arrayroles);
                })->orderBy('O.prefix', 'asc')
                ->select('O.prefix', 'O.id', 'O.name',
                    'O.url', 'O.optionid as father',
                    'O.parameters',
                    "OP.option_id AS check",
                    'O.icons AS icons')->distinct()->get();

            foreach ($rsData as $data) {
                $array_options[$data->father == '' ? '0' : $data->father][$data->id] = array('prefix' => $data->prefix,
                    'id' => $data->id,
                    'name' => $data->name,
                    'url' => $data->url,
                    'father' => $data->father == '' ? 0 : $data->father,
                    'parameters' => $data->parameters,
                    'check' => $data->check == '' ? 'no' : 'si',
                    'icons' => $data->icons);

            }
            $xml_options = "<menus>";
            if (count($array_options) > 0) {
                foreach ($array_options[0] as $key => $value) {
                    $xml_options .= "<menu code='{$value['id']}' name='{$value['name']}' url='{$value['url']}' checked='{$value['check']}' parent='{$value['id']}' icono='{$value['icons']}'>";

                    if (array_key_exists($key, $array_options)) {
                        foreach ($array_options[$key] as $keyNode => $valueNode) {
                            Utils::getNodes($array_options, $key, $keyNode, $xml_options);
                        }
                    }
                    $xml_options .= "</menu>";
                }
            }
            $xml_options .= "</menus>";
            $options = $xml_options;
            return $options;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getOptionsRoles($rolesID, $join = false)
    {
        $array_options = array();
        $options = "";
        try {
            $array_options = array();
            if ($join) {
                $rsData = \DB::table('options as O')
                    ->leftJoin('roles_option as OP', function ($join) use ($rolesID) {
                        $join->on('O.id', '=', 'OP.option_id')
                            ->where('OP.roles_id', '=', $rolesID);
                    })->orderBy('O.prefix', 'asc')
                    ->select('O.prefix', 'O.id', 'O.name',
                        'O.url', 'O.optionid as father',
                        'O.parameters',
                        "OP.option_id AS check",
                        'O.icons AS icons')->get();
            } else {
                $rsData = \DB::table('options as O')
                    ->join('roles_option as OP', function ($join) use ($rolesID) {
                        $join->on('O.id', '=', 'OP.option_id')
                            ->where('OP.roles_id', '=', $rolesID);
                    })->orderBy('O.prefix', 'asc')
                    ->select('O.prefix', 'O.id', 'O.name',
                        'O.url', 'O.optionid as father',
                        'O.parameters',
                        "OP.option_id AS check",
                        'O.icons AS icons')->get();
            }

            foreach ($rsData as $data) {
                $array_options[$data->father == '' ? '0' : $data->father][$data->id] = array('prefix' => $data->prefix,
                    'id' => $data->id,
                    'name' => $data->name,
                    'url' => $data->url,
                    'father' => $data->father == '' ? 0 : $data->father,
                    'parameters' => $data->parameters,
                    'check' => $data->check == '' ? 'no' : 'si',
                    'icons' => $data->icons);

            }
            $xml_options = "<menus>";
            if (count($array_options) > 0) {
                foreach ($array_options[0] as $key => $value) {
                    $xml_options .= "<menu code='{$value['id']}' name='{$value['name']}' url='{$value['parameters']}' checked='{$value['check']}' parent='{$value['id']}' icono='{$value['icons']}'>";

                    if (array_key_exists($key, $array_options)) {
                        foreach ($array_options[$key] as $keyNode => $valueNode) {
                            Utils::getNodes($array_options, $key, $keyNode, $xml_options);
                        }
                    }
                    $xml_options .= "</menu>";
                }
            }
            $xml_options .= "</menus>";
            $options = $xml_options;

            return $options;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    private function getNodes($array_options, $parentID, $nodeID, &$xml_options)
    {
        $nodeName = $array_options[$parentID][$nodeID]['name'];
        $nodeParameter = $array_options[$parentID][$nodeID]['parameters'];
        $nodeSelected = $array_options[$parentID][$nodeID]['check'];
        $nodeCode = $array_options[$parentID][$nodeID]['id'];
        if (@count($array_options[$nodeID]) > 0) {
            $xml_options .= "<menuItem code='{$nodeCode}' name='{$nodeName}' url='{$nodeParameter}' checked='{$nodeSelected}' parent='{$parentID}' >";
            foreach ($array_options[$nodeID] as $key => $value) {
                Utils::getNodes($array_options, $nodeID, $key, $xml_options);
            }
            $xml_options .= "</menuItem>";
        } else {
            $xml_options .= "<menuItem code='{$nodeCode}' name='{$nodeName}' url='{$nodeParameter}' checked='{$nodeSelected}' parent='{$parentID}'></menuItem>";
        }
    }

    public  function getDateSQL($date = true, $time = true)
    {
        return date($this->getFormatDateSQL($date, $time));
    }
    public function getCollectionToSelectKeyValue(Collection $collection,$key ,$value )
    {
        $result=[];
        foreach ($collection as $item){
            $result[$item->$key]=$item->$value;
        }
        return $result;
    }

    public function getDataFormatWEBDatetimeSqln($date)
    {
        return (new \Datetime($date))->format( 'd/m/Y H:i:s');
    }

    function uniqidReal($lenght = 13) {
        // uniqid gives 13 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }

    public function getFormatArray($ini,$finish,$range){
        $arrayData=[];
        for ($i=$ini;$i<=$finish;$i+=$range){
            $arrayData[$i]=$i;
        }
        return $arrayData;
    }

    public  function getFormatDateDB($dateFull, $fdate = true, $ftime = true)
    {
        @list($date, $time) = explode(" ", $dateFull);

        if ($fdate && !$ftime) {
            return Utils::formatDBWEB($date);
        }

        if ($ftime &&  !$fdate) {
            return $time;
        }


        return Utils::formatDBWEB($date) . ' ' . $time;
    }

    public static function formatDBWEB($date)
    {
        if (trim($date) != '') {
            list($y, $m, $d) = explode("-", $date);
            $date = '';
            if (($d . $m . $y) != '') {
                $date = "$d/$m/$y";
            }
            return $date;
        } else {
            return '';
        }
    }

    public function getArrayKeyConvert($array, $key)
    {
        $arrayResult = [];

        foreach ($array as $item) {
            $arrayResult[$item[$key]] = $item;
        }
        return $arrayResult;
    }

    public  function getQuestionsSurveys($id)
    {
        return SurveyQuestion::where('status', '=', 'A')->where('survey_id', '=', $id)->count();

    }


    public static function buildSelectCustomAttrs($arrayFULL, $description, $keySelect, $class, $name,
                                                  $arrayValueATTR = [], $arraySelectATTR = [], $flag = false, $valueSelect = '')
    {
        $attrSelect = "";
        foreach ($arraySelectATTR as $key => $value) {
            $attrSelect .= " $key='$value' ";
        }
        $select = "<select $attrSelect class='$class' name='$name' id='$name'><option value='*'>** SELECCIONE ** </option>";
        foreach ($arrayFULL as $keyFull => $valueFull) {
            $optionAttr = "";
            foreach ($arrayValueATTR as $valueAttr) {
                $value = $flag == true ? @$valueFull->$valueAttr : @$valueFull[$valueAttr];
                $optionAttr .= "data-$valueAttr='" . $value . "' ";
            }
            $valueOpt = $flag == true ? @$valueFull->$keySelect : @$valueFull[$keySelect];
            $descriptionOpt = $flag == true ? trim(@$valueFull->$description) : trim(@$valueFull[$description]);
            if ($valueSelect != $valueOpt) {
                $select .= "<option value='$valueOpt' $optionAttr>$descriptionOpt</option>";
            } else {
                $select .= "<option value='$valueOpt' $optionAttr selected='selected'>$descriptionOpt</option>";
            }

        }
        $select .= "</select>";
        return $select;
    }

    public function getNumberAssignedHoursStudent($id_student)
    {
        return \DB::connection('sqlsrv_modulos')->table('Preprofesionales.projects_has_users as pu')
            ->where('pu.id_student', '=', $id_student)->where('pu.type', '=', 'PI')->select('number_hours_asigment')->first()->number_hours_asigment;
    }
}