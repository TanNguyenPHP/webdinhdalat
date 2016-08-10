<?php
namespace Webdinhdalat\Modeldb\Models;

use Phalcon\Mvc\Model;
class Sliderpichotel extends Model
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
    public $dir;

    /**
     *
     * @var string
     */
    public $desc;

    /**
     *
     * @var string
     */
    public $position;

    /**
     *
     * @var string
     */
    public $is_show;

    /**
     *
     * @var string
     */
    public $is_del;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sliderpichotel';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Sliderpichotel[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Sliderpichotel
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public static function findAll()
    {
        return parent::find("is_del = '0' ");
    }
    public static function findAllShow()
    {
        return parent::find("is_del = '0' and is_show='1'");
    }
}
