<?php
/*
Author: Austin RIx
*/
/*
 @class Kora
*/
/*
                    (project)
                    /     \
                  /        \
              (season)    ('')
              /     \
            /        \
  (excavation)   (excavation)
      |              |
      |              |
      |              |
(Resources ...) (Resources ...)

*/

namespace Lib;
use \AppController;


class Kora extends AppController{

    protected $token;
    protected $projectMapping;
    protected $schemeMapping;
    protected $The_Clause;
    protected $sortFields;
    protected $results_per_page;
    protected $comprehensive_results;
    protected $fields;
    protected $start;
    protected $end;

    function __construct(){

      if(!is_link(LIB . "Kora/search")){
            //Create Symbolic link to local kora_search
            symlink(KORA_SEARCH,LIB . "Kora/search");
      }
      require_once(LIB . "Kora/search");

      $this->token = TOKEN;
      $this->projectMapping = PID;
      $this->schemeMapping = PROJECT_SID;
      $this->fields = "ALL";
      $this->results_per_page = 100;
    }
    protected function search(){

        $this->comprehensive_results = KORA_Search(

            $this->token,
            $this->projectMapping,
            $this->schemeMapping,
            $this->The_Clause,
            $this->fields
        );
        if(is_array($this->comprehensive_results))
          return $this->comprehensive_results;
        else
          return array();

    }

    protected function search_limited(){

        $this->comprehensive_results = KORA_Search(

            $this->token,
            $this->projectMapping,
            $this->schemeMapping,
            $this->The_Clause,
            $this->fields,
            $this->sortFields,
            $this->start,
            $this->end
        );
        return $this->comprehensive_results;
    }
    protected function MPF(){

        $this->comprehensive_results = MPF_Search(
            $this->token,
            $this->projectMapping,
            $this->schemeMapping,
            $this->The_Clause,
            $this->fields,
            $this->sortFields
        );
        return $this->comprehensive_results;
    }
    // public setter functions to change
    // search parameters.
    public function setToken($string){
        $this->token = $string;
    }
    public function setProject($int){
        $this->projectMapping = $int;
    }
    public function setScheme($int){
        $this->schemeMapping = $int;
    }
    public function setFields($array){
        $this->fields = $array;
    }
    public function setClause($array){
        $this->The_Clause = $array;
    }
    public function setSortFields($array){
        $this->sortFields = $array;
    }

    public function print_json(){

        //start compression handler
        ob_start('ob_gzhandler');

        if(!empty($this->comprehensive_results)){
            echo json_encode($this->comprehensive_results);
        }
        else{
            echo json_encode(array("empty"));
        }

        //end compression
        ob_end_flush();
    }
    public static function to_json($array){
        return json_encode($array);
    }
  public function getResultsAsArray(){
    return $this->comprehensive_results;
  }
}




