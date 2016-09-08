<?php
require_once("Kora.php");
use Lib\Kora;
use Lib\KORA_Clause;

class Advanced_Search extends Kora{

    protected $formulatedResult;
    private $clauses = array();
    private $final_clause;
    private $sid;

    function __construct($sid, $fields = 'ALL'){
        //call parent constructor 'kora'
        parent::__construct();

        $this->sid = $sid;
        $this->fields = $fields;
    }

    public function add_clause($query1, $query2, $query3) {
        array_push($this->clauses, new KORA_Clause($query1, $query2, $query3));
    }

    public function search () {
        //set up the kora search parameters for keyword search
        $this->final_clause = array_shift($this->clauses);
        foreach ($this->clauses as $clause) {
            $this->final_clause = new KORA_Clause($this->final_clause, "OR", $clause);
        }

        $this->token = TOKEN;
        $this->projectMapping = PID;
        $this->schemeMapping = $this->sid;
        $this->The_Clause = $this->final_clause;

        $this->formulatedResult = parent::search();

        return json_encode($this->formulatedResult);
    }
}
