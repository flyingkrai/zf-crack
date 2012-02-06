<?php

/**
 * @author davi
 */
abstract class Application_Model_Entity_Base
{

    /**
     * @param string $name
     * @param string $value
     *
     * @throws Exception
     * @return $this
     */
    public function __set($name, $value)
    {
        $method = 'set' . ucfirst($name);
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid property');
        }
        $this->$method($value);

        return $this;
    }

    /**
     * @param type $name
     * @return mixed
     *
     * @throws Exception
     */
    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid property');
        }
        return $this->$method();
    }

}

?>
