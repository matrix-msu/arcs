<?php
require_once("Keyword_Search.php");
require_once("Resource.php");

use Lib\Kora\Keyword_Search;
use Lib\Resource;

// use App\FieldHelpers\KORA_Clause;

class Resource_Search extends Keyword_Search
{


    function __construct($array, $projectName, $advancedSearch = true)
    {
        //call parent constructor 'kora'
        parent::__construct();
        $this->advancedSearch = $advancedSearch;
        $time_start = microtime(true);
        $mem_start = memory_get_usage();

        $this->projectMapping = parent::getPIDFromProjectName($projectName);
        $this->schemeMapping = parent::getResourceSIDFromProjectName($projectName);

        $fields = array('Title', 'Type', 'Excavation_-_Survey_Associator', 'Season_Associator', 'Permissions', 'Special_User', 'Resource_Identifier', 'linkers');
        $pid = parent::getPIDFromProjectName($projectName);
        $sid = parent::getResourceSIDFromProjectName($projectName);
        $tempFields = array();
        $fieldExt = '_' . $pid . '_' . $sid . '_';
        foreach ($fields as $index => $field) {
            $tempFields[$index] = $fields[$index] . $fieldExt;
        }
        $query = array(
            'forms' => json_encode(array(
                array(
                    'form' => parent::getResourceSIDFromProjectName($projectName),
                    'token' => parent::getTokenFromProjectName($projectName),
                    'fields' => $tempFields,
                    'query' => array(
                        array(
                            'search' => 'kid',
                            'kids' => $array
                        )
                    )
                )
            ))
        );

        if(!$advancedSearch){
            $formQ = json_decode($query['forms'], true);
            $formQ[0]['meta'] = true;

            $query = array(
                'forms' => json_encode($formQ)
            );
        }

        $url = KORA_RESTFUL_URL . 'search';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $resource = curl_exec($ch);
        curl_close($ch);
        $this->formulatedResult = array();

        $records = json_decode($resource, true)['records'][0];

        if (!is_array($records)){
            $records = array();
        }
        foreach ($records as $kid => $value) {
            $template = array(
                'Title' => '',
                'Type' => '',
                'Excavation_-_Survey_Associator' => '',
                'Season_Associator' => '',
                'Permissions' => '',
                'Special_User' => '',
                'Resource_Identifier' => '',
                'reverseAssociations' => ''

            );
            foreach ($fields as $field) {
                if (isset($value[$field . $fieldExt])) {
                    $template[$field] = $value[$field . $fieldExt]['value'];
                }
                elseif (isset($value['reverseAssociations'])) {
                    $template[$field] = $value['reverseAssociations'];
                }
                else {
                    unset($template[$field]);
                }
            }
            $template['kid'] = $kid;
            $this->formulatedResult[$kid] = $template;
        }
        unset($resource);

        // traverse the database to include excavation,
        // season and project associations;
        $this->traverse_insert($projectName);

        // get resource filters
        $filters = Resource::filter_analysis($this->formulatedResult);
        //get indicators
        $indicators = Resource::flag_analysis($this->formulatedResult);

        $this->adjust_requested_limits(1, 100000000);

        $time_end = microtime(true);
        $mem_end = memory_get_usage();
        $time = $time_end - $time_start;
        $total_mem = ($mem_end - $mem_start) / pow(10, 9);

        //format and prepare for a json response
        $this->format_results($time, $total_mem, $filters, $indicators);

    }


}
