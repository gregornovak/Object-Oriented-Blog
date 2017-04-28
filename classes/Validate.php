<?php

class Validate
{
    private $_db = null,
            $_errors = [],
            $_passed;

    /**
     * Validate constructor.
     */
    public function __construct()
    {
        $this->_db = Database::getInstance();
    }

    /**
     * @param $source
     * @param array $fields
     * @return $this
     */
    public function check($source, $fields = [])
    {
        foreach($fields as $field => $rules) {

            foreach($rules as $rule => $rule_value) {

                $value = trim($source[$field]);
                $pretty = ($rules['pretty']) ? $rules['pretty'] : '';

                if($rule == 'required' && empty($value)) {
                    $this->addError("{$pretty} je obvezno polje.");
                } else {
                    switch($rule) {
                        case 'min':
                            if(strlen($value) < $rule_value) {
                                $length_text = '';
                                if($rule_value == 1) {
                                    $length_text = 'znak';
                                } else if($rule_value == 2) {
                                    $length_text = 'znaka';
                                } else if($rule_value == 4) {
                                    $length_text = 'znake';
                                } else {
                                    $length_text = 'znakov';
                                }
                                $this->addError("Polje {$pretty} mora vsebovati vsaj {$rule_value} {$length_text}!");
                            }
                        break;

                        case 'max':
                            if(strlen($value) > $rule_value) {
                                $this->addError("Polje {$pretty} mora vsebovati {$rule_value} ali manj znakov!");
                            }
                        break;

                        case 'unique':
                            if($this->_db->select($rule_value, [$field, '=', $value])->count()){
                                $this->addError("{$value} že obstaja!");
                            }
                        break;

                        case 'matches':
                            if($value != $source[$rule_value]) {
                                $this->addError("Polji {$pretty} in {$fields[$rule_value]['pretty']} se morata ujemati!");
                            }
                        break;

                        default:
                        break;
                    }
                }
            }
        }

        if(empty($this->_errors)) {
            $this->_passed = true;
        }

        return $this;
    }

    /**
     * @param $error
     */
    private function addError($error)
    {
        $this->_errors[] = $error;
    }

    /**
     * @return array
     */
    public function errors()
    {
        return $this->_errors;
    }

    /**
     * @return mixed
     */
    public function passed()
    {
        return $this->_passed;
    }


}