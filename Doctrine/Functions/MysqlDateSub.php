<?php

namespace FXL\Component\Doctrine\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;

use Doctrine\ORM\Query\SqlWalker,
    Doctrine\ORM\Query\Lexer,
    Doctrine\ORM\Query\Parser;

/**
 * MysqlDateSubFunction ::=
 *     "MYSQL_DATE_SUB" "(" ArithmeticPrimary ", INTERVAL" ArithmeticPrimary Identifier ")"
 */
class MysqlDateSub extends FunctionNode
{
    public $firstDateExpression = null;
    public $intervalExpression = null;
    public $unit = null;

    /**
     * Parse the DQL
     *
     * @param \Doctrine\ORM\Query\Parser $parser
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->firstDateExpression = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_COMMA);
        $parser->match(Lexer::T_IDENTIFIER);

        $this->intervalExpression = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_IDENTIFIER);

        /* @var $lexer Lexer */
        $lexer = $parser->getLexer();
        $this->unit = $lexer->token['value'];

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * Return the SQL
     *
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'DATE_SUB(' .
        $this->firstDateExpression->dispatch($sqlWalker) . ', INTERVAL ' .
        $this->intervalExpression->dispatch($sqlWalker) . ' ' . $this->unit .
        ')';
    }
}