class KORA_Clause
{
	function __construct($argument1, $op, $argument2)
	{
		$this->arg1 = $argument1;
		$this->arg2 = $argument2;
		$this->operator = $op;
		if ((is_string($argument1) && is_string($argument2)) || ($op == 'IN' && is_array($argument2) && !empty($argument2)))
		{
			if (($op == 'IN') & !is_array($argument2))
			{
				$this->arg2 = array($this->arg2);
			}
			$this->clauseType = 'Logical';
		}
		else if (is_object($argument1) && is_object($argument2) && (in_array($op, array('AND', 'OR'))) )
		{
			$this->clauseType = 'Boolean';
		}
		else
		{
			$this->clauseType = 'Undefined';
		}
	}
	public function isGood()
	{
		return (in_array($this->clauseType, array('Logical', 'Boolean')));
	}
	//Returns an associative array of KIDs that meet the query's conditions.
	//If the query clause is logical, an sql query is executed to retrieve the
	//related id results.  Otherwise the clause is a boolean, so merge
	//the results of its left and right arguments appropriately
	public function queryResult($controlDictionary = array(), $projectID, $schemeID){

		global $db;
		$ret_array = array();


		// == operator should have the same functionality as the = operator in this situation.
		// mySQL only has the = operator.
		if($this->operator == "==")
		{
			$this->operator = "=";
		}
		$dataTable = "p$projectID"."Data";
		$query = "SELECT DISTINCT id FROM $dataTable WHERE schemeid = '$schemeID' AND ";
		if($this->clauseType == 'Logical'){
			if ($this->arg1 == 'ANY')
			{
				if ($this->operator == '=')
				{
					$query .= ' ((value '.$this->operator." '".$this->arg2."') OR ";
					$query .= ' (value LIKE \''.KORA_Clause::xmlFormatted($this->arg2, false).'\' ))';
				}
				else if (in_array($this->operator, array('!=', '<>')))
				{
					$query .= ' ((value '.$this->operator." '".$this->arg2."') AND ";
					$query .= ' (value NOT LIKE \''.KORA_Clause::xmlFormatted($this->arg2, false).'\' ))';
				}
				else
				{
					$query .= ' (value '.$this->operator." '".$this->arg2."') ";
				}
			}


			elseif (strtoupper($this->arg1) == 'KID')
			{
				// fix arg2 so that queries like kid != '' will work correctly.
//				if (empty($this->arg2)) $this->arg2 = "''";

				if ($this->operator == 'IN')
				{
					// escape the terms for use in the query
					foreach($this->arg2 as &$arg)
					{
						if ($arg[0] != "'" && $arg[1] != "'")
							$arg = "'".$arg."'";
					}
					$query .= ' (id IN ('.implode(',', $this->arg2).')) ';
				}
				else
				{
					$query .= ' (id '.$this->operator." '".$this->arg2."') ";
				}
			}
			elseif (isset($controlDictionary[$this->arg1]))
			{



				if (strtoupper($this->operator) == 'IN')
				{
					$query .= ' (cid = '.$controlDictionary[$this->arg1]['cid'];
					$query .= ' AND (';
					$i = 0;
					foreach($this->arg2 as $arg)
					{
						if ($i > 0) $query .= ' OR ';
						$query .= " value LIKE '";
						if ($controlDictionary[$this->arg1]['xmlPacked'])
						{
							$query .= KORA_Clause::xmlFormatted($arg, false);
						}
						else
						{
							$query .= $arg;
						}
						$query .= "'";
						$i++;
					}
					$query .= ')) ';
				}

				else
				{
					if ($this->operator == '=')
					{
						// handle XML-packed data fields
						if ($controlDictionary[$this->arg1]['xmlPacked'])
						{
							// We presume that people using exact operators realize
							// such operators don't care about things like %, so we just
							// throw the brackets right on the outside
							$query  .= ' (cid = '.$controlDictionary[$this->arg1]['cid'];
							if(!empty($this->arg2)){
								$query .= ' AND value LIKE \''.KORA_Clause::xmlFormatted($this->arg2, false)."') ";
							}else{
								// 'empty' xmlPacked controls will not have a row set in the db.
								$query .= ' AND id NOT IN (SELECT DISTINCT id FROM p'.$projectID.'Data WHERE cid='.$controlDictionary[$this->arg1]['cid'].') )';
							}
						}
						else
						{
							$query  .= ' (cid = '.$controlDictionary[$this->arg1]['cid'];
							$query .= ' AND value '.$this->operator." '".$this->arg2."') ";
						}
					}
					else if (in_array($this->operator, array('!=', '<>')))
					{
						$query  .= ' (cid = '.$controlDictionary[$this->arg1]['cid'];
						// handle XML-packed data fields
						if ($controlDictionary[$this->arg1]['xmlPacked'])
						{
							if(!empty($this->arg2)){
								// We presume that people using exact operators realize
								// such operators don't care about things like %, so we just
								// throw the brackets right on the outside
								$query .= ' AND value NOT LIKE \''.KORA_Clause::xmlFormatted($this->arg2, false)."') ";
							}else{
								// We can't check if xmlPacked controls are 'not empty' with the same method
								// because the generated string will look like "NOT LIKE '% ><%'",
								// which will match all xml with more than one tag in it.
								// Instead, we just check if the row exists because an 'empty'
								// control will not be set in the db.
								$query .=' )';
							}
						}
						else
						{
							$query .= ' AND value '.$this->operator." '".$this->arg2."') ";
						}
						// catch records where no data is filled in for that control
						if (empty($this->arg2))
						{
							$query  = $query.' OR ';
							$query .= ' id NOT IN (SELECT DISTINCT id FROM p'.$projectID.'Data WHERE cid='.$controlDictionary[$this->arg1]['cid'].')';
						}
					}
					else if (strtoupper($this->operator) == 'NOT LIKE')
					{
						// If they're using LIKE syntax we assume they know what they're doing
						// with percentage signs, brackets, etc. and don't alter it
						$query  .= ' ( cid = '.$controlDictionary[$this->arg1]['cid'];
						$query .= ' AND value NOT LIKE \''.$this->arg2."') ";
						// catch records where no data is filled in for that control
						if (empty($this->arg2))
						{
							$query = $query.' OR ';
							$query .= ' id NOT IN (SELECT DISTINCT id FROM p'.$projectID.'Data WHERE cid='.$controlDictionary[$this->arg1]['cid'].')';
						}

					}

                    else if(strtoupper($this->operator)=='LIKE'){
						//If it s LIKE. find a cid because it's control specific
						$controlQuery = "SELECT cid FROM p".$projectID."Control WHERE schemeid=".$schemeID." AND name = '$this->arg1'";
						$controlResult = $db->query($controlQuery)->fetch_assoc();
						//add specific cid for LIKE comparison to main query
						$query .='cid = "'.$controlResult['cid'].'" AND ';

						//Convert special chars to match the encoded values in the db.
						$encoded_keyword = preg_replace_callback('/[\x{80}-\x{10FFFF}]/u', function ($m) {
						$char = current($m);
						$utf = iconv('UTF-8', 'UCS-4', $char);
						return sprintf("&#x%s;", ltrim(strtoupper(bin2hex($utf)), "0"));
						}, $this->arg2);

						$query .= ' (value LIKE '.escape($this->arg2).' OR value LIKE '.escape($encoded_keyword).') ';


                    }

					else // we assume they're using something else where
					{    // they know what they're doing

						$query .= ' (cid = '.$controlDictionary[$this->arg1]['cid'];
						$query .= ' AND value '.$this->operator." '".$this->arg2."') ";

					}

				}
			}
			else
			{
				echo gettext('Unknown control').': '.$this->arg1."<br/>\n";
//				echo "<pre>",print_r(array_keys($controlDictionary)),"</pre>";
				$query .= '(1=1)';
			}

			//If clause is logical, execute the mysql query
//			echo "<br>$query<br><br>";
			$result = $db->query($query);
			if (!$result){
				echo "query: $query<br>";
				echo $db->error."<br><br />";
				echo "Query Error, please check your KORA Clauses.<br/>";
			}else{
				while($r = $result->fetch_assoc()){
					$ret_array[] = "'".$r['id']."'";
				}
			}
//			echo "<pre>";print_r($ret_array);echo "</pre>";
		}
		else if ($this->clauseType == 'Boolean')
		{
			//To do an array union, merge the arrays then remove duplicates
			if ($this->operator != 'AND')
			{
				$array_left = $this->arg1->queryResult($controlDictionary, $projectID, $schemeID);
				$array_right = $this->arg2->queryResult($controlDictionary, $projectID, $schemeID);
				$ret_array = array_merge($array_left, $array_right);
				$ret_array =  array_unique($ret_array);
			}
			//An and of results is just an intersection of the id results
			else
			{
				$array_left = $this->arg1->queryResult($controlDictionary, $projectID, $schemeID);
				$array_right = $this->arg2->queryResult($controlDictionary, $projectID, $schemeID);
				$ret_array = array_intersect($array_left, $array_right);
			}
		}
		else
		{
			echo gettext('Error').': '.gettext('Bad Search Clause')."<br/>\n";
//			echo "arg1: ",var_dump($this->arg1),"<br>";
//			echo "op: ",var_dump($this->operator),"<br>";
//			echo "arg2: ",var_dump($this->arg2),"<br>";
		}
		return $ret_array;
	}
	private function xmlFormatted($arg, $operatorIsLIKE)
	{
		if ($operatorIsLIKE)
		{
			if (in_array($arg[0], array('%', '_')))
			{
				$arg = $arg[0].'>'.substr($arg, 1);
			}
			else
			{
				$arg = '>'.$arg;
			}
			if (in_array($arg[strlen($arg) - 1], array('%', '_')))
			{
				$arg = substr($arg, 0, strlen($arg) - 1).'<'.substr($arg, -1, 1);
			}
			else
			{
				$arg = $arg.'<';
			}
		}
		else
		{
			$arg = '%>'.$arg.'<%';
		}
		return $arg;
	}
	private $arg1;
	private $operator;
	private $arg2;
	private $clauseType;
}
