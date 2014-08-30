<?php

namespace FXL\Component\Doctrine\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;

use Doctrine\ORM\Query\SqlWalker,
    Doctrine\ORM\Query\Lexer,
    Doctrine\ORM\Query\Parser;

/**
 * MysqlIfElseFunction ::=
 *     "MYSQL_IF_ELSE" "(" ConditionalExpression ", " ArithmeticExpression ", "ArithmeticExpression" ")"
 */
class MysqlIfElse extends FunctionNode
{
    private $condition;
    private $firstResult;
    private $secondResult;

    /**
     * Parse the DQL
     *
     * @param Parser $parser
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->condition = $parser->ConditionalExpression();

        $parser->match(Lexer::T_COMMA);
        $this->firstResult = $parser->ArithmeticExpression();

        $parser->match(Lexer::T_COMMA);
        $this->secondResult = $parser->ArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * Return the SQL
     *
     * @param SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf('IF(%s, %s, %s)',
            $sqlWalker->walkConditionalExpression($this->condition),
            $sqlWalker->walkArithmeticPrimary($this->firstResult),
            $sqlWalker->walkArithmeticPrimary($this->secondResult));
    }
}
