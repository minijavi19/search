<?php
namespace Search\Model\Filter;

class Value extends Base
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'mode' => 'or',
    ];

    /**
     * Process a value condition ($x == $y).
     *
     * @return void
     */
    public function process()
    {
        if ($this->skip()) {
            return;
        }

        $this->query()->andWhere(function ($e) {
            /* @var $e \Cake\Database\Expression\QueryExpression */
            $value = $this->value();
            if ($value === null) {
                return $e;
            }

            $field = $this->field();

            if (strtolower($this->config('mode')) === 'or' &&
                is_array($value)
            ) {
                return $e->in($field, $value);
            }

            foreach ((array)$value as $val) {
                $e->eq($field, $val);
            }

            return $e;
        });
    }
}
