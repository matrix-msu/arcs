<?php
require_once("Kora.php");
use Lib\Kora;
// use \App\FieldHelpers\KORA_Clause;

class Advanced_Search extends Kora{

    protected $formulatedResult;
    private $clauses = array();
    private $final_clause;
    private $sid;
	private $pid;

    function __construct($pid, $sid, $fields = 'ALL', $start = null, $limit = null, $sort = array()){
        //call parent constructor 'kora'
        parent::__construct();

        if( $start == 0 ){
            $start = null;
        }
        if( $limit == 0 ){
            $limit = null;
        }

        $this->pid = $pid;
        $this->sid = $sid;
        $this->start = $start;
        $this->fields = $fields;
        $this->end = $limit;
        $this->sortFields = $sort;
    }

    public function add_clause($query1, $query2, $query3) {
        array_push($this->clauses, new KORA_Clause($query1, $query2, $query3));
    }
    public function add_kora_clause($clause){
        array_push($this->clauses, $clause);
    }
    public function add_double_clause($query1, $query2, $query3, $query4, $query5, $query6) {
        $koraClause1 = new KORA_Clause($query1, $query2, $query3);
        $koraClause2 = new KORA_Clause($query4, $query5, $query6);
        array_push($this->clauses, new KORA_Clause($koraClause1, 'AND', $koraClause2));
    }
    public function add_double_clause_or($query1, $query2, $query3, $query4, $query5, $query6) {
        $koraClause1 = new KORA_Clause($query1, $query2, $query3);
        $koraClause2 = new KORA_Clause($query4, $query5, $query6);
        array_push($this->clauses, new KORA_Clause($koraClause1, 'OR', $koraClause2));
    }
    public function add_triple_clause($query1, $query2, $query3, $query4, $query5, $query6,$query7) {
        $koraClause1 = new KORA_Clause($query1, $query2, $query3);
        $koraClause2 = new KORA_Clause($query4, $query5, $query6);
        $koraClause3 = new KORA_Clause($query4, $query5, $query7);
        $koraClause4 = new KORA_Clause($koraClause2, "OR", $koraClause3);
        array_push($this->clauses, new KORA_Clause($koraClause1, 'AND', $koraClause4));
    }

    public function search () {
        //set up the kora search parameters for keyword search
        $this->final_clause = array_shift($this->clauses);
        foreach ($this->clauses as $clause) {
            $this->final_clause = new KORA_Clause($this->final_clause, "OR", $clause);
        }

        $pName = parent::getProjectNameFromPID($this->pid);
        $this->token = parent::getTokenFromProjectName($pName);
        $this->projectMapping = $this->pid;
        $this->schemeMapping = $this->sid;
        $this->The_Clause = $this->final_clause;


        // $this->formulatedResult = parent::search();
        parent::search_limited();
        // echo json_encode($this->comprehensive_results);die;
        return json_encode($this->comprehensive_results);
    }

    public function unformatted_search ($kidsNoData=false) {
        //set up the kora search parameters for keyword search
        $this->final_clause = array_shift($this->clauses);
        foreach ($this->clauses as $clause) {
            $this->final_clause = new KORA_Clause($this->final_clause, "OR", $clause);
        }

        $pName = parent::getProjectNameFromPID($this->pid);
        $this->token = parent::getTokenFromProjectName($pName);
        $this->projectMapping = $this->pid;
        $this->schemeMapping = $this->sid;
        $this->The_Clause = $this->final_clause;
        $this->kidsNoData = $kidsNoData;


        // $this->formulatedResult = parent::search();
        parent::search_limited();
        // echo json_encode($this->comprehensive_results);die;
        return $this->comprehensive_results;
    }
}
