<?php

namespace FXL\Component\Doctrine\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;

use Doctrine\ORM\Query\SqlWalker,
    Doctrine\ORM\Query\Lexer,
    Doctrine\ORM\Query\Parser;

/**
 * MysqlDateAddFunction ::=
 *     "MYSQL_DATE_ADD" "(" ArithmeticPrimary ", INTERVAL" ArithmeticPrimary Identifier ")"
 */
class MysqlDateAdd extends FunctionNode
{
    public $firstDateExpression = null;
    public $intervalExpression = null;
    public $unit = null;

    /**
     * Parse the DQL
     *
     * @param Parser $parser
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
     * Build the SQL
     *
     * @param SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'DATE_ADD(' .
        $this->firstDateExpression->dispatch($sqlWalker) . ', INTERVAL ' .
        $this->intervalExpression->dispatch($sqlWalker) . ' ' . $this->unit .
        ')';
    }
}
