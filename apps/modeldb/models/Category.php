<?php
namespace Webdinhdalat\Modeldb\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;
use Phalcon\Di;

class Category extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $desc;

    /**
     *
     * @var integer
     */
    public $pid;
    public $is_status;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'category';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public static function findAll()
    {
        return parent::find("is_status != '3'");
    }
    public static function findParent($pid="")
    {
        $queryBuilder = new \Phalcon\Mvc\Model\Query\Builder(self::buildparams($pid));

        return $queryBuilder->getQuery()->execute();
    }

    private static function buildparams($pid ="")
    {
        $conditions = "is_status != '3' ";
        if ($pid != '')
            $conditions = $conditions . "and pid = '%$pid%' ";
        return $params = array(
            'models' => array('Webdinhdalat\Modeldb\Models\Category'),
            'conditions' => $conditions,
            'orderby' => array('name')
        );
    }

}
