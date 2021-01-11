<?php
if (!session_id()) {
	session_start();
}
class Tool {
	public $name;
	public $sectionIndex;
	public $description;
	public $query;
	public $autoComplete;
}

$sections = array();
$sections[0] = 'Variables';
$sections[1] = 'Constants';
$sections[2] = 'Equations';
$sections[3] = 'Physicists';

$toolList = array();

$toolList[0] = new Tool();
$toolList[0]->name = 'By Symbol';
$toolList[0]->sectionIndex = 0;
$toolList[0]->description = 'Please enter the symbol of variable';
$toolList[0]->query = "SELECT q.name, q.unit, v.symbol FROM Quantities q, Variables v WHERE q.qid = v.vid AND v.symbol = ? ORDER BY q.name;";
$toolList[0]->autoComplete = "SELECT symbol FROM Variables GROUP BY symbol;";

$toolList[1] = new Tool();
$toolList[1]->name = 'By Name';
$toolList[1]->sectionIndex = 3;
$toolList[1]->description = 'Please enter the name of Physicist';
$toolList[1]->query = "SELECT name, nationality, birthYear, deathYear FROM Physicists WHERE name = ? ORDER BY Physicists.name;";
$toolList[1]->autoComplete = "SELECT name FROM Physicists;";

$toolList[2] = new Tool();
$toolList[2]->name = 'By Field';
$toolList[2]->sectionIndex = 2;
$toolList[2]->description = 'Please enter the name of field';
$toolList[2]->query = "SELECT e.name, e.field, e.latexCode, de.eqOrder, pe.eqDegree FROM Equations e LEFT JOIN Differential_equations de ON e.eqid = de.deid LEFT JOIN Polynomial_equations pe ON e.eqid = pe.peid WHERE e.field = ? ORDER BY e.field;";
$toolList[2]->autoComplete = "SELECT field FROM Equations GROUP BY field;";
